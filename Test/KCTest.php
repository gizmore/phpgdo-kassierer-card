<?php
namespace GDO\KassiererCard\Test;

use GDO\Address\GDO_Address;
use GDO\Category\GDO_Category;
use GDO\KassiererCard\KC_Business;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\KC_Offer;
use GDO\KassiererCard\KC_StarTransfer;
use GDO\KassiererCard\KC_Util;
use GDO\KassiererCard\Method\CreateCoupon;
use GDO\KassiererCard\Method\Invite;
use GDO\KassiererCard\Method\Welcome;
use GDO\Mail\Mail;
use GDO\Tests\TestCase;
use GDO\User\GDO_User;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertGreaterThan;
use function PHPUnit\Framework\assertGreaterThanOrEqual;
use function PHPUnit\Framework\assertStringContainsString;

final class KCTest extends TestCase
{

	public function testInstallerCreation(): void
	{
		# These get installed on install.
		$cats = GDO_Category::table()->countWhere();
		assertGreaterThanOrEqual(5, $cats, 'Test if kk categories were created.');

		$bizs = KC_Business::table()->countWhere();
		assertGreaterThanOrEqual(2, $bizs, 'Test if kk businesses were created.');

		$addr = GDO_Address::table()->countWhere();
		assertGreaterThanOrEqual($bizs, $addr, 'Test if kk addresses were created.');

		# This is the last in install, enough!
		$offr = KC_Offer::table()->countWhere();
		assertGreaterThanOrEqual(6, $offr, 'Test if kk offers were created.');
	}

	public function testCouponGifting(): void
	{
		$user = GDO_User::current();
		$result = $this->cli('kassierercard.admingrantstars --reason=You suck,gizmore,100');
		assertStringContainsString('granted', $result);
		$this->assertOK('Test if kassierercard.admingrantstars crashes.');
		assertGreaterThan(99, KC_Util::numStarsAvailable($user), 'Test if admingrantstars works in CLI.');
	}

	public function testCouponCreation(): void
	{
		$user = $this->testuser('Kunde1');

		$this->callMethod(Welcome::make());

		$stars = KC_Util::numStarsAvailable($user);

		$p = [
			'kc_stars' => (string)($stars),
		];
		$this->callMethod(CreateCoupon::make(), $p);

		# This shall error
		$this->callMethod(CreateCoupon::make(), $p, false);

		assertEquals(0, KC_Util::numStarsAvailable($user), 'Check if Kunde1 used all stars.');
	}

	private function testuser(string $username): GDO_User
	{
		return $this->user(GDO_User::findBy('user_name', $username));
	}

	/**
	 * Test if a cashier can invite a new user, Kassierer1 invites Kunde9.
	 * Test if all get their stars and diamonds.
	 * Todo this, grant Kassierer1 a few stars beforehand.
	 */
	public function testCashierInvitation(): void
	{
		$user = $this->testuser('Kassierer1');
		$sent = Mail::$SENT;
		$starsAvail = KC_Util::numStarsAvailable($user);
		KC_StarTransfer::freeStars($user, 10);
		assertEquals($starsAvail + 10, KC_Util::numStarsAvailable($user));
		$starsAvail += 10;
		$inputs = [
			'stars' => (string) ($starsAvail - 1),
			'email' => 'kunde2@kk.de',
			'type' => 'kk_customer',
		];
		$this->callMethod(Invite::make(), $inputs);
		assertEquals(0, KC_Util::numStarsAvailable($user), 'Assert that Kassierer1 gave all stars for an invitation.');
		assertEquals($sent + 1, Mail::$SENT, 'Test if invitation mail got sent.');

		$coupon = KC_Coupon::table()->select()->where("kc_creator={$user->getID()}")->order('kc_created DESC')->first()->exec()->fetchObject();
		assertEquals($starsAvail - 1, $coupon->getStars(), 'Test if the invitation coupon has correct amount of stars.');
	}

}

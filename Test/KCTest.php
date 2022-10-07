<?php
namespace GDO\KassiererCard\Test;

use GDO\Tests\TestCase;
use GDO\KassiererCard\KC_Business;
use function PHPUnit\Framework\assertGreaterThanOrEqual;
use GDO\Category\GDO_Category;
use GDO\Address\GDO_Address;
use GDO\KassiererCard\KC_Offer;
use GDO\User\GDO_User;
use GDO\KassiererCard\Method\CreateCoupon;
use GDO\KassiererCard\Module_KassiererCard;
use function PHPUnit\Framework\assertGreaterThan;
use GDO\KassiererCard\KC_Util;
use function PHPUnit\Framework\assertStringContainsString;

final class KCTest extends TestCase
{
	private function testuser(string $username) : GDO_User
	{
		return $this->user(GDO_User::findBy('user_name', $username));
	}
	
	public function testInstallerCreation() : void
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
	
	public function testCouponGifting() : void
	{
		$user = GDO_User::current();
		$result = $this->cli('kassierercard.admingrantstars --reason=You suck,gizmore,100');
		assertStringContainsString('granted', $result);
		$this->assertOK("Test if kassierercard.admingrantstars crashes.");
		assertGreaterThan(99, KC_Util::numStarsAvailable($user), "Test if admingrantstars works in CLI.");
	}
	
	public function testCouponCreation() : void
	{
		$this->testuser('Kunde1');
		$freeStars = Module_KassiererCard::instance()->cfgFreeStarsPerPeriod(); 
		$p = [
			'kc_stars' => $freeStars,
		];
		$this->callMethod(CreateCoupon::make(), $p);
		
		# This shall error
		$this->callMethod(CreateCoupon::make(), $p, false);
	}
	
}

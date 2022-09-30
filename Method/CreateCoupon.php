<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Validator;
use GDO\KassiererCard\GDT_CouponStars;
use GDO\KassiererCard\KC_Util;
use GDO\Core\Application;
use GDO\User\GDO_User;
use GDO\Date\Time;

final class CreateCoupon extends MethodForm
{
	public function getPermission() : ?string { return 'kk_customer,kk_company'; }
	
	public function getMethodTitle() : string
	{
		return t('create_coupon');
	}
	
	public function beforeExecute() : void
	{
		Module_KassiererCard::instance()->addCustomerBar();
	}
	
	public function createForm(GDT_Form $form): void
	{
		$user = GDO_User::current();
		$time = Application::$TIME;
		$table = KC_Coupon::table();
		$form->text('kk_info_create_coupon', [
			Module_KassiererCard::instance()->linkOffers()->render(),
			KC_Util::numCouponsCreated($user),
			KC_Util::numStarsCreatedInPeriod($user, $time),
			KC_Util::canStarsCreatedInPeriod($user, $time),
			KC_Util::maxStarsCreatedInPeriod($user, $time),
			Time::displayTimestamp(KC_Util::getPeriodStart($time), 'day'),
			Time::displayTimestamp(KC_Util::getPeriodEnd($time), 'day'),
		]);
		$stars = $table->gdoColumn('kc_stars');
		$form->addField($stars);
		$form->addField(GDT_Validator::make()->validator($form, $stars, [$this, 'validateStars']));
		$form->addField($table->gdoColumn('kc_offer'));
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}
	
	public function validateStars(GDT_Form $form, GDT_CouponStars $field, $value)
	{
		$want = $field->getValue();
		$time = Application::$TIME;
		$stars = KC_Util::numStarsCreatedInPeriod(GDO_User::current(), $time);
		$maxStars = KC_Util::maxStarsCreatedInPeriod(GDO_User::current(), $time);
		$could = $maxStars - $stars;
		if ($want > $could)
		{
			return $field->error('err_kk_create_stars', [
				$want, $could, $stars]);
		}
		return true;
	}
	
	public function formValidated(GDT_Form $form)
	{
		$vars = $form->getFormVars();
		$stars = $vars['kc_stars'];
		KC_Coupon::blank($vars)->insert();
		$by = Module_KassiererCard::instance()->cfgLevelPerPrintedCoupon();
		$by *= $stars;
		$user = GDO_User::current();
		$user->increase('user_level', $by);
		$starsBefore = $user->settingVar('KassiererCard', 'stars_created');
		$coupsBefore = KC_Util::numCustomerCouponsForStars($starsBefore);
		$starsAfter = $starsBefore + $stars;
		$coupsAfter = KC_Util::numCustomerCouponsForStars($starsAfter);
		$coupsEarned = $coupsAfter - $coupsBefore;
		
		$user->increaseSetting('KassiererCard', 'stars_created', $stars);
		
		$args = [
			$by,
			$user->getLevel(),
		];
		$this->redirectMessage('msg_coupon_created', $args, href('KassiererCard', 'PrintedCoupons'));

		if ($coupsEarned > 0)
		{
			$user->increaseSetting('KassiererCard', 'stars_entered', $coupsEarned);
			$user->increaseSetting('KassiererCard', 'stars_avaiable', $coupsEarned);
			$nowAvailable = $user->settingVar('KassiererCard', 'stars_avaiable');
			$this->message('msg_kk_earned_customer_star', [$coupsEarned, $nowAvailable]);
		}
	}
	
}

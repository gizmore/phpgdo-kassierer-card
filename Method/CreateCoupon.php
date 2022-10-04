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
use GDO\UI\GDT_Link;

final class CreateCoupon extends MethodForm
{
	public function getPermission() : ?string { return 'kk_customer,kk_manager,kk_company'; }
	
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
			GDT_Link::anchor(href('KassiererCard', 'Offers'), t('offers')),
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
		$form->addField(GDT_Validator::make()->validator($form, $stars, [$this, 'validateSunday']));
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
	
	public function validateSunday(GDT_Form $form, GDT_CouponStars $field, $value)
	{
		if (GDO_User::current()->hasPermission('kk_distributor'))
		{
			return true;
		}
		if ($this->isSunday())
		{
			return $field->error('err_print_sundays');
		}
		return true;
	}
	
	private function isSunday() : bool
	{
		return Time::getDate(0, 'N') === '7';
	}
	
	public function formValidated(GDT_Form $form)
	{
		$vars = $form->getFormVars();
		$vars['kc_type'] = 'kk_coupon';
		KC_Coupon::blank($vars)->insert();
		$this->redirectMessage('msg_coupon_created', null, href('KassiererCard', 'PrintedCoupons'));
		
		# THIS DO ON COUPON ENTERED
// 		$stars = $vars['kc_stars'];
// 		$by = Module_KassiererCard::instance()->cfgLevelPerPrintedCoupon();
// 		$by *= $stars;
// 		$user = GDO_User::current();
// 		$user->increase('user_level', $by);
// 		$starsBefore = $user->settingVar('KassiererCard', 'stars_created');
// 		$coupsBefore = KC_Util::numCustomerCouponsForStars($starsBefore);
// 		$starsAfter = $starsBefore + $stars;
// 		$coupsAfter = KC_Util::numCustomerCouponsForStars($starsAfter);
// 		$coupsEarned = $coupsAfter - $coupsBefore;
		
// 		$user->increaseSetting('KassiererCard', 'stars_created', $stars);
		
// 		$args = [
// 			$by,
// 			$user->getLevel(),
// 		];
// 		$this->redirectMessage('msg_coupon_created', $args, href('KassiererCard', 'PrintedCoupons'));

// 		if ($coupsEarned > 0)
// 		{
// 			$user->increaseSetting('KassiererCard', 'stars_entered', $coupsEarned);
// 			$user->increaseSetting('KassiererCard', 'stars_available', $coupsEarned);
// 			$nowAvailable = $user->settingVar('KassiererCard', 'stars_available');
// 			$this->message('msg_kk_earned_customer_star', [$coupsEarned, $nowAvailable]);
// 		}
	}
	
}

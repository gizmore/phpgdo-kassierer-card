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

final class CreateCoupon extends MethodForm
{
	public function beforeExecute() : void
	{
		Module_KassiererCard::instance()->addCustomerBar();
	}
	
	public function createForm(GDT_Form $form): void
	{
		$user = GDO_User::current();
		$time = KC_Util::getPeriodStart(Application::$TIME);
		$table = KC_Coupon::table();
		$form->text('kk_info_create_coupon', [
			KC_Util::numCouponsCreated($user),
			KC_Util::numStarsCreated($user),
			KC_Util::canStarsCreatedInPeriod($user, $time),
			KC_Util::maxStarsCreatedInPeriod($user, $time),
		]);
		$stars = $table->gdoColumn('coup_stars');
		$form->addField($stars);
		$form->addField(GDT_Validator::make()->validator($form, $stars, [$this, 'validateStars']));
		$form->addField($table->gdoColumn('coup_type'));
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}
	
	public function validateStars(GDT_Form $form, GDT_CouponStars $field, $value)
	{
		$want = $field->getValue();
		$stars = KC_Util::numStarsCreatedInPeriod(GDO_User::current(), Application::$TIME);
		$maxStars = KC_Util::maxStarsCreatedInPeriod(GDO_User::current(), Application::$TIME);
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
		KC_Coupon::blank($vars)->insert();
		return $this->redirectMessage('msg_coupon_created', null, href('KassiererCard', 'PrintedCoupons'));
	}
	
}

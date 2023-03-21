<?php
namespace GDO\KassiererCard\Method;

use GDO\Date\Time;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_CouponStars;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\KC_Util;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\User\GDO_User;

/**
 * Let Customers create Cashier Coupons.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class CreateCoupon extends MethodForm
{

	public function getPermission(): ?string
	{
		return 'kk_customer,kk_manager,kk_company';
	}

	public function getMethodTitle(): string
	{
		return t('create_coupon');
	}

	public function beforeExecute(): void
	{
		Module_KassiererCard::instance()->addCustomerBar();
	}

	public function createForm(GDT_Form $form): void
	{
		$user = GDO_User::current();
		$table = KC_Coupon::table();
		$form->text('kk_info_create_coupon', [
			KC_Util::numStarsAvailable($user),
		]);
		$stars = GDT_CouponStars::make('kc_stars')->initial('1')->min(1)->max(KC_Util::numStarsAvailable($user));
		$form->addField($stars);
		$form->addField($table->gdoColumn('kc_offer'));
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form)
	{
		$vars = $form->getFormVars();
		$vars['kc_type'] = 'kk_coupon';
		KC_Coupon::blank($vars)->insert();
		$user = GDO_User::current();
		$stars = $form->getFormVar('kc_stars');
		$user->increaseSetting('KassiererCard', 'stars_available', -$stars);
		return $this->redirectMessage('msg_coupon_created', null,
			href('KassiererCard', 'PrintedCoupons'));
	}

	private function isSunday(): bool
	{
		return Time::getDate(0, 'N') === '7';
	}

}

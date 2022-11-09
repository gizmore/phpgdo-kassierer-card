<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\GDT_Coupon;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\QRCode\GDT_QRCode;
use GDO\Core\GDT_Tuple;
use GDO\UI\GDT_Container;
use GDO\UI\GDT_Image;
use GDO\Core\GDT;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;

/**
 * Print one of your coupons.
 * 
 * @author gizmore
 */
final class PrintCoupon extends MethodForm
{
	public function beforeExecute() : void
	{
		Module_KassiererCard::instance()->addCustomerBar();
	}
	
	public function isSidebarEnabled() : bool
	{
		if ($this->getForm()->hasError())
		{
			return true;
		}
		return
			($this->pressedButton !== 'btn_qrcode') &&
			($this->pressedButton !== 'btn_print');
	}
	
	public function createForm(GDT_Form $form) : void
	{
		$form->text('kk_info_print_coupon');
		$coupon = GDT_Coupon::make('token')->label('code')->notNull()->onlyOwnCreated()->writeable(true);
		$form->addFields(
			$coupon,
// 			GDT_Slogan::make('slogan')->notNull()->initialRandom(),
			GDT_AntiCSRF::make(),
		);
		if (GDO_User::current()->hasPermission('kk_manager'))
		{
			$form->actions()->addField(GDT_Submit::make('btn_preview')->onclick([$this, 'preview']));
		}
		$form->actions()->addFields(
			GDT_Submit::make('btn_qrcode')->onclick([$this, 'qrcode']),
			GDT_Submit::make('btn_print')->onclick([$this, 'print']),
			GDT_Submit::make('btn_print_flyer')->onclick([$this, 'printFlyer']),
			);
	}
	
	public function getCoupon() : KC_Coupon
	{
		return $this->gdoParameterValue('token');
	}
	
	public function getSlogan() : string
	{
		return $this->gdoParameterVar('slogan');
	}

	public function preview() : GDT_Tuple
	{
		return GDT_Tuple::make()->addFields(
			$this->previewLink(),
			$this->print(),
			parent::renderPage()
		);
	}
	
	private function previewLink() : GDT_Link
	{
		$coupon = $this->getCoupon();
		return GDT_Link::make('link_preview_enter_coupon')->href($coupon->hrefEnter());
	}
	
	public function qrcode() : GDT_QRCode
	{
		$coupon = $this->getCoupon();
		$coupon->onPrinted();
		return $coupon->getQRCode();
	}
	
	public function print() : GDT
	{
		$coupon = $this->getCoupon();
		$coupon->onPrinted();
		$cont = GDT_Container::make('images')
		->horizontal()
		->addClass('kk-print-card-row');
		$cont->addFields(
			$this->printFront(),
			$this->printBack());
		return $cont;
	}
	
	private function printFront() : GDT_Image
	{
		return $this->getCoupon()->getFrontSide();
	}
	
	private function printBack() : GDT_Image
	{
		return $this->getCoupon()->getBackSide();
	}
	
	public function printFlyer() : GDT
	{
		$coupon = $this->getCoupon();
		$coupon->onPrinted();
		$cont = GDT_Container::make('images')
		->horizontal()
		->addClass('kk-print-card-row');
		$cont->addField($this->getCoupon()->getFrontSideFlyer());
		return $coupon->getFrontSideFlyer();
	}
	
}

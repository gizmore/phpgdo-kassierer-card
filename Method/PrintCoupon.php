<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\GDT_Coupon;
use GDO\KassiererCard\GDT_Slogan;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\KC_Slogan;
use GDO\QRCode\GDT_QRCode;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\Core\GDT_Tuple;
use GDO\UI\GDT_Container;
use GDO\UI\GDT_Image;

/**
 * Print one of your coupons.
 * 
 * @author gizmore
 *
 */
final class PrintCoupon extends MethodForm
{
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
		$coupon = GDT_Coupon::make('token')->label('code')->notNull()->onlyOwnCreated()->writeable(false);
		$form->addFields(
			$coupon,
			GDT_Slogan::make('slogan'),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make('btn_preview')->onclick([$this, 'preview']));
		$form->actions()->addField(GDT_Submit::make('btn_print')->onclick([$this, 'print']));
		$form->actions()->addField(GDT_Submit::make('btn_qrcode')->onclick([$this, 'qrcode']));
// 		$form->targetBlank();
	}
	
	public function getCoupon() : KC_Coupon
	{
		return $this->gdoParameterValue('token');
	}
	
	public function getSlogan() : string
	{
		return $this->gdoParameterVar('slogan');
	}

	public function preview()
	{
		return GDT_Tuple::make()->addFields(
			$this->qrcode(),
			$this->print(),
			parent::renderPage()
		);
	}
	
	public function qrcode()
	{
		$coupon = $this->getCoupon();
		return GDT_QRCode::make()->qrcodeSize($this->qrcodeSize())->var($coupon->urlEnter());
	}
	
	private function qrcodeSize()
	{
		return Module_KassiererCard::instance()->cfgQRCodeSize();
	}

	public function print()
	{
		$cont = GDT_Container::make('images')->horizontal();
		$cont->addFields($this->printFront(), $this->printBack());
		return $cont;
	}
	
	private function printFront()
	{
		$coupon = $this->getCoupon();
		$href = $coupon->hrefSVGFront();
		return GDT_Image::make('front')->src($href);
	}

	private function printBack()
	{
		$coupon = $this->getCoupon();
		$href = $coupon->hrefSVGFront();
		return GDT_Image::make('back')->src($href);
	}

}

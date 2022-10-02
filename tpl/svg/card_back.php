<?php
namespace GDO\KassiererCard\tpl\svg;
use GDO\KassiererCard\KC_Coupon;
/** @var $coupon KC_Coupon **/
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="1050px" height="600px" viewBox="0 0 1050 600" enable-background="new 0 0 1050 600"
	 xml:space="preserve">
<style type="text/css">
@font-face {
	font-family: Myriad;
	src: url('<?=GDO_WEB_ROOT?>GDO/KassiererCard/thm/kkorg/fonts/Myriad_Pro_Bold.ttf');
}
text {
	font-family: Myriad;
	font-weight: bold;
	color: #fff;
}
.txt {
	font-size: 600px;
}
.code {
	font-size: 35px;
}
.fineprint {
	font-size: 35px;
}

</style>
<rect x="0" y="0" width="1050" height="600" style="fill:#Fff;"></rect>
<rect rx="10" ry="10" x="0" y="0" width="1050" height="600" style="fill:#F94600;"></rect>
<text x="-20" y="510" fill="#ffffff" stroke="#ffffff" class="txt">K</text>  
<text x="270" y="510" fill="#ffffff" stroke="#ffffff" class="txt">C</text>
<text x="50%" y="50" fill="#ffffff" stroke="#ffffff" class="code" dominant-baseline="middle" text-anchor="middle"><?=t('your_ad_here')?></text>
<text x="50%" y="560" fill="#ffffff" stroke="#ffffff" class="fineprint" dominant-baseline="middle" text-anchor="middle"><?=$coupon->renderSlogan()?></text>
<image x="622" y="105" width="410" height="410" xlink:href="data:image/png;base64,<?=$coupon->getQRCode()->renderBase64()?>"></image>
</svg>

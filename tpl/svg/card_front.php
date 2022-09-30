<?php
namespace GDO\KassiererCard\tpl\svg;
use GDO\UI\GDT_Image;
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
.fineprint {
	font-size: 95px;
}
</style>
<rect x="0" y="0" width="1050" height="600" style="fill:#Fff;" />
<rect rx="10" ry="10" x="20" y="20" width="1010" height="1010" style="fill:#F94600;" />
<text x="-20" y="510" fill="#ffffff" stroke="#ffffff" class="txt">K</text>  
<text x="270" y="510" fill="#ffffff" stroke="#ffffff" class="txt">C</text>
<text x="30" y="580" fill="#ffffff" stroke="#ffffff" class="fineprint">www.KassiererCard.org</text>
<?=GDT_Image::make()->src($coupon->urlEnter())->render()?>
</svg>

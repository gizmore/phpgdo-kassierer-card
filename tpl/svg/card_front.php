<?php
namespace GDO\KassiererCard\tpl\svg;
use GDO\UI\GDT_Image;
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
	letter-spacing: 7.8px;
	font-size: 80px;
}
</style>
<rect x="0" y="0" width="1050" height="600" style="fill:#fff;"></rect>
<rect rx="10" ry="10" x="0" y="0" width="1050" height="600" style="fill:#F94600;"></rect>
<text x="-20" y="510" fill="#ffffff" stroke="#ffffff" class="txt">K</text>  
<text x="270" y="510" fill="#ffffff" stroke="#ffffff" class="txt">C</text>
<text x="30" y="580" fill="#ffffff" stroke="#ffffff" class="fineprint">www.KassiererCard.org</text>
<image x="622" y="105" width="410" height="410" xlink:href="data:image/png;base64,<?=$coupon->getQRCode()->renderBase64()?>"></image>
<?php
$x = 2;
$y = 600;
$margin = 1;
$padding = 2;
$dash = 1;
$x = $margin;
$code = $coupon->getToken();
$c = 0;
for ($i = 0; $i < 5; $i++)
{
	for ($j = 0; $j < 2; $j++)
	{
		$ch = $code[$c++];
		$w = (100 - ($margin * 2) - ($dash * 4) - ($padding * 20)) / 10;
		$xc = $x + (($w + $padding) / 2.0) - 0.1;
		$h = 9;
		$y = 4.2;
		$yc = $y + 4.5 + $padding;
		$x += $padding;
		printf("<rect x=\"%.02f%%\" y=\"%.02f%%\" width=\"%.02f%%\" height=\"%.02f%%\" style=\"fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0)\" />\n",
			$x, $y, $w, $h);
		$x += $w;
		$x += $padding;
		printf("<text class=\"code\" x=\"%.02f%%\" y=\"%.02f%%\">%s</text>",
			$xc, $yc, $ch);
	}
	if ($i < 4)
	{
		printf("<rect x=\"%.02f%%\" y=\"%.02f%%\" width=\"%.02f%%\" height=\"%.02f%%\" style=\"fill:rgb(0,0,0);stroke-width:3;stroke:rgb(0,0,0)\" />\n",
			$x, $y + 3.8, $dash, 1.0,
		);
	}
	$x += $dash;
}
?>
</svg>

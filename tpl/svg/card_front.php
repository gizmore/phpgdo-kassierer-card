<?php
namespace GDO\KassiererCard\tpl\svg;
$w = 1050;
$h = 600;
?>
<svg version="1.1"
     width="1050" height="600"
     xmlns="http://www.w3.org/2000/svg">
     

  <rect width="100%" height="100%" fill="#F94600" />
  <text x="380" y="500" font-size="600" text-anchor="middle" fill="#FFFFFF">KC</text>

<?php
$x = 2;
$y = 600;
$margin = 1;
$padding = 2;
$dash = 1;
$x = $margin;
for ($i = 0; $i < 5; $i++)
{
	for ($j = 0; $j < 2; $j++)
	{
		$w = (100 - ($margin * 2) - ($dash * 4) - ($padding * 20)) / 10;
		$h = 6;
		$y = 5;
		$x += $padding;
		printf("<rect x=\"%.02f%%\" y=\"%.02f%%\" width=\"%.02f%%\" height=\"%.02f%%\" style=\"fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0)\" />\n",
			$x, $y, $w, $h);
		$x += $w;
		$x += $padding;
	}
	
	if ($i < 4)
	printf("<rect x=\"%.02f%%\" y=\"%.02f%%\" width=\"%.02f%%\" height=\"%.02f%%\" style=\"fill:rgb(255,255,255);stroke-width:3;stroke:rgb(0,0,0)\" />\n",
		$x, $y + 2.5, $dash/1.41, 1.0,
		);
	$x += $dash;
}
?>

  <text x="1%" y="95%" font-size="10" text-anchor="left" fill="#FFFFFF">KassiererCard.Org</text>

</svg>

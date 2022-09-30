<?php
namespace GDO\KassiererCard\tpl;
/** @var $field \GDO\KassiererCard\GDT_CouponToken **/
?>
<div class="kc-coupon-token gdt-container<?=$field->classError()?>">
<label<?=$field->htmlForID()?>><?=$field->htmlIcon()?><?=$field->renderLabel()?></label>
<input
<?=$field->htmlFocus()?>
<?=$field->htmlID()?>
 type="text"
<?=$field->htmlName()?>
<?=$field->htmlDisabled()?>
<?=$field->htmlRequired()?>
<?=$field->htmlFocus()?>
<?=$field->htmlValue()?>>
  <?=$field->htmlError()?>
</div>

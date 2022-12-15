<?php
namespace GDO\KassiererCard\tpl;
/** @var $field \GDO\KassiererCard\GDT_CouponToken **/
?>
<div class="kc-coupon-token gdt-container<?=$field->classError()?>">
 <div class="form-label">
  <label<?=$field->htmlForID()?>>
   <?=$field->htmlIcon()?>
   <?=$field->renderLabel()?>
  </label>
 </div>
 <div class="inner-form-input">
  <input
   class="form-control"
<?=$field->htmlConfig()?>
<?=$field->htmlID()?>
<?=$field->htmlAttributes()?>
<?=$field->htmlFocus()?>
   type="text"
   autocomplete="off"
<?=$field->htmlName()?>
<?=$field->htmlDisabled()?>
<?=$field->htmlRequired()?>
<?=$field->htmlFocus()?>
<?=$field->htmlValue()?>>
  </div>
  <div class="cb"></div>
<?=$field->htmlError()?>
</div>
<div class="cb"></div>

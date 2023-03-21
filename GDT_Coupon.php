<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Object;
use GDO\User\GDO_User;

/**
 * A Coupon object.
 * No completion.
 *
 * @author gizmore
 */
final class GDT_Coupon extends GDT_Object
{

	public bool $onlyOwnCreated = false;

	################
	### Only Own ###
	################

	protected function __construct()
	{
		parent::__construct();
		$this->table(KC_Coupon::table());
	}

	public function onlyOwnCreated(bool $bool = true): self
	{
		$this->onlyOwnCreated = $bool;
		return $this;
	}

	public function validate($value): bool
	{
		if (!parent::validate($value))
		{
			return false;
		}

		if ($value === null)
		{
			return true;
		}

		if ($this->onlyOwnCreated)
		{
			if (!$this->validatePrintPermission($value))
			{
				return false;
			}
		}
		return true;
	}

	private function validatePrintPermission(KC_Coupon $value): bool
	{
		if (!$value->canPrint(GDO_User::current()))
		{
			return $this->error('err_unknown_coupon');
		}
		return true;
	}

}

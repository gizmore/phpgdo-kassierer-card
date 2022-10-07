<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\User\GDO_User;
use GDO\User\GDO_UserPermission;
use GDO\Core\Website;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Checkbox;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_CreatedAt;
use GDO\Mail\Mail;

final class KC_SignupCode extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('sc_id'),
			GDT_AccountType::make('sc_type')->notNull(),
			GDT_CouponStars::make('sc_stars')->min(0)->max(1000)->initial('1'),
			GDT_String::make('sc_info'),
			GDT_CouponToken::make('sc_token')->initialNull()->notNull()->unique(),
			GDT_CreatedAt::make('sc_created'),
			GDT_CreatedBy::make('sc_creator'),
		];
	}
	
	public function getType() : string
	{
		return $this->gdoVar('sc_type');
	}
	
	public function renderType() : string
	{
		return $this->gdoColumn('sc_type')->render();
	}
	
	public function getStars() : string
	{
		return $this->gdoVar('sc_stars');
	}
	
	public function getToken() : string
	{
		return $this->gdoVar('sc_token');
	}
	
	public function getCreator(): ?GDO_User
	{
		return $this->gdoValue('sc_creator');
	}
	
	####
	public function href_kca_print() : string
	{
		return href('KassiererCard', 'PrintCoupon', "&token={$this->getToken()}");
	}
	
	public function createCouponForSignupCode() : void
	{
		KC_Coupon::createSignupCoupon($this);
	}

	##############
	### Static ###
	##############
	public static function validateCode(string $token, string $type) : bool
	{
		if (!($code = self::table()->getBy('sc_token', $token)))
		{
			return false;
		}
		if ($code->getType() !== $type)
		{
			return false;
		}
		return true;
	}
	
	public static function onActivation(GDO_User $user, ?string $token) : bool
	{
		if ($code = self::getBy('sc_token', $token))
		{
			if ($type = $code->getType())
			{
				GDO_UserPermission::grant($user, $type);
				$user->changedPermissions();
			}
			
			if ($coupon = KC_Coupon::getBy('kc_token', $token))
			{
				if ($stars = $coupon->getStars())
				{
					$user->increaseSetting('KassiererCard', 'stars_earned', $stars);
					$user->increaseSetting('KassiererCard', 'stars_available', $stars);
					Website::message('KassiererCard', 'msg_signup_stars', [
						sitename(),
						$stars,
					]);
				}
				if ($coupon->isUserInvitation())
				{
					$creator = $code->getCreator();
					$creator->increaseSetting('KassiererCard', 'diamonds_earned', $stars);
					self::sendDiamondMail($creator, $user, $stars);
				}
			}
			$code->delete();
			return true;
		}
		else
		{
			GDO_UserPermission::grant($user, 'kk_customer');
			Website::message('KassiererCard', 'msg_signup_customer_no_token');
		}
		
		return false;
	}
	
	
		
}

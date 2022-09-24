<?php
namespace GDO\KassiererCard;

use GDO\Category\GDO_Category;
use GDO\Address\GDO_Address;
use GDO\Country\GDO_Country;
use GDO\User\GDO_Permission;
use GDO\Language\Module_Language;
use GDO\Core\Module_Core;
use GDO\CountryRestrictions\Module_CountryRestrictions;
use GDO\User\GDO_User;
use GDO\User\GDO_UserPermission;
use GDO\Crypto\BCrypt;

final class Install
{
	public static function install(Module_KassiererCard $module) : bool
	{
		return
			self::installConfig() &&
			self::installSlogans() &&
			self::installPermissions() &&
			self::installCategories($module) &&
			self::installUsers() &&
			self::installBusinesses($module) &&
			self::installPartners();
	}

	private static function installUsers() : bool
	{
		$accounts = require 'accounts.php';
		foreach ($accounts as $data)
		{
			self::installUser(...$data);
		}
		return true;
	}
	
	private static function installUser(int $id, string $nickname, string $password, string $perms) : bool
	{
		if (!($user = GDO_User::getById($id)))
		{
			$user = GDO_User::blank([
				'user_id' => $id,
				'user_type' => 'member',
				'user_name' => $nickname,
				'user_password' => BCrypt::create($password)->__toString(),
			])->insert();
		}
		foreach (explode(',', $perms) as $perm)
		{
			GDO_UserPermission::grant($user, $perm);
		}
		$user->changedPermissions();
		return true;
	}
	
	private static function installConfig() : bool
	{
		Module_Core::instance()->saveConfigVar('allow_guests', '0');
		Module_Language::instance()->saveConfigVar('languages', '["en","de"]');
		Module_Language::instance()->saveConfigVar('use_in_javascript', '0');
		Module_CountryRestrictions::instance()->saveConfigVar('country_whitelist', '["DE"]');
		return true;
	}
	
	private static function installSlogans() : bool
	{
		self::installSlogan(1, 'Es wurde auch Zeit');
		return true;
	}
	
	private static function installSlogan(int $id, string $text) : void
	{
		if (!($slogan = KC_Slogan::getById($id)))
		{
			$slogan = KC_Slogan::blank(['s_id' => $id]);
		}
		$slogan->setVars([
			's_text' => $text,
		]);
		$slogan->save();
	}
	
	private static function installPermissions() : bool
	{
		# Perms
		GDO_Permission::create('kk_cashier', 300);
		GDO_Permission::create('kk_company', 200);
		GDO_Permission::create('kk_customer', 100);
		return true;
	}

	private static function installCategories(Module_KassiererCard $module) : bool
	{
		self::cat(1, 'Businesses', null);
		self::cat(2, 'Supermarket', 1);
		self::cat(3, 'Bakery', 1);
		self::cat(4, 'Slaughter', 1);
		self::cat(5, 'Office', 1);
		self::cat(6, 'Restaurant', 1);
		GDO_Category::table()->rebuildFullTree();
		return true;
	}
	
	private static function cat(string $id, string $name, ?string $parent) : bool
	{
		if (!($cat = GDO_Category::getById($id)))
		{
			return !!GDO_Category::blank([
				'cat_id' => $id,
				'cat_name' => $name,
				'cat_parent' => $parent,
			])->insert();
		}
		return !!$cat->saveVars([
			'cat_name' => $name,
			'cat_parent' => $parent,
		]);
	}

	private static function installBusinesses(Module_KassiererCard $module) : bool
	{
		self::biz(1, 'REWE', 2, 'Celler Straße 51-55', '31224', 'Peine', 52.32999367361805, 10.232796189181226, '+49 5171 71282');
		self::biz(2, 'EDEKA Center Peine', 2, 'Friedrich-Ebert-Platz 25', '31226', 'Peine', 52.31740702775802, 10.22991038947184, '+49 5171 9550');
		return true;
	}
	
	private static function biz(string $id, string $name, string $category, ?string $street, ?string $zip, ?string $city, float $lat=null, float $lng=null, string $phone=null, string $country='DE') : bool
	{
		if (!($addr = GDO_Address::getById($id+100000)))
		{
			$addr = GDO_Address::blank([
				'address_id' => $id + 100000,
				'address_company' => $name,
				'address_vat' => null,
				'address_name' => null,
				'address_street' => $street,
				'address_zip' => $zip,
				'address_city' => $city,
				'address_country' => GDO_Country::findById($country)->getID(),
				'address_phone' => $phone,
				'address_phone_fax' => null,
				'address_phone_mobile' => null,
				'address_email' => null,
			])->insert();
		}
		else
		{
			$addr->saveVars([
				'address_company' => $name,
				'address_vat' => null,
				'address_name' => null,
				'address_street' => $street,
				'address_zip' => $zip,
				'address_city' => $city,
				'address_country' => GDO_Country::findById($country)->getID(),
				'address_phone' => $phone,
				'address_phone_fax' => null,
				'address_phone_mobile' => null,
				'address_email' => null,
			]);
		}
		
		if (!($biz = KC_Business::getById($id)))
		{
			$biz = KC_Business::blank([
				'biz_id' => $id,
				'biz_address' => $addr->getID(),
				'biz_coord_lat' => $lat,
				'biz_coord_lng' => $lng,
				'biz_category' => $category,
			])->insert();
		}
		else
		{
			$biz->saveVars([
				'biz_address' => $addr->getID(),
				'biz_coord_lat' => $lat,
				'biz_coord_lng' => $lng,
				'biz_category' => $category,
			]);
		}
		
		return !!$biz;
	}

	private static function installPartners() : bool
	{
		$descr = 'Der beste Döner in Peine, knusprig und preiswert.<br/>Das Original - Nur bei Saray Ali!';
		self::partner(1, 6, 'Saray Imbiss Peine', 'Marktstraße 23', '31224', 'Peine', 'DE', '+49 5171 / 37 40', $descr);
		return true;
	}
	
	private static function partner(int $id, int $cat, string $name, string $street, string $zip, string $city, string $country, string $phone, string $descr) : void
	{
		if (!($addr = GDO_Address::getById($id+200000)))
		{
			$addr = GDO_Address::blank([
				'address_id' => $id + 200000,
				'address_company' => $name,
				'address_vat' => null,
				'address_name' => null,
				'address_street' => $street,
				'address_zip' => $zip,
				'address_city' => $city,
				'address_country' => GDO_Country::findById($country)->getID(),
				'address_phone' => $phone,
				'address_phone_fax' => null,
				'address_phone_mobile' => null,
				'address_email' => null,
			])->insert();
		}
		else
		{
			$addr->saveVars([
				'address_company' => $name,
				'address_vat' => null,
				'address_name' => null,
				'address_street' => $street,
				'address_zip' => $zip,
				'address_city' => $city,
				'address_country' => GDO_Country::findById($country)->getID(),
				'address_phone' => $phone,
				'address_phone_fax' => null,
				'address_phone_mobile' => null,
				'address_email' => null,
			]);
		}
		if (!($p = KC_Partner::getById($id)))
		{
			$p = KC_Partner::blank([
				'p_id' => $id,
				'p_address' => $addr->getID(),
				'p_category' => $cat,
				'p_description' => $descr,
			])->insert();
		}
		else
		{
			$p->saveVars([
				'p_address' => $addr->getID(),
				'p_category' => $cat,
				'p_description' => $descr,
			]);
		}
	}
	
}

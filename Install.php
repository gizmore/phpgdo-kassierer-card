<?php
namespace GDO\KassiererCard;

use GDO\Category\GDO_Category;
use GDO\Address\GDO_Address;
use GDO\Country\GDO_Country;
use GDO\User\GDO_Permission;

final class Install
{
	public static function install(Module_KassiererCard $module) : bool
	{
		return
			self::installPermissions() &&
			self::installCategories($module) &&
			self::installBusinesses($module);
	}
	
	private static function installPermissions() : bool
	{
		# Perms
		GDO_Permission::create('kk_cashier', 100);
		GDO_Permission::create('kk_company', 200);
		GDO_Permission::create('kk_customer', 300);
		return true;
	}

	private static function installCategories(Module_KassiererCard $module) : bool
	{
		self::cat(1, 'Businesses', null);
		self::cat(2, 'Supermarket', 1);
		self::cat(3, 'Bakery', 1);
		self::cat(4, 'Slaughter', 1);
		self::cat(5, 'Office', 1);
		GDO_Category::table()->rebuildFullTree();
		return true;
	}
	
	private static function cat(string $id, string $name, ?string $parent) : bool
	{
		return !!GDO_Category::blank([
			'cat_id' => $id,
			'cat_name' => $name,
			'cat_parent' => $parent,
		])->replace();
	}

	private static function installBusinesses(Module_KassiererCard $module) : bool
	{
		self::biz(1, 'REWE', 2, 'Celler Straße 51-55', '31224', 'Peine', 52.32999367361805, 10.232796189181226, '+49 5171 71282');
		self::biz(2, 'EDEKA Center Peine', 2, 'Friedrich-Ebert-Platz 25', '31226', 'Peine', 52.31740702775802, 10.22991038947184, '+49 5171 9550');
		return true;
	}
	
	private static function biz(string $id, string $name, string $category, ?string $street, ?string $zip, ?string $city, float $lat=null, float $lng=null, string $phone=null, string $country='DE') : bool
	{
		if (!($addr = GDO_Address::getById($id+100)))
		{
			$addr = GDO_Address::blank([
				'address_id' => $id + 100,
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

}

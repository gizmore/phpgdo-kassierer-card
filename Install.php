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
use GDO\News\GDO_News;
use GDO\Avatar\Module_Avatar;

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
			self::installPartners() &&
			self::installNews();
	}

	private static function installConfig() : bool
	{
		Module_Avatar::instance()->saveConfigVar('hook_sidebar', '0');
		Module_Core::instance()->saveConfigVar('allow_guests', '0');
		Module_CountryRestrictions::instance()->saveConfigVar('country_whitelist', '["DE"]');
		Module_Language::instance()->saveConfigVar('languages', '["en","de"]');
		Module_Language::instance()->saveConfigVar('use_in_javascript', '0');
		return true;
	}
	
	private static function installSlogans() : bool
	{
		$data = [
			'Es wurde auch Zeit',
			'Alles geht, nix muss',
			'Denkt mal drüber nach',
		];
		$i = 0;
		foreach ($data as $slogan)
		{
			self::installSlogan(++$i, $slogan);
		}
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
	
	##################
	### Categories ###
	##################
	private static function installCategories(Module_KassiererCard $module) : bool
	{
		self::cat(1, 'Businesses', null);
		self::cat(2, 'Supermarket', 1);
		self::cat(3, 'Bakery', 1);
		self::cat(4, 'Slaughter', 1);
		self::cat(5, 'Office', 1);
		self::cat(6, 'Restaurant', 1);
		
		self::cat(101, 'News', null);
		self::cat(102, 'KassiererNews', 101);
		
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
	
	private static function installUsers() : bool
	{
		$accounts = require 'accounts.php';
		foreach ($accounts as $data)
		{
			self::installUser(...$data);
		}
		return true;
	}
	
	private static function installUser(string $id, string $nickname, string $password, string $perms) : bool
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
	
	###########
	### Biz ###
	###########
	private static function installBusinesses(Module_KassiererCard $module) : bool
	{
		$i = 1;
		self::biz($i++, 'REWE Markt Peine',   2, 'Schäferstraße 12',         '31224', 'Peine', 52.32101586390254, 10.24893384967010, '+49 5171 58 315 87');
		self::biz($i++, 'REWE Markt Peine',   2, 'Celler Straße 51-55',      '31224', 'Peine', 52.32999367361805, 10.23279618918122, '+49 5171 712 82');
		self::biz($i++, 'EDEKA Center Peine', 2, 'Friedrich-Ebert-Platz 25', '31226', 'Peine', 52.31740702775802, 10.22991038947184, '+49 5171 95 50');
		self::biz($i++, 'Penny Markt Peine',  2, 'Duttenstedter Str. 136',   '31224', 'Peine', 52.32887785039469, 10.25016182443094, '+49 221 2019 9959');
		self::biz($i++, 'NP-Markt Peine',     2, 'Sedanstraße 41',           '31224', 'Peine', 52.32509004097773, 10.23358606569167, '+49 5171 14 145');
		self::biz($i++, 'Jawoll Peine',       2, 'Woltorfer Str. 102',       '31224', 'Peine', 52.31962953955457, 10.24794936924906, '+49 05191 980 30');
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

	###############
	### Partner ###
	###############
	private static function installPartners() : bool
	{
		$descr = 'Der beste Döner in Peine, knusprig und preiswert.<br/>Das Original - Nur bei Saray Ali!';
		self::partner(1, 5, 6, 'Saray Imbiss Peine', 'Marktstraße 23', '31224', 'Peine', 'DE', '+49 5171 / 37 40', $descr);
		return true;
	}
	
	private static function partner(int $id, int $userId, int $cat, string $name, string $street, string $zip, string $city, string $country, string $phone, string $descr) : void
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
				'p_user' => $userId,
				'p_address' => $addr->getID(),
				'p_category' => $cat,
				'p_description' => $descr,
			])->insert();
		}
		else
		{
			$p->saveVars([
				'p_user' => $userId,
				'p_address' => $addr->getID(),
				'p_category' => $cat,
				'p_description' => $descr,
			]);
		}
	}
	
	private static function installNews() : bool
	{
		$titleEn = 'First Card printed!';
		$titleDe = 'Erste Karte gedruckt!';
		$messageEn = <<<EOT
Hi am Happy to announce!<br/>
<br/>
KassiererCard.org has reached phase 1.<br/>
<br/>
In this phase, we test the service with only a few customers, empolyees, workers and partners.<br/>
<br/>
We currently have no real partner who is aiding us financially, but we are looking.<br/>
First offers are on our cap.<br/>
<br/>
 - gizmore
EOT;
		$messageDe = <<<EOT
Voller Stolz presentiere ich die erste KassiererCard<br/>
<br/>
KassiererCard.org hat Phase 1 erreicht.<br/>
<br/>
In dieser Phase testen wir den Service mit nur wenigen Kunde, Angestellten, Arbeitern und Werbepartnern.<br/>
<br/>
Wir haben noch keine echten Werbepartner, die uns unterstützen, wir suchen aber nach Gelegenheiten.<br/>
Die ersten Angebote gehen auf unsere Kappe!<br/>
<br/>
 - gizmore
EOT;
		$date = '2022-09-24 13:37:42.666';
		self::installNewsEntry(1, 102, $date, 'en', $titleEn, $messageEn);
		self::installNewsEntry(1, 102, $date, 'de', $titleDe, $messageDe);
		
		return true;
	}
	
	private static function installNewsEntry(string $id, string $cat, string $date, string $iso, string $title, string $message, string $uid='2')
	{
		if ($news = GDO_News::table()->getById(1))
		{
			$news->saveVars([
				'news_category' => $cat,
				'news_visible' => '1',
				'news_created' => $date,
				'news_creator' => $uid,
			]);
		}
		else {
			$news = GDO_News::blank([
				'news_id' => $id,
				'news_category' => $cat,
				'news_visible' => '1',
				'news_created' => $date,
				'news_creator' => $uid,
			])->insert();
		}
		return self::installNewsText($news, $iso, $title, $message, $uid);
	}
	
	private static function installNewsText(GDO_News $news, string $iso, string $title, string $message, string $uid='2')
	{
		$text = $news->getText($iso, false);
		if ($text->isPersisted())
		{
			$text->saveVars([
				'newstext_title' => $title,
				'newstext_message' => $message,
				'newstext_creator' => $uid,
			]);
		}
		else
		{
		
			$text->insert();
		}
		return true;
	}

}

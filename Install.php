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
use GDO\Maps\Module_Maps;
use GDO\Core\GDO_SEO_URL;
use GDO\Date\Time;
use GDO\Core\Application;
use GDO\Perf\Module_Perf;
use GDO\LoC\Module_LoC;
use GDO\User\GDT_ACLRelation;

/**
 * Initial seed for rapid dev.
 * 
 * @author gizmore
 */
final class Install
{
	public static function install(Module_KassiererCard $module) : bool
	{
		return
			self::installRoutes() &&
			self::installConfig() &&
			self::installSlogans() &&
			self::installPermissions() &&
			self::installCategories() &&
			self::installUsers() &&
			self::installBusinesses() &&
			self::installPartners() &&
			self::installNews() &&
			self::installOffers();
	}

	private static function installRoutes() : bool
	{
		$m = Module_KassiererCard::instance();
		GDO_SEO_URL::addRoute('favicon.ico', $m->wwwPath('img/kassierercard_logo.svg'));
		return true;
	}

	##############
	### Config ###
	##############
	private static function installConfig() : bool
	{
		if (Application::isDev())
		{
			Module_Perf::instance()->saveConfigVar('hook_sidebar', 'all');
			Module_KassiererCard::instance()->saveConfigVar('pre_alpha', '0');
		}
		else
		{
			Module_Perf::instance()->saveConfigVar('hook_sidebar', 'staff');
			Module_KassiererCard::instance()->saveConfigVar('pre_alpha', '1');
		}
		Module_LoC::instance()->saveConfigVar('hook_sidebar', '0');
		Module_Avatar::instance()->saveConfigVar('hook_sidebar', '0');
		Module_Core::instance()->saveConfigVar('allow_guests', '0');
		Module_CountryRestrictions::instance()->saveConfigVar('country_whitelist', '["DE"]');
		Module_Language::instance()->saveConfigVar('languages', '["en","de"]');
		Module_Language::instance()->saveConfigVar('use_in_javascript', '0');
		Module_Maps::instance()->saveConfigVar('maps_api_google', '0');
		return true;
	}
	
	###############
	### Slogans ###
	###############
	private static function installSlogans() : bool
	{
		$data = [
			'Transparent und ehrlich',
			'Diesmal anders herum',
			'Gewöhne Dich daran',
			'Es wurde auch Zeit',
			'Alles geht. Nix muss',
			'Denkt mal drüber nach',
			'Willkommen im Club',
			'Willkommen im 22 Jahrhundert',
			'Besser spät als nie',
			'Wenn nicht jetzt wann dann',
			'Nie mehr ohne',
			'Ich mache mit',
			'Wir stehen hinter euch',
			'Es wird Zeit',
			'Das warten hat ein Ende',
			'Wir haben die Wahl',
			'Nicht ohne euch',
			'Es passt',
			'Zusammen mehr erreichen',
			'Es wird auch Zeit',
			'Darauf haben wir gewartet',
			'Wir sind noch da',
			'Das lohnt sich',
			'Jetzt erst recht',
			'Besser als gefragt',
			'Kreativ und beliebt',
			'Für Euch',
			'Änderung. Verbesserung. Erneuerung',
			'Ich shoppe auch gern',
			'Damit alle genug haben',
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
	
	#############
	### Perms ###
	#############
	private static function installPermissions() : bool
	{
		# Perms
		GDO_Permission::create('kk_manager', 750);
		GDO_Permission::create('kk_distributor', 400);
		GDO_Permission::create('kk_cashier', 300);
		GDO_Permission::create('kk_company', 200);
		GDO_Permission::create('kk_customer', 100);
		return true;
	}
	
	##################
	### Categories ###
	##################
	private static function installCategories() : bool
	{
		self::cat(1,  'Businesses', null);
		self::cat(2,  'Supermarket', 1);
		self::cat(3,  'Bakery', 1);
		self::cat(4,  'Slaughter', 1);
		self::cat(5,  'Office', 1);
		self::cat(6,  'Restaurant', 1);
		self::cat(7,  'Hairstyler', 1);
		self::cat(8,  'Pub', 1);
		self::cat(9,  'Headshop', 1);
		self::cat(10, 'Charity', 1);
		self::cat(11, 'NGO', 1);
		self::cat(12, 'Social', 1);
		
		self::cat(101, 'News', null);
		self::cat(102, 'Peiner-News', 101);
		self::cat(103, 'Kassierer-News', 101);
		
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
	
	#############
	### Users ###
	#############
	private static function installUsers() : bool
	{
		$accounts = require 'account_seeds.php';
		foreach ($accounts as $data)
		{
			self::installUser(...$data);
		}
		
		self::installUserSetting('Horus', 'KassiererCard', 'favorite_religion', 'Horus Götterkult', GDT_ACLRelation::ALL);
		
		return true;
	}
	
	private static function installUserSetting(string $username, string $moduleName, string $settingName, string $settingVar, string $aclRelation): bool
	{
		$user = GDO_User::getByName($username);
		$user->saveSettingVar($moduleName, $settingName, $settingVar);
		$user->saveSettingVar($moduleName, "_acl_{$settingName}_relation", $aclRelation);
		return true;
	}
	
	private static function installUser(string $id, string $nickname, ?string $email, string $password, string $perms) : bool
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
		else
		{
			$user->saveVars([
				'user_type' => 'member',
				'user_name' => $nickname,
				'user_password' => BCrypt::create($password)->__toString(),
			]);
		}
		
		# Email
		$user->saveSettingVar('Mail', 'email', $email);

		# Perms
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
	private static function installBusinesses() : bool
	{
		$i = 1;
		self::biz($i++, 'REWE Markt Peine',   2, 'Schäferstraße 12',         '31224', 'Peine', 52.32101586390254, 10.24893384967010,  '+49 5171 58 315 87');
		self::biz($i++, 'REWE Markt Peine',   2, 'Celler Straße 51-55',      '31224', 'Peine', 52.32999367361805, 10.23279618918122,  '+49 5171 712 82');
		self::biz($i++, 'EDEKA Center Peine', 2, 'Friedrich-Ebert-Platz 25', '31226', 'Peine', 52.31740702775802, 10.22991038947184,  '+49 5171 95 50');
		self::biz($i++, 'Penny Markt Peine',  2, 'Duttenstedter Str. 136',   '31224', 'Peine', 52.32887785039469, 10.25016182443094,  '+49 221 2019 9959');
		self::biz($i++, 'NP-Markt Peine',     2, 'Sedanstraße 41',           '31224', 'Peine', 52.32509004097773, 10.23358606569167,  '+49 5171 14 145');
		self::biz($i++, 'Jawoll Peine',       2, 'Woltorfer Str. 102',       '31224', 'Peine', 52.31962953955457, 10.24794936924906,  '+49 05191 980 30');
		self::biz($i++, 'Café Mitte Peine',  12, 'Breite Straße 48',         '31224', 'Peine', 52.32208090312398, 10.226910900342983, '+49 05171 58 777 55');
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
		self::partner(1, 'Ali', 6, 'Saray Imbiss Peine', 'Marktstraße 23', '31224', 'Peine', 'DE', 'TR', '+49 5171 / 37 40', $descr, 'https://saray.busch-peine.de/');
		$descr = 'Der Frisör bei dem einen der Hut hochgeht?<br/>Schauen Sie mal vorbei!';
		self::partner(2, 'Walid', 7, 'Frisör Walid', 'Woltorfer Str. 4', '31224', 'Peine', 'DE', 'DE', '+49 5171 / 711 71', $descr, 'https://frisoer.walid.busch-peine.de/');
		$descr = 'Peiner Rock/Pank Szenekneipe.<br/>Ab und an auch mal Live Musik.<br/>Angenehme Atmosphäre.';
		self::partner(3, 'Garage', 8, 'Garage Peine', 'Pulverturmwall 68', '31224', 'Peine', 'DE', 'DE', null, $descr, 'https://garage-peine.de');
		$descr = 'Endlich wieder ein Headshop in Peine<br/>CBD geht jetzt schon, echtes Weed soll es ja auch bald geben...<br/>Wer\'s glaubt!';
		self::partner(4, 'Headshop', 9, 'Headhshop Peine', 'Am Markt', '31224', 'Peine', 'DE', 'DE', null, $descr, 'https://headshop.busch-peine.de');
		$descr = 'Brötchen vom Vortag sind nicht die besten, aber Kuchen vom Vortag klingt doch super!<br/>Café, Kuchen, Backwaren,';
		self::partner(5, 'Vortagsbaeckerei', 3, 'Vortagsbaeckerei', 'Bahnhofstraße 5', '31224', 'Peine', 'DE', 'DE', '+49 176 218 23 784', $descr, 'https://www.facebook.com/people/Backlife-Caf%C3%A9-Vortagsb%C3%A4ckerei-Peine/100057060595562/');
		$descr = 'Der FIPS-Peine betreut Psychisch-Behinderte.<br/>Diese arbeiten in einigen Geschäften in der Innenstadt, wie z.B. Gebrauchtwaren oder Kaffees.';
		self::partner(6, 'FIPS', 12, 'FIPS Peine', 'Hagenstr. 12', '31224', 'Peine', 'DE', 'DE', '+49 5171 50 89 25', $descr, 'https://www.fips-ev.de/treffen/beratungs-begegnungsst%C3%A4tte-peine/');
		return true;
	}
	
	private static function partner(int $id, string $userName, int $cat, string $name, string $street, string $zip, string $city, string $country, string $origin, ?string $phone, string $descr, string $url) : void
	{
		$userId = GDO_User::getByName($userName)->getID();
		$countryId = GDO_Country::findById($country)->getID();
		$originId = GDO_Country::findById($origin)->getID();
		
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
				'address_country' => $countryId,
				'address_phone' => $phone,
				'address_phone_fax' => null,
				'address_phone_mobile' => null,
				'address_email' => null,
				'address_website' => $url,
				'address_creator' => $userId,
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
				'address_country' => $countryId,
				'address_phone' => $phone,
				'address_phone_fax' => null,
				'address_phone_mobile' => null,
				'address_email' => null,
				'address_website' => $url,
				'address_creator' => $userId,
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
		
		$user = GDO_User::findById($userId);
		$user->saveSettingVar('Address', 'address', $addr->getID());
		$user->saveSettingVar('Country', 'country_of_living', $countryId);
		$user->saveSettingVar('Country', 'country_of_origin', $originId);
	}
	
	############
	### News ###
	############
	private static function installNews() : bool
	{
		$titleEn = 'First Card printed!';
		$titleDe = 'Erste Karte gedruckt!';
		$messageEn = <<<EOT
Hi am Happy to announce!

KassiererCard.org has reached phase 1.

In this phase, we test the service with only a few customers, empolyees, workers and partners.

After this phase, the whole site will be reset and you have to register again.

Phase two is scheduled for 11/9/2022.

We currently have no real partner who is aiding us financially,

but we are looking.

First offers are on our cap.

 - gizmore
EOT;
		$messageDe = <<<EOT
Voller Stolz presentiere ich die erste KassiererCard

KassiererCard.org hat Phase 1 erreicht.

Nach dieser Phase wird noch einmal Reset gedrückt, und Sie müssen sich neu registrieren.

Phase 2 beginnt vorraussichtlich am 9.11.2022.

In dieser Phase testen wir den Service mit nur wenigen Kunde, Angestellten, Arbeitern und Werbepartnern.

Wir haben noch keine echten Werbepartner, die uns unterstützen,

wir suchen aber nach Gelegenheiten.

Die ersten Angebote gehen auf unsere Kappe!

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
				'newstext_message_input' => $message,
				'newstext_creator' => $uid,
			]);
		}
		else
		{
			$text->setVars([
				'newstext_title' => $title,
				'newstext_message_input' => $message,
				'newstext_creator' => $uid,
			])->insert();
		}
		return true;
	}

	##############
	### Offers ###
	##############
	private static function installOffers() : bool
	{
		$now = Time::getDate();
		self::offer(1, 1, 15,  4.00, 60.00,  2, $now, '2022-11-09',
			'ALIBABA!', 'Dönertaschtig',
			'Ein leckerer Döner mit Schafskäse und Fleisch nach Wahl, von Ihrem Saray.');

		self::offer(2, 1, 20,  2.00, 40.00,  2, $now, '2022-11-09',
			'ALIBABA!', 'Erquickend',
			'Ein Gutschein für eine Soft-Getränk. Besser als garnix.');
		
		self::offer(3, 2,  5,  5.00, 25.00,  1, $now, '2022-11-09',
			'CUT!!!', 'Aerodynamisch',
			'Ein 5€ Gutschein für einen Haarschnitt bei Frisör Walid.');
		
		self::offer(4, 3, 30,  1.50, 45.00, 10, $now, '2022-11-09',
			'PROST!!!', 'Gesellig',
			'Ein Gutschein über ein Härke-Bier, dem ehemaligen Getränk der Stadt?');
		
		self::offer(5, 4,  2, 10.00, 20.00,  1, $now, '2022-11-09',
			'DOPE!!!', 'Auszeit',
			'Ein Gramm gratis CBD-Gras zum ausprobieren im Gegenwert von €10.<br/>Na wenn das nix is!');
		
		self::offer(6, 5, 40,  1.50, 50.00,  5, $now, '2022-11-09',
			'COFFEE!!!', 'Zuerst ein\' Kaffee',
			'Ein Kaffee in der Vortagsbäckerei. Schauen Sie mal vorbei!');
		
		self::offer(7, 5, 20,  2.00, 20.00,  2, $now, '2022-11-09',
			'COFFEE!!!', 'Danach ein\' Donut',
			'Ein Donut in der Vortagsbäckerei. Schauen Sie mal vorbei!');
		
		self::offer(8, 6, 10,  1.00, 10.00,  2, $now, '2022-11-09',
			'buchwurm', 'Belesen',
			'Ein Gutschein für ein Buch im Bücherwurm Gebrauchtleseartikelgeschäft.');
		
		return true;
	}
	
	/**
	 * Create an offer
	 */
	private static function offer(int $id, int $partnerId,
		int $totalOffers, float $worth, float $invested,
		int $cashierAmt,
		string $created, string $expire,
		string $passphrase, string $title, string $text) : void
	{
		$stars = KC_Util::euroToStars($worth);
		if ($offer = KC_Offer::getById($id))
		{
			$offer->saveVars([
				'o_partner' => $partnerId,
				'o_passphrase' => $passphrase,
				'o_title' => $title,
				'o_text' => $text,
				'o_required_stars' => $stars,
				'o_cashier_amt' => $cashierAmt,
				'o_total_amt' => $totalOffers,
				'o_expires' => $expire,
				'o_invested' => $invested,
				'o_worth' => $worth,
				'o_created' => $created,
				'o_creator' => '2',
			]);
		}
		else
		{
			KC_Offer::blank([
				'o_id' => $id,
				'o_partner' => $partnerId,
				'o_passphrase' => $passphrase,
				'o_title' => $title,
				'o_text' => $text,
				'o_required_stars' => $stars,
				'o_cashier_amt' => $cashierAmt,
				'o_total_amt' => $totalOffers,
				'o_invested' => $invested,
				'o_worth' => $worth,
				'o_expires' => $expire,
				'o_created' => $created,
				'o_creator' => '2',
			])->insert();
		}
	}

}

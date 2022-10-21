<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Address\GDT_Address;
use GDO\Category\GDT_Category;
use GDO\Table\GDT_ListItem;
use GDO\User\GDT_User;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\UI\GDT_Message;
use GDO\User\GDO_User;
use GDO\Address\GDO_Address;
use GDO\UI\GDT_HTML;
use GDO\Maps\Module_Maps;
use GDO\UI\GDT_Link;
use GDO\File\GDT_ImageFile;
use GDO\Core\GDT_Index;
use GDO\Net\GDT_Url;
use GDO\UI\GDT_Card;

/**
 * Merchandize Partner / Company.
 *
 * @author gizmore
 * @version 7.0.1
 */
final class KC_Partner extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('p_id'),
			GDT_Partnership::make('p_partnership'),
			GDT_User::make('p_user')->notNull(),
			GDT_Category::make('p_category')->notNull(),
			GDT_Address::make('p_address')->notNull()->emptyLabel('please_choose'),
			GDT_Message::make('p_description')->label('information'),
			GDT_Url::make('p_url')->allowExternal(),
			GDT_WebsiteContent::make('p_website_content'),
			GDT_ImageFile::make('p_logo')->label('logo')
				->scaledVersion('icon', 96, 96)
				->scaledVersion('thumb', 196, 196),
			GDT_CreatedAt::make('p_created'),
			GDT_CreatedBy::make('p_creator'),
			GDT_Index::make('p_index_p_user')->indexColumns('p_user'),
		];
	}
	
	public function getUser() : ?GDO_User
	{
		return $this->gdoValue('p_user');
	}

	public function getAddress() : GDO_Address
	{
		return $this->gdoValue('p_address');
	}
	
	public function getDescriptionHTML() : string
	{
		return $this->gdoVar('p_description_output');
	}
	
	public function getOfferCount() : int
	{
		return KC_Offer::table()->queryNumOffers($this);
	}
	
	public function getRedeemCount() : int
	{
		return (int) $this->getUser()->settingVar('KassiererCard', 'offers_fullfilled');
	}
	
	public function getURL() : ?string
	{
		return $this->gdoVar('p_url');
	}
	
	public function hrefPartner() : string
	{
		return href('KassiererCard', 'Partner', "&id={$this->getID()}");
	}
	
	public function linkPartner() : GDT_Link
	{
		$href = $this->hrefPartner();
		$label = $this->getAddress()->render();
		return GDT_Link::make()->href($href)->label('partner')->textRaw($label);
	}
	
	##############
	### Render ###
	##############
	public function renderName() : string
	{
		return $this->getAddress()->renderName();
	}
	
	public function renderList() : string
	{
		$addr = $this->getAddress();
		$country = $addr->getCountry();
		$li = GDT_ListItem::make("partner_{$this->getID()}")->gdo($this);
		$li->titleRaw(GDT_Link::anchor($this->hrefPartner(), $addr->getCompany()));
		$subt = $addr->getStreet() . ', ' . $addr->getZIP() . ' ';
		$subt .= $addr->getCity();
		$href = Module_Maps::instance()->getMapsURL($subt . ', ' . $country->getName());
		$subt .= ', ' . $country->render();
		if ($href = $this->getURL())
		{
			$link = GDT_Link::make()->href($href)->labelNone()->icon('url')->tooltip('link_visit_partner');
			$subt .= ', ' . $link->render();
		}
		$li->subtitleRaw($subt);
		$li->content(GDT_HTML::make()->var($this->getDescriptionHTML()));
		$footer = GDT_HTML::make();
		$html = '';
		if ($user = $this->getUser())
		{
			$purl = $user->renderProfileLink(true, true, false);
			$html = t('footer_partner', [$purl]);
			$html .= ' - ';
		}
		$href = Module_KassiererCard::instance()->href('Offers', "&f[o_partner]={$this->getID()}");
		$amt = $this->getOfferCount();
		$amt2 = $this->getRedeemCount();
		$html .= t('footer_partner_offers', [$href, $amt, $amt2]);
		$li->footer($footer->var($html));
		return $li->render();
	}
	
	public function renderCard() : string
	{
		return $this->getCard()->render();
// 		return $this->displayCard($this->getAddress()->getAddressLine());
	}
	
	############
	### Card ###
	############
	public function getCard(): GDT_Card
	{
		$card = GDT_Card::make("partner-{$this->getID()}")->gdo($this);
		$card->creatorHeader();
		$card->title('ct_partner');
		return $card;
	}
	
	##############
	### Static ###
	##############
	public static function getForUser(GDO_User $user) : ?self
	{
		return self::table()->getBy('p_user', $user->getID());
	}
	
	public static function numTotal() : int
	{
		return self::queryTotal();
	}
	
	public static function queryTotal() : int
	{
		return self::table()->countWhere();
	}
	
}

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
use GDO\Net\GDT_Url;

final class KC_Partner extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('p_id'),
			GDT_User::make('p_user'),
			GDT_Address::make('p_address')->notNull(),
			GDT_Url::make('p_url')->allowExternal()->label('website'),
			GDT_Category::make('p_category')->notNull(),
			GDT_Message::make('p_description')->label('information'),
			GDT_CreatedAt::make('p_created'),
			GDT_CreatedBy::make('p_creator'),
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
	
	##############
	### Render ###
	##############
	public function renderList() : string
	{
		$addr = $this->getAddress();
		$li = GDT_ListItem::make("partner_{$this->getID()}")->gdo($this);
		$li->titleRaw($addr->getCompany());
		$subt = $addr->getStreet() . ', ' . $addr->getZIP() . ' ';
		$subt .= $addr->getCity() . ', ' . $addr->getCountry()->render();
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
		$html .= t('footer_partner_offers', [$href, $amt]);
		$li->footer($footer->var($html));
		return $li->render();
	}
	
}

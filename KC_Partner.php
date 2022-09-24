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
use GDO\UI\GDT_Label;

final class KC_Partner extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('p_id'),
			GDT_User::make('p_user'),
			GDT_Address::make('p_address')->notNull(),
			GDT_Category::make('p_category')->notNull(),
			GDT_Message::make('p_description')->label('information'),
			GDT_CreatedAt::make('p_created'),
			GDT_CreatedBy::make('p_creator'),
		];
	}
	
	public function getAddress() : GDO_Address
	{
		return $this->gdoValue('p_address');
	}
	
	public function getUser() : ?GDO_User
	{
		return $this->gdoValue('p_user');
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
		$li->content($this->gdoColumn('p_description'));
		if ($user = $this->getUser())
		{
			$li->footer(GDT_Label::make()->label('footer_partner', [$user->renderProfileLink(true, true, false)]));
		}
		return $li->render();
	}
	
}

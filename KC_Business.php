<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Address\GDT_Address;
use GDO\Core\GDT_AutoInc;
use GDO\Maps\GDT_Position;
use GDO\Category\GDT_Category;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_EditedAt;
use GDO\Core\GDT_EditedBy;
use GDO\Core\GDT_DeletedAt;
use GDO\Core\GDT_DeletedBy;
use GDO\Core\GDT_String;
use GDO\Date\GDT_DateTime;
use GDO\Date\GDT_Timestamp;
use GDO\Table\GDT_ListItem;
use GDO\Address\GDO_Address;

/**
 * A business in the crude world.
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class KC_Business extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('biz_id'),
			GDT_Address::make('biz_address'),
			GDT_Position::make('biz_coord'),
			GDT_Category::make('biz_category'),
			GDT_Timestamp::make('biz_participating'),
			GDT_Timestamp::make('biz_declining'),
			GDT_CreatedAt::make('biz_created'),
			GDT_CreatedBy::make('biz_creator'),
			GDT_DeletedAt::make('biz_deleted'),
			GDT_DeletedBy::make('biz_deletor'),
			GDT_EditedAt::make('biz_edited'),
			GDT_EditedBy::make('biz_editor'),
		];
	}
	
	public function getAddress() : GDO_Address { return $this->gdoValue('biz_address'); }

	public function renderList() : string
	{
		$addr = $this->getAddress();
		$li = GDT_ListItem::make();
		$li->titleRaw($addr->gdoVar('address_company'));
		$li->subtitle(GDT_String::make()->var($addr->getAddressLine()));
		return $li->render();
	}
	
}

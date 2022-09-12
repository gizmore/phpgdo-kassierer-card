<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\File\GDT_ImageFile;
use GDO\Core\GDT_Name;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;

/**
 * A business card belongs to a business and holds two images.
 * The front and back for a printed card.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class KC_BusinessCard extends GDO
{
	const WIDTH = 1514;
	const HEIGHT = 986;
	
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('bc_id'),
			GDT_Business::make('bc_business')->notNull(),
			GDT_Name::make('bc_name')->notNull(),
			GDT_ImageFile::make('bc_front')->exactSize(1514, 986)->notNull()->label('front'),
			GDT_ImageFile::make('bc_back')->exactSize(1514, 986)->notNull()->label('back'),
			GDT_CreatedAt::make('bc_created'),
			GDT_CreatedBy::make('bc_creator'),
		];
	}


	
}


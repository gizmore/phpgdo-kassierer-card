<?php
namespace GDO\KassiererCard;

use GDO\UI\GDT_Message;

/**
 * Website content is edited via the usual GDO editor. CKEditor or Markdown is recommended at the moment.
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class GDT_WebsiteContent extends GDT_Message
{
	
	public function defaultLabel(): self
	{
		return $this->label('website_content');
	}
	
}

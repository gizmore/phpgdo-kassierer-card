<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;

/**
 * Star creation / transfer types.
 * Creations are star transfers without sender.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_StarTransferType extends GDT_Enum
{
	const FREE = 'kk_free';
	const WELCOME = 'kk_welcome';
	const TRANSFER = 'kk_transfer';
	const POLL_VOTE = 'kk_poll';
	const CUSTOMER_COUPON = 'kk_coupon';
	
	protected function __construct()
	{
		parent::__construct();
		$this->enumValues(
			self::FREE,
			self::WELCOME,
			self::TRANSFER,
			self::POLL_VOTE,
			self::CUSTOMER_COUPON,
		);
	}
	
}

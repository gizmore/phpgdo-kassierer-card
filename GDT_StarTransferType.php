<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;

/**
 * Star creation / transfer types.
 * Creations are star transfers without sender.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class GDT_StarTransferType extends GDT_Enum
{

	public const FREE = 'kk_free';
	public const WELCOME = 'kk_welcome';
	public const TRANSFER = 'kk_transfer';
	public const POLL_VOTE = 'kk_poll';
	public const CUSTOMER_COUPON = 'kk_coupon';

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

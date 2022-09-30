<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;
use GDO\Core\GDT;

final class GDT_AccountType extends GDT_Enum
{
    const CASHIER = 'kk_cashier';
    const COMPANY = 'kk_company';
    const CUSTOMER = 'kk_customer';
    
    protected function __construct()
    {
        parent::__construct();
        $this->enumValues(self::CASHIER, self::COMPANY, self::CUSTOMER);
        $this->notNull();
        $this->emptyLabel('lbl_choose_account_type');
    }
    
    public function displayVar(string $var=null) : string
    {
    	return $var === null ? GDT::EMPTY_STRING : t($var);
    }
}

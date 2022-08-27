<?php
namespace GDO\KassiererCard\Test;

use GDO\Tests\TestCase;
use GDO\KassiererCard\KC_Business;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertGreaterThanOrEqual;
use GDO\Category\GDO_Category;
use GDO\Address\GDO_Address;

final class KCTest extends TestCase
{
	public function testBusinessCreation() : void
	{
		# These get installed on install.
		$cats = GDO_Category::table()->countWhere();
		assertGreaterThanOrEqual(5, $cats, 'Test if categories were created.');
		
		$bizs = KC_Business::table()->countWhere();
		assertGreaterThanOrEqual(2, $bizs, 'Test if businesses were created.');

		$addr = GDO_Address::table()->countWhere();
		assertGreaterThanOrEqual($bizs, $addr, 'Test if addresses were created.');
	}
	
}

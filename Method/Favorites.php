<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryTable;
use GDO\User\GDO_User;
use GDO\User\GDO_UserSetting;
use GDO\DB\Query;
use GDO\KassiererCard\GDT_FavSection;
use GDO\Core\GDT_String;
use GDO\Country\Module_Country;
use GDO\Table\GDT_RowNum;
use GDO\Core\GDT_UInt;

/**
 * Display the profile favorites of all users.
 * 
 * @author gizmore
 */
final class Favorites extends MethodQueryTable
{
	public function isOrdered(): bool
	{
		return false;
	}
	
	public function isFiltered(): bool
	{
		return false;
	}
	
	
	public function getMethodTitle(): string
	{
		return t('mt_kk_favorites', [
			$this->displaySection()]);
	}
	
	public function getTableTitle()
	{
		return t('tt_kk_favorites', [
			$this->table->countItems(),
			$this->displaySection(),
		]);
	}
	
	public function getMethodDescription(): string
	{
		return t('md_kk_favorites', [
			$this->table->countItems(),
			$this->displaySection(),
			sitename(),
		]);
	}
	
	public function gdoParameters(): array
	{
		return [
			GDT_FavSection::make('section')->initial('your_dream'),
		];
	}
	
	public function gdoTable()
	{
		return GDO_User::table();
	}
	
	public function getSection(): string
	{
		return $this->gdoParameterVar('section');
	}

	public function displaySection(): string
	{
		return $this->gdoParameter('section')->displayVar($this->getSection());
	}
	
	public function getQuery(): Query
	{
		$query = GDO_UserSetting::table()->select('uset_user_t.*, COUNT(uset_var) AS var_count, uset_var as '.$this->getSection());
		$query->group('uset_var');
		$query->where("uset_name=".quote($this->getSection()));
		$query->joinObject('uset_user');
		Module_Country::instance()->joinSetting($query, 'country_of_living', 'uset_user_t.user_id');
		$query->fetchTable(GDO_User::table());
		GDO_UserSetting::table()->whereSettingVisible($query, 'KassiererCard', $this->getSection(), 'uset_user_t.user_id');
		return $query;
	}
	
	public function gdoHeaders(): array
	{
		$u = $this->gdoTable();
// 		$s = GDO_UserSetting::table();
		$mc = Module_Country::instance();
		return [
			GDT_UInt::make('var_count'),
			$mc->setting('country_of_living'),
			$u->gdoColumn('user_name'),
			$u->gdoColumn('user_level'),
			GDT_String::make($this->getSection())->labelRaw($this->displaySection()),
		];
	}

}

<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryTable;
use GDO\UI\GDT_SearchButton;
use GDO\User\GDO_User;
use GDO\User\GDO_UserSetting;
use GDO\DB\Query;
use GDO\Form\GDT_Form;
use GDO\KassiererCard\GDT_FavSection;
use GDO\Core\GDT_String;
use GDO\Country\Module_Country;
use GDO\Core\GDT_UInt;
use GDO\Core\GDT_Tuple;

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
			$this->getTable()->countItems(),
			$this->displaySection(),
		]);
	}
	
	public function getMethodDescription(): string
	{
		return t('md_kk_favorites', [
			$this->getTable()->countItems(),
			$this->displaySection(),
			sitename(),
		]);
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
		$query = GDO_UserSetting::table()->select('uset_user_t.*, COUNT(uset_var) AS count, uset_var as '.$this->getSection());
		$query->group('uset_var');
		$query->where("uset_name=".quote($this->getSection()));
		$query->joinObject('uset_user');
		Module_Country::instance()->joinSetting($query, 'country_of_living', 'uset_user_t.user_id');
		$query->fetchTable(GDO_User::table());
		GDO_UserSetting::table()->whereSettingVisible($query,
			'KassiererCard', $this->getSection(), GDO_User::current(), 'uset_user_t.user_id');
		return $query;
	}
	
	public function gdoHeaders(): array
	{
		$u = $this->gdoTable();
// 		$s = GDO_UserSetting::table();
		$mc = Module_Country::instance();
		return [
			GDT_UInt::make('count'),
			$mc->setting('country_of_living'),
			$u->gdoColumn('user_name'),
			$u->gdoColumn('user_level'),
			GDT_String::make($this->getSection())->labelRaw($this->displaySection()),
		];
	}

// 	public function execute()
// 	{
// 		$response = parent::execute();
// 		return GDT_Tuple::makeWith(
// // 			$this->gdoParameter('section'),
// 			$response,
// 		);
// 	}
	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_FavSection::make('section')->initial('profession'),
		);
		$form->actions()->addField(
			GDT_SearchButton::make('go')
			->onclick([$this, 'executeWithSection']));
		$form->slim();
		$form->verb(GDT_Form::GET);
	}
	
	public function exexuteWithSection()
	{
		return parent::execute();
	}

}

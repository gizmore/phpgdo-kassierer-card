<?php
namespace GDO\KassiererCard;

use GDO\Address\GDO_Address;
use GDO\Address\GDT_Address;
use GDO\Category\GDT_Category;
use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_DeletedAt;
use GDO\Core\GDT_DeletedBy;
use GDO\Core\GDT_EditedAt;
use GDO\Core\GDT_EditedBy;
use GDO\Date\GDT_Timestamp;
use GDO\DB\Cache;
use GDO\Maps\GDT_Position;
use GDO\Table\GDT_ListItem;
use GDO\UI\GDT_Button;
use GDO\UI\GDT_Card;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;
use GDO\User\GDT_User;

/**
 * A business in the crude world.
 *
 * @since 7.0.1
 * @author gizmore
 */
final class KC_Business extends GDO
{

	public static function numTotal(): int
	{
		if (null === ($cache = Cache::get('kk_business_count')))
		{
			$cache = self::queryTotal();
			Cache::set('kk_business_count', $cache);
		}
		return $cache;
	}

	private static function queryTotal(): int
	{
		return self::table()->countWhere('biz_deleted IS NULL');
	}

	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('biz_id'),
			GDT_Address::make('biz_address')->emptyLabel('please_choose'),
			GDT_Position::make('biz_coord')->initialCurrent(),
			GDT_Category::make('biz_category')->emptyLabel('please_choose'),
			GDT_Timestamp::make('biz_participating'),
			GDT_Timestamp::make('biz_declining'),
			GDT_User::make('biz_owner')->label('owner'),
			GDT_CreatedAt::make('biz_created'),
			GDT_CreatedBy::make('biz_creator'),
			GDT_DeletedAt::make('biz_deleted'),
			GDT_DeletedBy::make('biz_deletor'),
			GDT_EditedAt::make('biz_edited'),
			GDT_EditedBy::make('biz_editor'),
		];
	}

	public function renderName(): string
	{
		return $this->renderAddressLine();
	}

	public function renderAddressLine(): string
	{
		$a = $this->getAddress();
		$line = $a->getCompany() . ', ' . $a->getStreet() . ', ' . $a->getCity();
		if (!($line = trim($line, ', ')))
		{
			return t('business', [$this->getID()]);
		}
		return $line;
	}

	public function getAddress(): GDO_Address { return $this->gdoValue('biz_address'); }

	public function renderList(): string
	{
		return $this->getListItem()->render();
	}

	public function getListItem(): GDT_ListItem
	{
		$addr = $this->getAddress();
		$li = GDT_ListItem::make();
		$li->titleRaw($addr->gdoVar('address_company'));
		$li->subtitleRaw($addr->getAddressLine());

		$user = GDO_User::current();

		if ($user->hasPermission('kk_cashier'))
		{
			if ($this->isWorkingHere($user))
			{
				$li->actions()->addFields(
					GDT_Button::make('btn_stopped_there')->href(href('KassiererCard', 'WorkingThere', "&not_anmyore=1&biz={$this->getID()}"))->icon('error'),
				);
			}
			else
			{
				$li->actions()->addFields(
					GDT_Button::make('btn_working_there')->href(href('KassiererCard', 'WorkingThere', "&biz={$this->getID()}"))->icon('construction'),
				);
			}
		}

		$li->actions()->addFields(
			GDT_Link::make('link_employees')->href($this->getEmployeeHREF())->text('btn_biz_emplyoees', [$this->getNumEmployees()]),
		);

		return $li;
	}

	public function isWorkingHere(GDO_User $user): bool
	{
		return KC_Working::isWorkingThere($user, $this);
	}

	###############
	### Render ####
	###############

	public function getEmployeeHREF(): string
	{
		return href('KassiererCard', 'Employees', "&business={$this->getID()}");
	}

	public function getNumEmployees()
	{
		return KC_Working::getNumEmployees($this);
	}

	public function renderOption(): string
	{
		return $this->renderAddressLine();
	}

	public function getAddressLink(): string
	{
		return GDT_Link::make('link_biz')->href($this->getEmployeeHREF())->labelRaw($this->getCompanyName())->render();
	}

	##############
	### Static ###
	##############

	public function getCompanyName(): string
	{
		return $this->getAddress()->getCompany();
	}

	public function getCard(): GDT_Card
	{
		$card = GDT_Card::make()->gdo($this);
		$card->title('ct_business');
		$card->subtitle('ct_business_sub');
		return $card;
	}

}

<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;

/**
 * A profile field which is evaluated as a favorite setting, like a website or a movie.
 *
 * @author gizmore
 */
final class GDT_FavSection extends GDT_Enum
{

	protected function __construct()
	{
		parent::__construct();
		$this->setupEnumValues();
	}

	/**
	 * Setup enum values from user settings?
	 */
	private function setupEnumValues(): void
	{
		$this->enumValues(...$this->getEnumFields());
	}
	
	private function getEnumFields(): array
	{
		return [
			'profession',
			'personal_website',
			'salary_gross',
			'salary_hourly',
			'your_dream',
			'favorite_artist',
			'favorite_book',
			'favorite_meal',
			'favorite_movie',
			'favorite_religion',
			'favorite_song',
			'favorite_website',
		];
	}

	public function displayVar(string $var=null) : string
	{
		return $var === null ? self::none(): t($var);
	}

}

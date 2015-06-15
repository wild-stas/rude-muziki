<?

namespace rude;

/**
 * @category types
 */
class bool
{
	/**
	 * @en Returns random bool value
	 * @ru Возвращает псевдослучайное булево значение
	 *
	 * $rand = bool::rand();
	 *
	 * @return bool
	 */
	public static function rand()
	{
		return mt_rand(0, 1) === 0;
	}
}
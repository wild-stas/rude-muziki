<?

namespace rude;

/**
 * @category types
 */
class items
{
	public static function get($array, $n, $default = null)
	{
		return get($n - 1, $array, $default);
	}

	/**
	 * @en Get the first element of an array
	 * @ru Возвращает первый (первые) элементы массива
	 *
	 * @param array $array
	 * @param int $n
	 *
	 * @return mixed
	 */
	public static function first($array, $n = 1)
	{
		if ($n == 1)
		{
			return reset($array);
		}

		return static::shift($array, $n);
	}

	/**
	 * @en Get the last element of an array
	 * @ru Возвращает последний (последние) элементы массива
	 *
	 * @param array $array
	 * @param int $n
	 *
	 * @return mixed
	 */
	public static function last($array, $n = 1)
	{
		if ($n == 1)
		{
			return end($array);
		}

		return static::pop($array, $n);
	}


	public static function shift(&$array, $n = 1)
	{
		if ($n == 1)
		{
			return array_shift($array);
		}


		$result = [];

		for ($i = 0; $i < $n and $array; $i++)
		{
			$result[] = array_shift($array);
		}

		return $result;
	}

	public static function pop(&$array, $n = 1)
	{
		if ($n == 1)
		{
			return array_pop($array);
		}


		$result = [];

		for ($i = 0; $i < $n and $array; $i++)
		{
			$result[] = array_pop($array);
		}

		return $result;
	}

	public static function contains($haystack, $needle)
	{
		if (is_array($needle))
		{
			return !array_diff($needle, $haystack);
		}

		return in_array($needle, $haystack);
	}

	/**
	 * @en Pick one or more random entries out of an array
	 * @ru Выбирает указанное количество случайных элементов из массива
	 *
	 * @param array $array
	 * @param int
	 *
	 * @return mixed
	 */
	public static function rand($array, $n = 1)
	{
		return $array[array_rand($array, $n)];
	}

	public static function swap(&$array, $a, $b)
	{
		$temp          = $array[$a - 1];
		$array[$a - 1] = $array[$b - 1];
		$array[$b - 1] = $temp;

		return $array;
	}

	/**
	 * @en Same as trim(), just for all elements of the array
	 * @ru Тоже самое, что и trim(), только для всех элементов в массиве
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function trim($array)
	{
		return array_map('trim', $array);
	}

	/**
	 * @en Count all occurrences of specified arrays inside array
	 * @ru Возвращает количество копий определённых элементов в массиве
	 *
	 * $haystack = array('a', 'b', 'f', 'r', 'b', 'v', 'r', 'b', 't', 'a');
	 * $needle = array('a', 'b');
	 *
	 * $count = array_count($needle, $haystack); # int(2)
	 *
	 * @param array $needle
	 * @param array $haystack
	 *
	 * @return int
	 */
	public static function count($needle, $haystack)
	{
		$count = INF;

		$array = array_count_values($haystack);

		foreach ($needle as $item)
		{
			if (!isset($array[$item]))
			{
				return 0;
			}

			$count = min($count, $array[$item]);
		}

		return (int) $count;
	}

	/**
	 * @en Erase specified items inside array
	 * @ru Убирает полные копии указанных элементов из массива
	 *
	 * $haystack = array('a', 'b', 'f', 'r', 'b', 'v', 'r', 'b', 't', 'a');
	 * $needle = array('a', 'b');
	 *
	 * $result = items::remove_pairs($needle, $haystack); # array('f', 'r', 'v', 'r', 'b', 't');
	 *
	 * @param array $needle
	 * @param array $haystack
	 * @param int $count
	 *
	 * @return mixed
	 */
	public static function remove_pairs($needle, $haystack, $count = null)
	{
		if ($count === null)
		{
			$count = items::count($needle, $haystack);
		}

		if (!$count)
		{
			return $haystack;
		}


		$result = $haystack;

		foreach ($needle as $item)
		{
			$index = array_keys($result, $item);

			for ($i = 0; $i < $count; $i++)
			{
				unset($result[$index[$i]]);
			}
		}

		return $result;
	}

	/**
	 * @en Generating all permutations of a given array
	 * @ru Получение всех возможны вариантов перестановок элементов массива
	 *
	 * $array = array('AAA', 'BBB', 'CCC');
	 *
	 * $result = items::permutation($array); # Array
	 *                                        # (
	 *                                        #     [0] => Array
	 *                                        #     (
	 *                                        #         [0] => AAA
	 *                                        #         [1] => BBB
	 *                                        #         [2] => CCC
	 *                                        #     )
	 *                                        #
	 *                                        #     [1] => Array
	 *                                        #     (
	 *                                        #         [0] => AAA
	 *                                        #         [1] => CCC
	 *                                        #         [2] => BBB
	 *                                        #     )
	 *                                        #
	 *                                        #     [2] => Array
	 *                                        #     (
	 *                                        #         [0] => BBB
	 *                                        #         [1] => CCC
	 *                                        #         [2] => AAA
	 *                                        #     )
	 *                                        #
	 *                                        #     [3] => Array
	 *                                        #     (
	 *                                        #         [0] => BBB
	 *                                        #         [1] => AAA
	 *                                        #         [2] => CCC
	 *                                        #     )
	 *                                        #
	 *                                        #     [4] => Array
	 *                                        #     (
	 *                                        #         [0] => CCC
	 *                                        #         [1] => AAA
	 *                                        #         [2] => BBB
	 *                                        #     )
	 *                                        #
	 *                                        #     [5] => Array
	 *                                        #     (
	 *                                        #         [0] => CCC
	 *                                        #         [1] => BBB
	 *                                        #         [2] => AAA
	 *                                        #     )
	 *                                        # )
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function permutation($array)
	{
		$results = array();

		if (count($array) == 1)
		{
			$results[] = $array;
		}
		else
		{
			for ($i = 0; $i < count($array); $i++)
			{
				$first = array_shift($array);

				$subresults = items::permutation($array);

				array_push($array, $first);

				foreach ($subresults as $subresult)
				{
					$results[] = array_merge(array($first), $subresult);
				}
			}
		}

		return $results;
	}

	public static function to_object($array, $escape_keys = false)
	{
		if ($array === null)
		{
			return [];
		}

		foreach ($array as $key => $value)
		{
			if (is_array($value))
			{
				$array[$key] = static::to_object($value, $escape_keys);
			}
		}

		$object = (object) $array;

		if ($escape_keys)
		{
			$search = ['-'];

			foreach ($object as $key => $val)
			{
				if (string::contains($key, $search))
				{
					$key_escaped = string::replace($key, $search, '_');

					$object->$key_escaped = $object->$key;

					unset($object->$key);
				}
			}
		}

		return $object;
	}

	public static function max_length($items)
	{
		$max_length = -INF;

		foreach ($items as $item)
		{
			$max_length = max($max_length, string::length($item));
		}

		return $max_length;
	}

	public static function min_length($items)
	{
		$max_length = INF;

		foreach ($items as $item)
		{
			$max_length = min($max_length, string::length($item));
		}

		return $max_length;
	}
}

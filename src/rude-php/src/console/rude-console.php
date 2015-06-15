<?

namespace rude;

class console
{
	public static function is_exists()
	{
		return php_sapi_name() == 'cli';
	}

	public static function read($prompt = null)
	{
		if (system::is_windows())
		{
			if ($prompt !== null)
			{
				echo $prompt;
			}

			return stream_get_line(STDIN, 1024, PHP_EOL);
		}

		return readline($prompt);
	}

	public static function write($string = '', $bold = false, $replace = false)
	{
		if ($bold !== false)
		{
			$string = console_colors::bold($string);
		}

		if ($replace !== false)
		{
			echo $string . "\r";
		}
		else
		{
			echo $string . PHP_EOL;
		}
	}

	public static function lines()
	{
		console::write(str_repeat('=', static::cols()));
	}

	public static function rows()
	{
		$file_pointer = popen('resize', 'r');

		$answer = stream_get_contents($file_pointer);

		preg_match('/LINES=([0-9]+)/', $answer, $matches);

		pclose($file_pointer);

		return $matches[1];
	}

	public static function cols()
	{
		$file_pointer = popen('resize', 'r');

		$answer = stream_get_contents($file_pointer);

		preg_match('/COLUMNS=([0-9]+)/', $answer, $matches);

		pclose($file_pointer);

		return $matches[1];
	}

	public static function error($string)
	{
		static::write(console_colors::format(console_colors::bold('[ERR] '), 'red') . $string);
	}

	public static function success($string)
	{
		static::write(console_colors::format(console_colors::bold('[OK]  '), 'green') . $string);
	}

	public static function clear()
	{
		array_map(create_function('$a', 'print chr($a);'), array(27, 91, 72, 27, 91, 50, 74));
	}

	public static function progress($current, $total, $cells = 10, $cell = '#')
	{
		$current = str_pad($current, string::length($total), '0', STR_PAD_LEFT);
		$total   = str_pad($total,   string::length($total), '0', STR_PAD_LEFT);

		$percent = round($current / $total * 100, 2);

		$passed = ceil($percent / (100 / $cells));

		$progress = str_repeat($cell, $passed);
		$progressbar = '[' . str_pad($progress, $cells, ' ', STR_PAD_RIGHT) . ']';

		static::write('(' . $current . '/' . $total . ') ' . $progressbar . ' ' . str_pad($percent, 5, ' ', STR_PAD_LEFT) . '%', false, true);
	}
}
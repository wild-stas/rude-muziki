<?

namespace rude;


global $_foreground_colors;

$_foreground_colors['black']        = '0;30';
$_foreground_colors['dark gray']    = '1;30';
$_foreground_colors['blue']         = '0;34';
$_foreground_colors['light blue']   = '1;34';
$_foreground_colors['green']        = '0;32';
$_foreground_colors['light green']  = '1;32';
$_foreground_colors['cyan']         = '0;36';
$_foreground_colors['light cyan']   = '1;36';
$_foreground_colors['red']          = '0;31';
$_foreground_colors['light red']    = '1;31';
$_foreground_colors['purple']       = '0;35';
$_foreground_colors['light purple'] = '1;35';
$_foreground_colors['brown']        = '0;33';
$_foreground_colors['yellow']       = '1;33';
$_foreground_colors['light gray']   = '0;37';
$_foreground_colors['white']        = '1;37';


global $_background_colors;

$_background_colors['black']        = '40';
$_background_colors['red']          = '41';
$_background_colors['green']        = '42';
$_background_colors['yellow']       = '43';
$_background_colors['blue']         = '44';
$_background_colors['magenta']      = '45';
$_background_colors['cyan']         = '46';
$_background_colors['light gray']   = '47';

class console_colors
{
	public static function format($string, $foreground_color = null, $background_color = null, $bold = false)
	{
		$result = null;

		if ($foreground_color !== null)
		{
			global $_foreground_colors;

			if (isset($_foreground_colors[$foreground_color]))
			{
				$result .= "\033[" . $_foreground_colors[$foreground_color] . "m";
			}
		}

		if ($background_color !== null)
		{
			global $_background_colors;

			if (isset($_background_colors[$foreground_color]))
			{
				$result .= "\033[" . $_background_colors[$foreground_color] . "m";
			}
		}

		$result .= $string . "\033[0m";


		if ($bold !== false)
		{
			$result = static::bold($result);
		}


		return $result;
	}

	public static function bold($string)
	{
		return "\033[1m" . $string . "\033[0m";
	}

	public static function get_colors_foreground()
	{
		global $_foreground_colors;

		return array_keys($_foreground_colors);
	}

	public static function get_colors_background()
	{
		global $_background_colors;

		return array_keys($_background_colors);
	}
}
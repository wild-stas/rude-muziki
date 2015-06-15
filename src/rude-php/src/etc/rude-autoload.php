<?

namespace rude;

require_once 'rude-globals.php';
require_once 'rude-filesystem.php';

$_source_list = filesystem::search_files(realpath(__DIR__ . '/../'), 'php'); # scan for .php files


function autoload($class_name)
{
	global $_source_list;

	if (!$_source_list)
	{
		return;
	}

	$class_name = explode('\\', $class_name);
	$class_name = $class_name[1];                     # rude\example_class => example_class
	$class_name = str_replace('_', '-', $class_name); # example_class => example_class

	foreach ($_source_list as $source_path)
	{
		$source_file = basename($source_path);

		if ($source_file == 'rude-' . $class_name . '.php')
		{
			if (file_exists($source_path))
			{
				require_once $source_path;
				return;
			}
		}
	}
}

spl_autoload_register('rude\autoload');


if (defined('RUDE_DEBUG') and RUDE_DEBUG)
{
	error_reporting(-1); # show all errors/warnings/stricts
}


if (defined('RUDE_TIMEZONE'))
{
	date::set_timezone(RUDE_TIMEZONE); # set default timezone
}



$database = null;

if (defined('RUDE_DATABASE_HOST') and
    defined('RUDE_DATABASE_PASS') and
    defined('RUDE_DATABASE_HOST') and
    defined('RUDE_DATABASE_NAME'))
{
	$database = new database(RUDE_DATABASE_HOST, RUDE_DATABASE_USER, RUDE_DATABASE_PASS, RUDE_DATABASE_NAME, RUDE_DATABASE_PORT);
}


define('RUDE_CLI', php_sapi_name() == 'cli');
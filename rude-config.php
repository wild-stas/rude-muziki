<?

# site url

define('RUDE_SITE_URL', 'http://localhost/rude-muziki/'); # index (homepage) url


# if you want to use database classes - you need to tell script connection settings

define('RUDE_DATABASE_USER', 'root');      # database user
define('RUDE_DATABASE_PASS', '1234');      # database user password
define('RUDE_DATABASE_HOST', 'localhost'); # database host address (you can also use direct ip declaration)
define('RUDE_DATABASE_NAME', 'muziki');    # database name
define('RUDE_DATABASE_PORT', '3306');      # database port


# roles

define('RUDE_ROLE_ADMIN',   1);
define('RUDE_ROLE_COMPANY', 2);
define('RUDE_ROLE_USER',    3);


# directories

define('RUDE_DIR',                    __DIR__);
define('RUDE_DIR_IMG',                RUDE_DIR           . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'img');
define('RUDE_DIR_SRC',                RUDE_DIR           . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'rude-php' . DIRECTORY_SEPARATOR . 'src');
define('RUDE_DIR_WORKSPACE',          RUDE_DIR_SRC       . DIRECTORY_SEPARATOR . 'workspace');
define('RUDE_DIR_WORKSPACE_DATABASE', RUDE_DIR_WORKSPACE . DIRECTORY_SEPARATOR . 'database');


# you can let PHP interpreter show all warnings, errors and stricts

define('RUDE_DEBUG', true);


# also you can tell your current timezone if you want to get correct time results in code

//define('RUDE_TIMEZONE', 'Europe/Minsk');
define('RUDE_TIMEZONE', 'UTC');


# default string encoding

define('RUDE_STRING_ENCODING', 'UTF-8');


# you can use this defines with cookies::set()

define('RUDE_TIME_SECOND', 1);             # 1 second
define('RUDE_TIME_MINUTE', 60);            # 1 minute = 60 seconds
define('RUDE_TIME_HOUR',   3600);          # 1 hour   = 3600 seconds
define('RUDE_TIME_DAY',    86400);         # 1 day    = 86400 seconds
define('RUDE_TIME_MONTH',  2592000);       # 1 month  = 2592000 seconds
define('RUDE_TIME_YEAR',   946080000);     # 1 year   = 946080000 seconds
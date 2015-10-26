<?

namespace rude;

class page_user
{
	public function __construct()
	{
		if (!current::user_is_logged())
		{
			page_403::init(); die;
		}
	}

	public static function init()
	{
		if (get('ajax'))
		{
			static::main();
			return;
		}
		site::doctype();

		?>
		<html>

		<?
		site::head();
		site::header();
		site::menu();
		?>

		<body>
		<?
		static::main();
		site::player();
		?>

		</body>
		</html>
		<?
	}

	public static function main()
	{
		?>

		<script>
			rude.crawler.init();
		</script>
		<div id="page-company">
			<div id="container">




				<div id="content">
					<?// static::sidebar() ?>
					<div id="main">

						<?
						switch (current::task())
						{
							case 'settings': $page = new page_user_settings(); break;
							case 'playlists': $page = new page_user_playlist(); break;

							default:
								$page = new page_user_dashboard();
						}

						$page->init();
						?>

					</div>
				</div>

				<? site::footer() ?>
			</div>
		</div>
	<?
		}

	public static function sidebar()
	{
		?>
		<div id="sidebar" class="ui left vertical inverted labeled icon sidebar menu overlay visible" style="top:40px">

			<?
//				static::sidebar_item_global('User panel', 'home', site::url('user') );

//				static::sidebar_item_admin('',    'browser');
//				static::sidebar_item_admin('Settings',   'configure', 'settings');
//				static::sidebar_item_admin('Playlists',   'music', 'playlists');
//				static::sidebar_item_admin('Заказы',    'money',     'orders');
//				static::sidebar_item_admin('Настройки', 'settings',  'settings');

//				static::sidebar_item_global('Logout', 'sign out', site::url('logout'));
			?>
		</div>
		<?
	}

	public static function sidebar_item_global($title, $icon, $url)
	{
		?>
		<a href="<?= $url ?>" class="item">
			<i class="icon <?= $icon ?>"></i>
			<?= $title ?>
		</a>
		<?
	}

	public static function sidebar_item_admin($title, $icon, $task = null)
	{
		?>
		<a href="<?= site::url(current::page(), $task) ?>" class="item <? if (current::task() == $task) { ?>active<? } ?>">
			<i class="icon <?= $icon ?>"></i>
			<?= $title ?>
		</a>
		<?
	}
}
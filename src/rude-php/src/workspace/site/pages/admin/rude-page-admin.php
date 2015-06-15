<?

namespace rude;

class page_admin
{
	public static function init($title = 'Панель администратора')
	{
		if (!current::user_is_logged() or !current::visitor_is_admin())
		{
			page_403::init(); die;
		}

		site::doctype();

		?>
		<html>

		<? site::head($title) ?>

		<body>

		<div id="page-admin">
			<div id="container">
				<div id="header">
					<h1 class="ui header dividing"><?= $title ?></h1>
				</div>

				<? static::sidebar() ?>

				<div id="content">

					<div id="main">

						<?
							switch (current::task())
							{
								case 'users':    $page = new page_admin_users();    break;
								case 'services': $page = new page_admin_services(); break;
								case 'settings': $page = new page_admin_settings(); break;

								default:
									$page = new page_admin_dashboard();
							}

							$page->init();
						?>

					</div>
				</div>

				<? site::footer() ?>
			</div>
		</div>

		</body>
		</html>
		<?
	}


	public static function sidebar()
	{
		?>
		<div id="sidebar" class="ui left vertical inverted labeled icon sidebar menu overlay visible">
			<?
				static::sidebar_item_global('Главная', 'home', RUDE_SITE_URL);

				static::sidebar_item_admin('Сводка',       'browser');
				static::sidebar_item_admin('Пользователи', 'users',     'users');
				static::sidebar_item_admin('Сервисы',      'configure', 'services');
				static::sidebar_item_admin('Настройки',    'settings',  'settings');

				static::sidebar_item_global('Выход', 'sign out', site::url('logout'));
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
<?

namespace rude;

class page_user
{
	public function __construct()
	{
		if (!current::user_is_logged() or !current::user_is_company())
		{
			page_403::init(); die;
		}
	}
	
	public static function init()
	{
		site::doctype();

		?>
		<html>

		<? site::head() ?>

		<body>

		<div id="page-company">
			<div id="container">
				<div id="header">
					<h1 class="ui header dividing"><?= current::title() ?></h1>
				</div>

				<? static::sidebar() ?>

				<div id="content">

					<div id="main">

						<?
							switch (current::task())
							{
								case 'services': $page = new page_company_services(); break;
								case 'service':  $page = new page_company_service();  break;
								case 'orders':   $page = new page_company_orders();   break;
								case 'jobs':     $page = new page_company_jobs();     break;
								case 'settings': $page = new page_company_settings(); break;

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

				static::sidebar_item_admin('Сводка',    'browser');
				static::sidebar_item_admin('Сервисы',   'configure', 'services');
				static::sidebar_item_admin('Заказы',    'money',     'orders');
//				static::sidebar_item_admin('Настройки', 'settings',  'settings');

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
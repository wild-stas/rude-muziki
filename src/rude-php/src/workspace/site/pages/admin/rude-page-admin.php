<?

namespace rude;

class page_admin
{
	public static function init($title = 'Admin Panel')
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
								case 'users':       $page = new page_admin_users();       break;
								case 'settings':    $page = new page_admin_settings();    break;
								case 'song':        $page = new page_admin_song();        break;
								case 'add_song':    $page = new page_admin_song_add();    break;
								case 'edit_song':   $page = new page_admin_song_edit();   break;
								case 'genre':       $page = new page_admin_genre();       break;
								case 'add_genre':   $page = new page_admin_genre_add();   break;
								case 'edit_genre':  $page = new page_admin_genre_edit();  break;
								case 'author':      $page = new page_admin_author();      break;
								case 'add_author':  $page = new page_admin_author_add();  break;
								case 'edit_author': $page = new page_admin_author_edit(); break;
								case 'playlist':    $page = new page_admin_playlist();    break;
								case 'import':      $page = new page_admin_import();      break;

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
				static::sidebar_item_global('Home', 'home', RUDE_SITE_URL);

				static::sidebar_item_admin('Songs',        'configure',    'song');
				static::sidebar_item_admin('Import Songs', 'disk outline', 'import');
				static::sidebar_item_admin('Genres',       'configure',    'genre');
				static::sidebar_item_admin('Authors',      'users',        'author');
				static::sidebar_item_admin('Playlists',    'list',         'playlist');

				static::sidebar_item_global('Exit', 'sign out', site::url('logout'));
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
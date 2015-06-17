<?

namespace rude;

class page_error
{
	public static function init($title, $message)
	{
		if (get('ajax'))
		{
			static::main($title, $message);

			return;
		}

		site::doctype();

		?>
		<html>

		<? site::head($title) ?>

		<body>
		<div id="container">

			<? site::header($title) ?>

			<div id="page-error">
				<? site::menu() ?>

				<div id="content">
					<? static::main($title, $message) ?>
				</div>
			</div>

			<? site::footer() ?>
		</div>

		</body>
		</html>
		<?
	}


	public static function main($title, $message)
	{
		?>
		<div id="main" class="center ui segment">
			<h1 class="ui header red"><?= $title ?></h1>

			<p><?= $message ?></p>
		</div>
		<?
	}
}
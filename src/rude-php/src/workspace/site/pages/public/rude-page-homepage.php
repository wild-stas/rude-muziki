<?

namespace rude;

class page_homepage
{
	public function __construct()
	{

	}

	public function init()
	{
		site::doctype();

		?>
		<html>

		<? site::head() ?>

		<body>
		<div id="container">

			<? site::menu() ?>

			<? site::logo() ?>

			<div id="page-homepage">

				<div id="content">
					<? static::main() ?>
				</div>
			</div>

			<? site::footer() ?>

			<? site::player() ?>
		</div>

		</body>
		</html>
		<?
	}


	public function main()
	{
		?>
		<div id="main">

			<div class="filters">
				<div class="ui form">
					<div class="ui two fields">

					</div>
				</div>
			</div>

			<div class="ui special cards">

			</div>
		</div>

		<script>
			rude.semantic.init.rating();

			rude.semantic.init.dropdown();
			
			rude.crawler.init();
		</script>
		<?
	}

	public function card($service)
	{
		?>
		<div class="black card">
			<div class="content">
				<a href="<?= site::url('service') ?>&id=<?= $service->id ?>" class="header"><?= html::escape(string::excerpt($service->name, 100)) ?></a>

				<p class="address"><?= html::escape($service->address) ?></p>

				<div class="">
					<?= html::escape(string::excerpt($service->description, 160)) ?>
				</div>
			</div>

			<div class="extra content">
				Отзывов: <?= $service->comments_count ?>.
			</div>
		</div>
		<?
	}
}
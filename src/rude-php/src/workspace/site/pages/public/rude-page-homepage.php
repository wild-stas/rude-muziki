<?

namespace rude;

class page_homepage
{
	public function __construct()
	{

	}

	public function init()
	{
		if (get('ajax'))
		{
			static::main();

			return;
		}


		site::doctype();

		?>
		<html>

		<? site::head() ?>

		<body>
		<div id="container">

			<? site::menu() ?>

			<? site::header() ?>

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
			<div class="ui double six cards">
				<?
					$songs = songs::get_last(100);

					foreach ($songs as $song)
					{


						?>
						<div class="card">
							<div class="image">
								<?
									if ($song->file_image == 'dummy.png' or $song->file_image == 'dummy.jpg')
									{
										?><i class="icon music"></i><?
									}
									else
									{
										?><img src="src/img/covers/<?= $song->file_image ?>"><?
									}
								?>
							</div>
							<div class="content">
								<a class="header" onclick=""><?= $song->name ?></a>

								<div class="ui divider">

								</div>

								<div class="description">
									<div class="ui icon labeled button bottom fluid" onclick="rude.player.song.add('<?= $song->file_audio ?>', '', '', '<?= $song->file_audio ?>'); rude.player.manager.play('<?= $song->file_audio ?>'); rude.player.manager.setVolume('<?= $song->file_audio ?>', 20);">
										<i class="icon video play"></i> Listen
									</div>
								</div>
							</div>
						</div>
						<?
					}
				?>
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
<?

namespace rude;

class page_news
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

			<script>
				rude.crawler.init();
			</script>
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
		$admin_playlists = playlists::get_last(playlists::count());
		?>

		<div id="main">
			<div id="" class="ui double six doubling" style="font-size: 0;">
				<?
					if ($admin_playlists)
					{
						foreach ($admin_playlists as $admin_playlist)
						{
							if ($admin_playlist->is_news==1)
							static::admin_playlist($admin_playlist);
						}
					}
				?>
			</div>
		</div>
		<script>
			$( document ).ready(function() {
				$('.playlist_card.add_new_one').height($('.playlist_card').height());

				$(".playlist_card").each(function() {
					if ($( this ).data( "id" )==$('#current_playlist').val()){
						$( this).addClass('active');
					}
				});
			});
			function listen_all(selector){
				$('#current_playlist').val($(selector).parent().data('id'));
				$('.playlist_card').removeClass('active');
				$(selector).parent().addClass('active');
				rude.player.playlist.remove();
				rude.player.init();
				var songs_cont = $(selector).parent().find('.song_container');
				var all_songs = $(songs_cont).find('span');
				$( all_songs ).each(function(  ) {
					rude.player.song.add($(this).data('file_audio'), $(this).data('name'), $(this).data('author_name'),'false');
				});
			}

		</script>

		<?
	}



	public static function admin_playlist($admin_playlist)
	{
		?>


		<div class="playlist_card " data-id="public_<?= $admin_playlist->id ?>">
			<div class="image">
				<?
				if ($admin_playlist->file_image)
				{
					?><img src="src/img/<?= $admin_playlist->id ?>/<?= $admin_playlist->file_image ?>"><?
				}
				else
				{
					?><img src="src/img/covers/image.png"><?
				}
				?>
			</div>
			<div class="ui icon button" onclick="listen_all(this)">
				<i class="icon video play"></i>
			</div>
			<div class="content">
				<a href="?page=news_item&type=public&id=<?= $admin_playlist->id ?>"><p class="header"><?= $admin_playlist->name ?></p></a>
				<div class="ui divider"></div>

				<div class="description">
					<? $song_ids = playlist_items::get_by_playlist_id($admin_playlist->id); ?>
					<span>Total: <?= count($song_ids) ?> tracks</span></p>
				</div>
			</div>

			<div class="song_container" style="display: none">
				<?
				if ($song_ids)
				{
					foreach ($song_ids as $song_id)
					{
						$song = songs::get_by_id($song_id->song_id,true);

						?>
						<span data-file_audio="<?= $song->file_audio ?>" data-name="<?= $song->name ?>" data-author_name="<?= song_authors::get_by_id($song->author_id,true)->name; ?>"></span>
					<?}
				}
				?>
			</div>

			<script>
				rude.crawler.init();
			</script>

		</div>
	<?
	}
}
<?

namespace rude;

class page_playlists
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
		$admin_playlists = playlists::get();
		if (current::user_id()){
			$user_playlists = user_playlists::get_by_user_id(current::user_id());
		}else
		{
			$user_playlists = '';
		}
		?>

		<div id="main">
			<div id="" class="ui double six doubling" style="font-size: 0;">
				<?
					if ($admin_playlists)
					{
						foreach ($admin_playlists as $admin_playlist)
						{
							static::admin_playlist($admin_playlist);
						}
					}



					if ($user_playlists)
					{
						foreach ($user_playlists as $user_playlist)
						{
							static::user_playlist($user_playlist);
						}
					}
				if (current::user_id()){
				?>
				<div class="playlist_card add_new_one">
					<a href="/index.php?page=user&task=playlists"><span>
							<span style="vertical-align: middle; display: table-cell">
					<i class="icon add"></i><br>
					Create a Playlist
						</span></span></a>
				</div>

				<?}?>
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
			<div class="ui icon labeled button bottom fluid" onclick="listen_all(this)">
				<i class="icon video play"></i> Listen
			</div>
			<div class="content">
				<a href="?page=playlist&type=public&id=<?= $admin_playlist->id ?>"><p class="header"><?= $admin_playlist->name ?></p></a>
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



		</div>
	<?
	}

	public static function user_playlist($user_playlist)
	{
		?>
		<div class="playlist_card " data-id="user_<?= $user_playlist->id ?>">
			<div class="image">
				<?
				if ($user_playlist->file_image)
				{
					?><img src="src/img/playlist_covers/<?= $user_playlist->id ?>/<?= $user_playlist->file_image ?>"><?
				}
				else
				{
					?><img src="src/img/covers/image.png"><?
				}
				?>
			</div>
			<div class="ui icon labeled button bottom fluid" onclick="listen_all(this)">
				<i class="icon video play"></i> Listen
			</div>
			<div class="content">
				<a href="?page=playlist&type=user&id=<?= $user_playlist->id ?>"><p class="header"><?= $user_playlist->name ?></p></a>

				<div class="ui divider"></div>

				<div class="description">
					<? $song_ids = user_playlist_items::get_by_playlist_id($user_playlist->id); ?>
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
		</div>
		<script>
			rude.crawler.init();
		</script>

	<?
	}
}
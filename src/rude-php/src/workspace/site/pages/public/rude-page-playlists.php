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
		<div id="modal-vote-denied" class="ui small modal transition">
			<i class="close icon"></i>
			<div class="header">
				Vote Denied
			</div>
			<div class="content">
				<p>You must be <a href="<?= site::url('login') ?>" onclick="$('#modal-vote-denied').modal('hide')">logged in</a> to vote for songs.</p>
			</div>
			<div class="actions">
				<div class="ui positive right labeled icon button">
					OK
					<i class="checkmark icon"></i>
				</div>
			</div>
		</div>

		<div id="main">
			<div id="recent" class="ui double six doubling" style="font-size: 0;">
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
				?>
			</div>
		</div>
		<script>
			rude.semantic.init.rating();

			function listen_all(selector){
				var songs_cont = $(selector).parent().parent().find('.song');
				var all_songs = $(songs_cont).find('.play');
				$( all_songs ).each(function(  ) {
					rude.player.song.add($(this).data('file_audio'), $(this).data('name'), $(this).data('author_name'),'false');
				});
			}

			function play_song(selector){
				rude.player.song.add($(selector).data('file_audio'), $(selector).data('name'), $(selector).data('author_name'),'false');
				rude.player.song.play($(selector).data('file_audio'));
			}

			function vote(selector)
			{
				var is_logged = <?= (int) current::user_is_logged() ?>;

				if (!is_logged)
				{
					$('#modal-vote-denied').modal('show');

					return;
				}


				var song_id = $(selector).attr('data-song-id');

				var value = $(selector).find('.icon.active').length;

				debug(value);

				$.ajax
				({
					url: 'index.php',

					type: 'GET',

					data:
					{
						page: 'ajax',
						task: 'rating',
						song_id: song_id,
						value: value
					},

					success: function (data)
					{
						debug(data);
					}
				});
			}
		</script>

		<?
	}



	public static function admin_playlist($admin_playlist)
	{
		?>


		<div class="playlist_card ">
			<div class="image">
				<?
				if ($admin_playlist->file_image)
				{
					?><img src="src/img/<?= $admin_playlist->id ?>/<?= $admin_playlist->file_image ?>"><?
				}
				else
				{
					?><i class="icon music"></i><?
				}
				?>
				<div class="ui icon labeled button bottom fluid" onclick="listen_all(this)">
					<i class="icon video play"></i> Listen
				</div>
			</div>
			<div class="content">
				<p class="header"><?= $admin_playlist->name ?></p>

				<div class="ui divider"></div>

				<div class="description">
					<? $song_ids = playlist_items::get_by_playlist_id($admin_playlist->id); ?>
					<span style="cursor: pointer" onclick="$('#modal_playlist_user_<?= $admin_playlist->id ?>').modal('show');">Total: <?= count($song_ids) ?> tracks</span></p>
				</div>
			</div>



			<div id="modal_playlist_user_<?= $admin_playlist->id ?>" class="ui small modal transition">
				<div class="playlist_card_more">
					<div class="image">
						<?
						if ($admin_playlist->file_image)
						{
							?><img src="src/img/<?= $admin_playlist->id ?>/<?= $admin_playlist->file_image ?>"><?
						}
						else
						{
							?><i class="icon music"></i><?
						}
						?>
						<div class="ui icon labeled button bottom fluid" onclick="listen_all(this)">
							<i class="icon video play"></i> Listen
						</div>
					</div>
					<div class="content">
						<p class="header"><?= $admin_playlist->name ?></p>
						<p class="header"><?= $admin_playlist->title ?></p>
						<div class="ui divider"></div>

						<div class="description">
							<p class="description"><?= $admin_playlist->description ?>

								<span style="float: right" >Total: <?= count($song_ids) ?> tracks</span></p>
						</div>
					</div>
					<table class="ui table striped celled small compact">
						<thead>
						<tr>
							<th class="center small">Play</th>
							<th>Name</th>
							<th>Author</th>
							<th>Lenght</th>
							<th>Rating</th>
						</tr>
						</thead>
						<tbody>
						<?
						if ($song_ids)
						{
							foreach ($song_ids as $song_id)
							{
								$ratings = ratings::get_by_song_id($song_id->song_id);

								$song = songs::get_by_id($song_id->song_id,true);

								?>
								<tr class="song <?= $song->file_audio ?>">
									<td class="width-2"><i class="icon video play" onclick="play_song(this)" data-file_audio="<?= $song->file_audio ?>" data-name="<?= $song->name ?>" data-author_name="<?= song_authors::get_by_id($song->author_id,true)->name; ?>"></i></td>
									<td><?= $song->name ?></td>
									<td><?= song_authors::get_by_id($song->author_id,true)->name; ?></td>
									<td><?= gmdate("i:s", $song->length); ?></td>
									<td class="center small"><div class="rating box">
											<?
											$rating = 0;
											if ($ratings)
											{
												$rating_value = 0;
												$rating_votes = 0;
												foreach ($ratings as $rating_song){
													$rating_value += $rating_song->value;
													$rating_votes++;
												}
												$rating = float::to_upper($rating_value / $rating_votes);
											}
											?>

											<div class="ui star tiny rating" data-song-id="<?= $song->id ?>" data-rating="<?= $rating ?>" data-max-rating="5" onclick="vote(this)"></div>
										</div></td>
								</tr>
							<?}
						}
						?>
						</tbody>
					</table>

				</div>





			</div>



		</div>
	<?
	}

	public static function user_playlist($user_playlist)
	{
		?>
		<div class="playlist_card ">
			<div class="image">
				<?
				if ($user_playlist->file_image)
				{
					?><img src="src/img/playlist_covers/<?= $user_playlist->id ?>/<?= $user_playlist->file_image ?>"><?
				}
				else
				{
					?><i class="icon music"></i><?
				}
				?>
				<div class="ui icon labeled button bottom fluid" onclick="listen_all(this)">
					<i class="icon video play"></i> Listen
				</div>
			</div>
			<div class="content">
				<p class="header"><?= $user_playlist->name ?></p>

				<div class="ui divider"></div>

				<div class="description">
					<? $song_ids = user_playlist_items::get_by_playlist_id($user_playlist->id); ?>
					<span style="cursor: pointer" onclick="$('#modal_playlist_user_<?= $user_playlist->id ?>').modal('show');">Total: <?= count($song_ids) ?> tracks</span></p>
				</div>
			</div>



			<div id="modal_playlist_user_<?= $user_playlist->id ?>" class="ui small modal transition">
				<div class="playlist_card_more">
					<div class="image">
						<?
						if ($user_playlist->file_image)
						{
							?><img src="src/img/playlist_covers/<?= $user_playlist->id ?>/<?= $user_playlist->file_image ?>"><?
						}
						else
						{
							?><i class="icon music"></i><?
						}
						?>
						<div class="ui icon labeled button bottom fluid" onclick="listen_all(this)">
							<i class="icon video play"></i> Listen
						</div>
					</div>
					<div class="content">
						<p class="header"><?= $user_playlist->name ?></p>
						<p class="header"><?= $user_playlist->title ?></p>
						<div class="ui divider"></div>

						<div class="description">
							<p class="description"><?= $user_playlist->description ?>

								<span style="float: right" >Total: <?= count($song_ids) ?> tracks</span></p>
						</div>
					</div>
					<table class="ui table striped celled small compact">
						<thead>
						<tr>
							<th class="center small">Play</th>
							<th>Name</th>
							<th>Author</th>
							<th>Lenght</th>
							<th>Rating</th>
						</tr>
						</thead>
						<tbody>
						<?
						if ($song_ids)
						{
							foreach ($song_ids as $song_id)
							{
								$ratings = ratings::get_by_song_id($song_id->song_id);

								$song = songs::get_by_id($song_id->song_id,true);

								?>
								<tr class="song <?= $song->file_audio ?>">
									<td class="width-2"><i class="icon video play" onclick="play_song(this)" data-file_audio="<?= $song->file_audio ?>" data-name="<?= $song->name ?>" data-author_name="<?= song_authors::get_by_id($song->author_id,true)->name; ?>"></i></td>
									<td><?= $song->name ?></td>
									<td><?= song_authors::get_by_id($song->author_id,true)->name; ?></td>
									<td><?= gmdate("i:s", $song->length); ?></td>
									<td class="center small"><div class="rating box">
											<?
											$rating = 0;
											if ($ratings)
											{
												$rating_value = 0;
												$rating_votes = 0;
												foreach ($ratings as $rating_song){
													$rating_value += $rating_song->value;
													$rating_votes++;
												}
												$rating = float::to_upper($rating_value / $rating_votes);
											}
											?>

											<div class="ui star tiny rating" data-song-id="<?= $song->id ?>" data-rating="<?= $rating ?>" data-max-rating="5" onclick="vote(this)"></div>
										</div></td>
								</tr>
							<?}
						}
						?>
						</tbody>
					</table>

				</div>





			</div>



		</div>


	<?
	}
}
<?

namespace rude;

class page_playlist
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
		if (get('type')=='public')
		{
			$playlist = playlists::get_by_id(get('id'),true);
		}
		elseif (get('type')=='user' && current::user_id()){
			$playlist = user_playlists::get_by_id(get('id'),true);
		}
		else
		{
			$playlist = '';
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
			<div id="" class="ui double six doubling">
				<div class="playlist_card_more">
					<?
					if (get('type')=='public')
					{
						$song_ids = playlist_items::get_by_playlist_id($playlist->id);
					}
					elseif (get('type')=='user' && current::user_id()){
						$song_ids = user_playlist_items::get_by_playlist_id($playlist->id);
					}
					else
					{
						$song_ids = '';
					}
					?>
							<div class="image">
								<?
								if ($playlist->file_image && get('type')=='public')
								{
									?><img src="src/img/<?= $playlist->id ?>/<?= $playlist->file_image ?>"><?
								}
								elseif (get('type')=='user' && current::user_id())
								{
									?><img src="src/img/playlist_covers/<?= $playlist->id ?>/<?= $playlist->file_image ?>"><?
								}
								else
								{
									?><img src="src/img/covers/image.png"><?
								}
								?>
								<div class="ui icon labeled button bottom fluid" onclick="listen_all(this)">
									<i class="icon video play"></i> Listen
								</div>
							</div>
							<div class="content">
								<p class="header"><?= $playlist->name ?></p>
								<p class="header"><?= $playlist->title ?></p>
								<div class="ui divider"></div>

								<div class="description">
									<p class="description"><?= $playlist->description ?>

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
											<td class="center"><div class="rating box">
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
			rude.crawler.init();
		</script>

		<?
	}
}
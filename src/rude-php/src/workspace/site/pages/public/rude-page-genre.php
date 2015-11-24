<?

namespace rude;

class page_genre
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
		$genre = song_genres::get_by_id(get('id'),true);
		if (!$genre){
			return;
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
				<div class="playlist_card_more" >

							<div class="image">
								<?
								if ($genre->file_image )
								{
									?><img src="src/img/genres/<?= $genre->file_image ?>"><?
								}
								else
								{
									?><img src="src/img/covers/image.png"><?
								}
								$songs = songs::get_by_genre_id($genre->id);
								?>
								<div class="ui icon labeled button bottom fluid" onclick="listen_all(this)">
									<i class="icon video play"></i> Listen
								</div>
							</div>
							<div class="content">
								<p class="header"><?= $genre->name ?></p>
								<div class="ui divider"></div>
								<div class="description">
									<span style="float: right" >Total: <?= count($songs) ?> tracks</span></p>
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
								if ($songs)
								{
									foreach ($songs as $song)
									{
										$ratings = ratings::get_by_song_id($song->id);


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
				rude.player.playlist.remove();

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
			$( document ).ready(function() {
				if (rude.player.song.id())
				{
					$('.' + rude.jquery.escape.selector(rude.player.song.id())).addClass('active');
				}
			});
		</script>

		<?
	}
}
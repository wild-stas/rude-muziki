<?

namespace rude;

class page_song
{
	private $song    = null;
	private $song_id = null;
	private $song_author = null;
	private $song_genre = null;

	private $comments = null;

	public function __construct()
	{
		if (rewrite::is_enabled())
		{
			$song = songs::get_by_alias(rewrite::query(), true);

			if ($song)
			{
				$this->song_id = (int) $song->id;
			}
		}
		else
		{
			$this->song_id = (int) get('id');
		}

		if (!$this->song_id)
		{
			return;
		}


		$database = database();
		$database->query(
		'
			SELECT
				songs.*,

				song_authors.name AS author_name,
				song_genres.name  AS genre_name,
				song_genres.id    AS genre_id,

				(SELECT   SUM(value) FROM ratings WHERE song_id = songs.id) AS rating_value,
				(SELECT COUNT(id)    FROM ratings WHERE song_id = songs.id) AS rating_votes

			FROM
				songs
			LEFT JOIN
				song_authors ON song_authors.id = songs.author_id
			LEFT JOIN
				song_genres ON song_genres.id = songs.genre_id
			LEFT JOIN
				ratings ON ratings.song_id = songs.id
			WHERE
				songs.id = ' . (int) $this->song_id . '
			GROUP BY
				songs.id
		');

		$this->song = $database->get_object();


		$this->song_author = song_authors::get_by_id($this->song->author_id,true);
		$this->song_genre = song_genres::get_by_id($this->song->genre_id,true);


		$database->query
		('
			SELECT
				comments.*,

				users.name AS user_name
			FROM
				comments
			LEFT JOIN
				users ON users.id = comments.user_id
			WHERE
				comments.song_id = ' . (int) $this->song_id . '
		');

		$this->comments = $database->get_object_list();

		static::validate();
	}

	public function init()
	{
		if (!$this->song)
		{
			page_404::init();
		}

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

					<? site::header() ?>

					<div id="page-song">

						<? site::menu() ?>

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

	public function validate()
	{
		switch (get('action'))
		{
			case 'comment-add': static::comment_add();
		}
	}

	public function comment_add()
	{
		$message = get('message');

		if (!$message)
		{
			errors::add('Comment should not be empty.');
		}

		if (!errors::get())
		{
			$comment_id = comments::add($this->song->id, current::user_id(), $message);

			if ($comment_id)
			{
				headers::refresh(url::current() . '#comment-' . $comment_id);
			}
			else
			{
				errors::add('Fatal error.');
			}
		}
	}

	public function main()
	{
		?>
		<div id="main">
			<div id="song" class="ui two column grid">
				<div class="six wide column">
					<div class="ui segment">
						<?
							if ($this->song->file_image)
							{
								?><img src="<?= RUDE_SITE_URL ?>src/img/covers/<?= $this->song->file_image ?>"><?
							}
							else
							{
								?><img src="<?= RUDE_SITE_URL ?>src/img/covers/image.png"><?
							}
						?>
					</div>
				</div>

				<div class="ten wide column">
					<div class="ui segment">
						<?
							$rating = 0;

							if ($this->song->rating_votes)
							{
								$rating = $this->song->rating_value / $this->song->rating_votes;
							}
						?>

						<h3 class="ui header dividing"><?= $this->song_author->name ?> - <?= $this->song->name ?></h3>

						<div class="ui star tiny rating" data-song-id="<?= $this->song->id ?>" data-rating="<?= float::to_upper($rating) ?>" data-max-rating="5" onclick="vote(this)"></div>

						<div class="ui divider"></div>

						<p>
							<b>Author:</b> <?= $this->song_author->name ?>.<br>
							<b>Name:</b> <?= $this->song->name ?>.<br>
							<b>Genre:</b> <a href="<?= RUDE_SITE_URL ?>?page=homepage&genre_id=<?= $this->song->genre_id ?>"><?= $this->song_genre->name ?></a>.<br>
						</p>

						<div class="ui divider"></div>

						<p>
							<b>Song rating:</b> <?= round($rating, 1) ?>
						</p>

						<div class="ui divider"></div>

						<div class="ui icon labeled button" onclick="rude.player.song.add('<?= $this->song->file_audio ?>', '<?= $this->song->name ?>', '<?= $this->song->author_name ?>'); rude.player.song.play('<?= $this->song->file_audio ?>')">
							<i class="icon video play"></i> Listen
						</div>
					</div>

				</div>
			</div>

			<script>
				rude.semantic.init.dropdown();
				rude.semantic.init.rating();
				rude.crawler.init();

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
						url: '/index.php',

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

			<? static::comments() ?>
		</div>
		<?
	}

	public function comments()
	{
		?>
		<div id="comments" class="ui segment comments">
		<?
			if ($this->comments)
			{

				foreach ($this->comments as $comment)
				{
					$user_avatar = users::get_by_id($comment->user_id,true)->avatar;
					?>
					<div class="comment">
						<a class="avatar">
							<img src="<?= RUDE_SITE_URL ?><? if ($user_avatar) { echo $user_avatar;}else{ echo 'src/img/avatar.png'; }?>">
						</a>
						<div class="content">
							<a name="comment-<?= $comment->id ?>" class="author"><?= $comment->user_name ?></a>
							<div class="metadata">
								<div class="date"><?= $comment->timestamp ?></div>
							</div>
							<div class="text">
								<p><?= nl2br(html::escape($comment->text)) ?></p>
							</div>
							<div class="actions">
								<a class="reply" onclick="$('#message').val($(this).parent().parent().find('.author').html() + ', ').focus();">Reply</a>
							</div>
						</div>
					</div>
					<?
				}
			}
			else
			{
				?><p>There's no any comment yet. You can be first ;)</p><?
			}

			if (current::user_is_logged())
			{
				?>
				<form id="comment-form" class="ui reply error form" method="post">

					<? site::error('При попытке добавления нового комментария возникли некоторые сложности:') ?>

					<input type="hidden" name="action" value="comment-add">

					<div class="field">
						<textarea id="message" name="message" placeholder="Your comment..."><?= get('message') ?></textarea>
					</div>
					<button type="reset" class="ui primary submit labeled icon button" onclick="rude.comment.add('<?= site::url('song', null, $this->song_id) ?>')">
						<i class="icon edit"></i> Submit Comment
					</button>
				</form>
				<?
			}
			else
			{
				?><div class="ui divider"></div><p>You must be <a href="<?= site::url('login') ?>">logged in</a> to leave a comment.<p><?
			}
		?>
		</div>
		<?
	}
}
<?

namespace rude;

class page_song
{
	private $song    = null;
	private $song_id = null;

	private $comments = null;

	public function __construct()
	{
		$this->song_id = (int) get('id');
		$this->song = songs::get($this->song_id);


		$database = database();
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

			<? site::head(true) ?>

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
			<div id="song" class="ui segment">

				<div class="title">
					<h3 class="ui header dividing"><?= $this->song->name ?></h3>

<!--					<div class="ui heart rating" data-rating="4" data-max-rating="5"></div>-->

					<script>
						rude.semantic.init.rating();
					</script>
				</div>

				<div class="image">
<!--					--><?//
//						if ($this->song->file_image)
//						{
//							?><!--<img src="src/img/covers/--><?//= $this->song->file_image ?><!--">--><?//
//						}
//						else
//						{
//							?><!--<i class="icon music"></i>--><?//
//						}
//					?>
				</div>
			</div>

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
					?>
					<div class="comment">
						<a class="avatar">
							<img src="src/img/avatar.png">
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
<?

namespace rude;

class page_user_playlist
{
	public static function init()
	{
		?>
		<div id="container">




			<div id="page-homepage">

				<div id="content">
					<? switch (get('task2'))
					{
						case 'edit': static::edit(); break;

						default: static::main();
					}
					?>
				</div>
			</div>
		</div>

		</body>
		</html>
		<?

	}

	public static function get_playlist()
	{
		$playlist_id = get('playlist-id');

		return user_playlists::get($playlist_id);
	}

	public static function get_playlist_items()
	{
		$playlist_id = get('playlist-id');

		$database = database();

		$q =
			'
				SELECT
					user_playlist_items.*,

					songs.name   AS song_name,
					songs.genre_id  AS song_genre,
					songs.author_id AS song_author,
					songs.timestamp   AS song_date
				FROM
					user_playlist_items
				LEFT JOIN
					songs ON songs.id = user_playlist_items.song_id
				WHERE
					user_playlist_items.playlist_id = ' . (int) $playlist_id . '
		';

		$database->query($q);

		return $database->get_object_list();
	}

	public static function edit_actions()
	{
		$playlist_id = get('playlist-id');

		$action = get('action');

		switch ($action)
		{
			case 'add':

				$song_ids = get('song-ids');

				if ($song_ids)
				{
					foreach ($song_ids as $song_id)
					{
						$q = new query_select('user_playlist_items');
						$q->where('playlist_id', $playlist_id);
						$q->where('song_id', $song_id);
						$q->query();

						if (!$q->get_object_list())
						{
							user_playlist_items::add($playlist_id, $song_id);
						}
					}

					?>
					<div class="ui divider"></div>

					<div class="ui icon message teal">
						<i class="icon plus"></i>

						<div class="content">
							<div class="header">
								Success
							</div>

							<p>Selected songs have been successfully added to your playlist.</p>
						</div>
					</div>

					<div class="ui divider"></div>
				<?
				}

				break;

			case 'remove':

				$song_ids = get('song-ids');

				if ($song_ids)
				{
					$q = new query_delete('user_playlist_items');
					$q->where('song_id', $song_ids);
					$q->where('playlist_id', $playlist_id);
					$q->query();

					?>
					<div class="ui divider"></div>

					<div class="ui icon message orange">
						<i class="icon remove"></i>

						<div class="content">
							<div class="header">
								Success
							</div>

							<p>Selected songs have been successfully removed from your playlist.</p>
						</div>
					</div>

					<div class="ui divider"></div>
				<?
				}

				break;
		}
	}

	public static function get_songs()
	{
		$playlist_id = get('playlist-id');

		$search_name     = get('search-name');
		$search_genre    = get('search-genre');
		$search_author   = get('search-author');


		$database = database();

		$q =
			'
				SELECT
					*,
					songs.id   AS song_id,
					songs.name   AS song_name
				FROM
					songs
					JOIN song_authors on songs.author_id = song_authors.id
				WHERE
					1 = 1 ';

		if ($search_name)   { $q .= 'AND songs.name   LIKE "%' . $database->escape($search_name)   . '%"' . PHP_EOL; }
		if ($search_genre)  { $q .= 'AND genre_id  LIKE "%' . $database->escape($search_genre)  . '%"' . PHP_EOL; }
		if ($search_author) { $q .= 'AND song_authors.name LIKE "%' . $database->escape($search_author) . '%"' . PHP_EOL; }

		$q .=
			'
				ORDER BY
					timestamp DESC
			';

		if (!$search_name and !$search_genre and !$search_author)
		{
			$q .=
				'
					LIMIT 0,100
				';
		}


		$database->query($q);

		return $database->get_object_list();
	}

	public static function edit()
	{
		$playlist = static::get_playlist();

		if (!$playlist)
		{
			return;
		}



		?>

		<a href="?page=user&task=playlists" class="ui teal button icon labeled">
			<i class="icon arrow left"></i>
			Return
		</a>

		<?
		static::edit_actions();
		?>



		<?
		$playlist_items = static::get_playlist_items();


		$songs = static::get_songs();

		$search_name     = get('search-name');
		$search_genre    = get('search-genre');
		$search_author   = get('search-author');

		?>

		<div class="ui segment inverted teal">
			<form class="ui form inverted" method="post" action="javascript:void(null)" onsubmit="search_songs()">

				<h2 class="ui header inverted white">Search Songs</h2>

				<input type="hidden" name="action" value="search">
				<input type="hidden" name="playlist_id" value="<?=$playlist->id?>">


				<div class="field">
					<label for="search-name">Search by Name</label>

					<input id="search-name" name="search-name" value="<?= $search_name ?>">
				</div>

				<div class="field">
					<label for="search-genre">Search by Genre</label>
					<div class="ui fluid selection dropdown">
						<div class="default text" >Select Genre</div>
						<input type="hidden" id="search-genre" name="search-genre" value="<?= $search_genre ?>">
						<div style="max-height: 150px;" class="menu">
							<?
							$song_genres = song_genres::get();
							foreach ($song_genres as $genre)
							{
								?>
								<div class="item" data-value="<?= $genre->id  ?>"><?= $genre->name  ?></div>
							<?
							}?>
						</div>
					</div>
				</div>

				<div class="field">
					<label for="search-author">Search by Author</label>

					<input id="search-author" name="search-author" value="<?= $search_author ?>">
				</div>

				<button type="submit" class="ui orange button icon labeled">
					<i class="icon search"></i>
					Search
				</button>
			</form>
		</div>
		<script type="text/javascript">
			function search_songs(){
				$.ajax({
					type:'POST',
					url:'index.php?page=user&task=playlists&task2=edit',
					data: {
						'playlist-id':$('input[name=playlist_id]').val(),
						ajax: 1,
						'search-name' : $('input[name=search-name]').val(),
						'search-genre' : $('input[name=search-genre]').val(),
						'search-author' : $('input[name=search-author]').val(),
						action : 'search'
					},
					success: function(data){
						$('#content').html(data);
					},
					error: function ()
					{
						console.log('fail!');
					}
				});
			}

			function add_songs(){
				var ids = $('input:checkbox:checked.song-ids').map(function () {
					return this.value;
				}).get();
				$.ajax({
					type:'POST',
					url:'index.php?page=user&task=playlists&task2=edit',
					data: {
						'playlist-id':$('input[name=playlist_id]').val(),
						ajax: 1,
						'search-name' : $('input[name=search-name]').val(),
						'search-genre' : $('input[name=search-genre]').val(),
						'search-author' : $('input[name=search-author]').val(),
						action : 'add',
						'song-ids[]' : ids
					},
					success: function(data){
						$('#content').html(data);
					},
					error: function ()
					{
						console.log('fail!');
					}
				});
			}

			function remove_songs(){
				var ids = $('input:checkbox:checked.song-ids-remove').map(function () {
					return this.value;
				}).get();
				$.ajax({
					type:'POST',
					url:'index.php?page=user&task=playlists&task2=edit',
					data: {
						'playlist-id':$('input[name=playlist_id]').val(),
						ajax: 1,
						'search-name' : $('input[name=search-name]').val(),
						'search-genre' : $('input[name=search-genre]').val(),
						'search-author' : $('input[name=search-author]').val(),
						action : 'remove',
						'song-ids[]' : ids
					},
					success: function(data){
						$('#content').html(data);
					},
					error: function ()
					{
						console.log('fail!');
					}
				});
			}

		</script>

		<script>
			rude.semantic.init.checkbox();
			rude.semantic.init.dropdown();
		</script>

		<div class="ui grid">
			<div class="seven wide column">
				<?

				if (!$songs)
				{
					?>
					<div class="search-results">
						<h4 class="ui header dividing">Search Results (Nothing Found)</h4>
					</div>
				<?
				}
				else
				{
					?>
					<div class="search-results">
						<h4 class="ui header dividing">Search Results (<?= count($songs) ?> Songs Found)</h4>


						<form method="post" action="javascript:void(null)" onsubmit="add_songs()">
							<button class="ui button green labeled icon">
								<i class="icon save"></i>

								Add Selected
							</button>

							<input type="hidden" name="action" value="add">
							<input type="hidden" name="playlist_id" value="<?=$playlist->id?>">

							<input type="hidden" name="search-name" value="<?= $search_name ?>">
							<input type="hidden" name="search-genre" value="<?= $search_genre ?>">
							<input type="hidden" name="search-author" value="<?= $search_author ?>">

							<table class="ui table striped celled search">
								<thead>
								<tr>
									<th class="center small">
										<div class="ui checkbox">
											<input type="checkbox" placeholder="" onchange="$('.search-results tbody input:checkbox').prop('checked', $(this).prop('checked'));">
										</div>
									</th>
									<th>Name</th>
									<th>Genre</th>
									<th>Author</th>
									<th class="small center">Date Published</th>
								</tr>
								</thead>

								<tbody>
								<?
								foreach ($songs as $song)
								{
									$is_checked = false;

									if ($playlist_items)
									{
										foreach ($playlist_items as $playlist_item)
										{
											if ($playlist_item->song_id == $song->song_id)
											{
												$is_checked = true;
											}
										}
									}


									?>
									<tr>
										<td class="center">
											<div class="ui checkbox">
												<input type="checkbox" class="song-ids" name="song-ids[]" value="<?= $song->song_id ?>" placeholder="" <? if ($is_checked) { ?>checked="checked"<? } ?>>
											</div>
										</td>
										<td><a href="#" target="_blank"><?= static::highlight($song->song_name, $search_name) ?></a></td>
										<td><?= song_genres::get_by_id($song->genre_id,true)->name; ?></td>
										<td><?= song_authors::get_by_id($song->author_id,true)->name ?></td>
										<td class="center"><?= date::date('.', strtotime($song->timestamp)) ?></td>
									</tr>
								<?
								}
								?>
								</tbody>
							</table>

							<button class="ui button green labeled icon">
								<i class="icon save"></i>

								Add Selected
							</button>
						</form>
					</div>
				<?
				}
				?>
			</div>

			<div class="two wide column">

			</div>

			<div class="seven wide column">
				<?
				if (!$playlist_items)
				{
					?>
					<div class="playlist-songs">
						<h4 class="ui header dividing">Songs in Playlist (Nothing Found)</h4>
					</div>
				<?
				}
				else
				{
					?>
					<div class="playlist-songs">
						<h4 class="ui header dividing">Songs in Playlist (<?= count($playlist_items) ?> Songs Total)</h4>

						<form method="post" action="javascript:void(null)" onsubmit="remove_songs()">

							<button class="ui button red labeled icon">
								<i class="icon remove"></i>

								Remove Selected
							</button>

							<input type="hidden" name="action" value="remove">
							<input type="hidden" name="playlist_id" value="<?=$playlist->id?>">

							<input type="hidden" name="search-name"   value="<?= $search_name ?>">
							<input type="hidden" name="search-genre"  value="<?= $search_genre ?>">
							<input type="hidden" name="search-author" value="<?= $search_author ?>">

							<table class="ui table striped celled">
								<thead>
								<tr>
									<th class="center small">
										<div class="ui checkbox">
											<input type="checkbox" placeholder="" onchange="$('.playlist-songs tbody input:checkbox').prop('checked', $(this).prop('checked'));">
										</div>
									</th>
									<th>Name</th>
									<th>Genre</th>
									<th>Author</th>
									<th class="small center">Date Published</th>
								</tr>
								</thead>

								<tbody>
								<?

								foreach ($playlist_items as $playlist_item)
								{
									?>
									<tr>
										<td>
											<div class="ui checkbox">
												<input type="checkbox" class="song-ids-remove" name="song-ids" value="<?= $playlist_item->song_id ?>" placeholder="">
											</div>
										</td>

										<td><a href="<?= url::host(true) ?>/#about<?= $playlist_item->song_id ?>" target="_blank"><?= $playlist_item->song_name ?></a></td>
										<td><?= song_genres::get_by_id($playlist_item->song_genre,true)->name; ?></td>
										<td><?= song_authors::get_by_id($playlist_item->song_author,true)->name ?></td>
										<td class="center"><?= date::date('.', strtotime($playlist_item->song_date)) ?></td>
									</tr>
								<?
								}
								?>
								</tbody>
							</table>

							<button class="ui button red labeled icon">
								<i class="icon remove"></i>
								Remove Selected
							</button>

						</form>
					</div>
				<?
				}
				?>
			</div>
		</div>
	<?
	}

	public static function highlight($string, $substring)
	{
		if (!$substring or !string::contains($string, $substring, false))
		{
			return $string;
		}

		return string::replace($string, $substring, '<span class="highlight">' . $substring . '</span>', false);
	}

	public static function main()
	{
		switch (get('action'))
		{
			case 'add':

				$name = get('playlist-name');
				$title = get('playlist-title');
				$description = get('playlist-description');

				if ($name and $title and $description)
				{
					$playlist_id = user_playlists::add(current::user_id(),$name, $title, $description);

					$cover = items::to_object(get('playlist-logo', $_FILES));

					if (mime::is_image($cover->type))
					{
						$cover_dir = RUDE_DIR_IMG . DIRECTORY_SEPARATOR .'playlist_covers'. DIRECTORY_SEPARATOR . $playlist_id;

						if (!filesystem::is_exists($cover_dir))
						{
							filesystem::create_directory($cover_dir, 0755, true);
						}

						$cover_name = $playlist_id . '.' . filesystem::file_extension($cover->name);

						filesystem::move($cover->tmp_name, $cover_dir . DIRECTORY_SEPARATOR . $cover_name);

						$playlist = new user_playlist($playlist_id);
						$playlist->file_image = $cover_name;
						$playlist->update();
					}

					?>
					<script>
						rude.crawler.open('?page=user&task=playlists');
					</script>
					<?
				}

				break;

			case 'update':

				$playlist_id = get('playlist-update-id');

				$name = get('playlist-update-name');
				$title = get('playlist-update-title');
				$description = get('playlist-update-description');

				if ($name and $title and $description)
				{
					user_playlists::update($playlist_id,current::user_id(), $name, $title, $description);


					$cover = items::to_object(get('playlist-update-logo', $_FILES));

					if (mime::is_image($cover->type))
					{
						$cover_dir = RUDE_DIR_IMG . DIRECTORY_SEPARATOR .'playlist_covers'. DIRECTORY_SEPARATOR . $playlist_id;

						if (!filesystem::is_exists($cover_dir))
						{
							filesystem::create_directory($cover_dir, 0755, true);
						}

						$cover_name = $playlist_id . '.' . filesystem::file_extension($cover->name);

						filesystem::move($cover->tmp_name, $cover_dir . DIRECTORY_SEPARATOR . $cover_name);

						$playlist = new user_playlist($playlist_id);
						$playlist->file_image = $cover_name;
						$playlist->update();
					}

					?>
					<script>
						rude.crawler.open('?page=user&task=playlists');
					</script>
					<?
				}

				break;

			case 'remove':

				$playlist_id = get('playlist-id');

				$playlist = new user_playlist($playlist_id);
				$playlist->delete();

				user_playlist_items::remove_by_playlist_id($playlist_id);

				?>
					<script>
						rude.crawler.open('?page=user&task=playlists');
					</script>
					<?
				break;
		}


		if (get('open_add')=='1'){?>
		<script>
			$( document ).ready(function()
			{
				$('#modal-add').modal({closable: false}).modal('show');
			});
		</script>
		<?}?>
		<form id="modal-add" class="ui modal transition coupled" method="post" action="javascript:void(null)" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html" onsubmit="return rude.playlist.validate.add()">
			<i class="close icon"></i>
			<div class="header">
				Create New Playlist
			</div>
			<div class="content">
				<div class="ui form">

					<input type="hidden" name="action" value="add">

					<div class="three fields">
						<div class="field">
							<label for="playlist-name">Playlist Name</label>

							<input id="playlist-name" name="playlist-name">
						</div>

						<div class="field">
							<label for="playlist-title">Playlist Title</label>

							<input id="playlist-title" name="playlist-title">
						</div>

						<div class="field">
							<label>Playlist cover</label>
							<label id="playlist-logo-label" for="playlist-logo" class="ui icon button basic"><i class="icon folder open"></i> Click and select the image</label>

							<input id="playlist-logo" name="playlist-logo" type="file" style="display: none;">

							<script>
								$('#playlist-logo').change(function()
								{
									$('#playlist-logo-label').html('<i class="icon folder open"></i> ' + $('#playlist-logo').val().split('\\').pop());
								});
							</script>
						</div>
					</div>

					<div class="field">
						<label for="playlist-description">Playlist Description</label>

						<textarea id="playlist-description" name="playlist-description"></textarea>
					</div>
				</div>
			</div>
			<div class="actions-fixed">
				<button class="ui positive right labeled icon button" type="submit">
					<i class="checkmark icon"></i>

					Create
				</button>
			</div>
		</form>
		<script type="text/javascript">
			$('#modal-add')
				.form({

				},
				{
					onSuccess: function()
					{
//
						add_playlist();
					}
				})
			;
			function add_playlist(){
				var fd = new FormData();
				fd.append('ajax', '1');
				fd.append('action', 'add');
				fd.append('playlist-name', $('#playlist-name').val());
				fd.append('playlist-title', $('#playlist-title').val());
				fd.append('playlist-description', $('#playlist-description').val());
				fd.append('playlist-logo', $('#playlist-logo')[0].files[0]);
				$.ajax({
					type: 'POST',
					url:'index.php?page=user&task=playlists',
					data: fd,
					processData: false,
					contentType: false,
					success: function(data){

						$('#content').html(data);
						$('#modal-add').modal('hide');
					},
					error: function ()
					{
						console.log('fail!');
					}
				});
			}

		</script>

		<form id="modal-update" class="ui modal transition coupled" action="javascript:void(null)" method="post" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html" onsubmit="return rude.playlist.validate.update()">
			<i class="close icon"></i>
			<div class="header">
				Update My Playlist
			</div>
			<div class="content">
				<div class="ui form">

					<input type="hidden" name="action" value="update">

					<input type="hidden" id="playlist-update-id" name="playlist-update-id" value="">

					<div class="three fields">
						<div class="field">
							<label for="playlist-update-name">Playlist Name</label>

							<input id="playlist-update-name" name="playlist-update-name">
						</div>

						<div class="field">
							<label for="playlist-update-title">Playlist Title</label>

							<input id="playlist-update-title" name="playlist-update-title">
						</div>

						<div class="field">
							<label>Playlist cover</label>
							<label id="playlist-update-logo-label" for="playlist-update-logo" class="ui icon button basic"><i class="icon folder open"></i> Click and select the image</label>

							<input id="playlist-update-logo" name="playlist-update-logo" type="file" style="display: none;">

							<script>
								$('#playlist-update-logo').change(function()
								{
									$('#playlist-update-logo-label').html('<i class="icon folder open"></i> ' + $('#playlist-update-logo').val().split('\\').pop());
								});
							</script>
						</div>
					</div>

					<div class="field">
						<label for="playlist-update-description">Playlist Description</label>

						<textarea id="playlist-update-description" name="playlist-update-description"></textarea>
					</div>
				</div>
			</div>
			<div class="actions-fixed">
				<button class="ui positive right labeled icon button" type="submit">
					<i class="checkmark icon"></i>

					Update
				</button>
			</div>
		</form>

		<script type="text/javascript">
			$('#modal-update')
				.form({

				},
				{
					onSuccess: function()
					{
						edit_playlist();
					}
				})
			;
			function edit_playlist(){
				var fd = new FormData();
				fd.append('ajax', '1');
				fd.append('action', 'update');
				fd.append('playlist-update-id', $('#playlist-update-id').val());
				fd.append('playlist-update-name', $('#playlist-update-name').val());
				fd.append('playlist-update-title', $('#playlist-update-title').val());
				fd.append('playlist-update-description', $('#playlist-update-description').val());
				fd.append('playlist-update-logo', $('#playlist-update-logo')[0].files[0]);
				$.ajax({
					type: 'POST',
					url:'index.php?page=user&task=playlists',
					data: fd,
					processData: false,
					contentType: false,
					success: function(data){
						$('#content').html(data);
						$('#modal-update').modal('hide');
					},
					error: function ()
					{
						console.log('fail!');
					}
				});
			}

		</script>

		<div id="modal-error" class="ui small modal transition coupled">
			<i class="close icon"></i>
			<div class="header">
				Confirm Action
			</div>
			<div class="content">
				<div class="ui form">
					<p>Please fill the required fields.</p>
				</div>
			</div>
			<div class="actions-fixed">

				<button class="ui positive right labeled icon button" onclick="$('#modal-error').modal('hide')">
					<i class="checkmark icon"></i>

					OK
				</button>
			</div>
		</div>

		<script>
			$('.coupled.modal').modal({ allowMultiple: true });
		</script>

		<form id="modal-remove"  action="javascript:void(null)" class="ui small modal transition" method="post" xmlns="http://www.w3.org/1999/html">
			<i class="close icon"></i>
			<div class="header">
				Interrupted
			</div>
			<div class="content">
				<div class="ui form">
					<input type="hidden" name="action" value="remove">

					<input type="hidden" id="playlist-id" name="playlist-id" value="">

					<p>Are you REALLY sure that you want to delete this playlist?</p>
				</div>
			</div>
			<div class="actions-fixed">
				<div class="ui negative right labeled icon button" onclick="$('#modal-remove').modal('hide')">
					<i class="remove icon"></i>

					Calcel
				</div>

				<button class="ui positive right labeled icon button" type="submit">
					<i class="checkmark icon"></i>

					Do it
				</button>
			</div>
		</form>
		<script type="text/javascript">
			$('#modal-remove')
				.form({

				},
				{
					onSuccess: function()
					{
						delete_playlist();
					}
				})
			;
			function delete_playlist(){
				var fd = new FormData();
				fd.append('ajax', '1');
				fd.append('action', 'remove');
				fd.append('playlist-id', $('#playlist-id').val());
				$.ajax({
					type: 'POST',
					url:'index.php?page=user&task=playlists',
					data: fd,
					processData: false,
					contentType: false,
					success: function(data){
						$('#content').html(data);
						$('#modal-remove').modal('hide');
					},
					error: function ()
					{
						console.log('fail!');
					}
				});
			}

		</script>

		<div class="menu">
			<div class="ui grid">
				<div class="six wide column">
					<div class="ui button green labeled icon float-right" onclick="$('#modal-add').modal({ closable: false }).modal('show')">
						<i class="icon plus"></i>

						Add New Playlist
					</div>
				</div>
			</div>
		</div>

		<table class="ui table striped celled">
			<thead>
			<tr>
				<th class="center small">#</th>
				<th>Name</th>
				<th>Title</th>
				<th class="center small">Date Created</th>
				<th class="center small">Total songs</th>
				<th class="center small">Actions</th>
			</tr>
			</thead>

			<tbody>

			<?
			$playlists = user_playlists::get_by_user_id(current::user_id());

			if ($playlists)
			{
				foreach ($playlists as $playlist)
				{
					$playlist_items = user_playlist_items::get_by_playlist_id($playlist->id);

					?>
					<tr>
						<td class="center"><?= $playlist->id ?></td>
						<td><?= $playlist->name ?></td>
						<td><?= $playlist->title ?></td>
						<td><?= date::date('.', strtotime($playlist->timestamp)) ?></td>
						<td class="center"><?= count($playlist_items) ?></td>
						<td class="nowrap">

							<a class="inline-block teal" href="?page=user&task=playlists&task2=edit&playlist-id=<?= $playlist->id ?>">
								<i class="icon music popup init" onclick="$(this).parent().submit()" data-content="Edit songs in playlist"></i>
							</a>

							<i class="icon configure black popup init" onclick="$('#playlist-update-id').val(<?= $playlist->id ?>); $('#playlist-update-name').val('<?= static::escape_js($playlist->name) ?>'); $('#playlist-update-title').val('<?= static::escape_js($playlist->title) ?>'); $('#playlist-update-description').val('<?= static::escape_js($playlist->description) ?>'); $('#modal-update').modal({ closable: false }).modal('show');" data-content="Change playlist meta information"></i>

							<span class="inline-block" style="position: relative">
								<img style="display:none; position: absolute;max-width: 150px;right: 10px;top: 15px;padding: 3px;background-color: black;border-radius: 5px;" src="<?= url::host(true) ?>/src/img/playlist_covers/<?= $playlist->id ?>/<?= $playlist->file_image ?>">
								<i class="icon search popup blue init" data-content="Show cover" onmouseover="$(this).parent().find('img').show();" onmouseout="$(this).parent().find('img').hide();" ></i>
							</span>

							<?
							if ($playlist->id != 3 and $playlist->id != 4)
							{
								?><i class="icon remove red popup init" onclick="$('#playlist-id').val(<?= $playlist->id ?>); $('#modal-remove').modal('show');" data-content="Remove playlist"></i><?
							}
							?>
						</td>
					</tr>
				<?
				}
			}
			?>

			</tbody>
		</table>

		<script>
			$('.popup.init').popup({ on: 'hover' });
		</script>
	<?
	}

	public static function escape_js($string)
	{
		$string = string::replace($string, '\\', '\\\\');
		$string = string::replace($string, '"', "'");
		$string = string::replace($string, "'", "\'");
		$string = string::replace($string, PHP_EOL, '<br>');
		$string = string::replace($string, "\r", '');

		return $string;
	}
}
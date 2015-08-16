<?

namespace rude;

class page_admin_import
{
	public function init()
	{
		if (get('init'))
		{
			static::import();
		}

		?>
		<div id="main">
			<?
				$errors = static::errors();

				if ($errors)
				{
					?>
					<div class="ui icon message">
						<i class="icon warning sign"></i>
						<div class="content">
							<div class="header">
								Errors
							</div>

							<?
								foreach ($errors as $error)
								{
									?><p><?= $error ?></p><?
								}
							?>
						</div>
					</div>
					<?
				}
			?>

			<form id="import-songs" method="post">
				<input type="hidden" name="init" value="true">

				<div class="ui button orange icon labeled" onclick="$('#import-songs').submit()">
					<i class="icon save"></i> Import Songs
				</div>
			</form>

			<table class="ui table celled">
				<thead>
					<tr>
						<th class="center">#</th>
						<th>File</th>
						<th>Title</th>
						<th class="center">Artist</th>
						<th class="center">Genre</th>
						<th>Comment</th>
					</tr>
				</thead>

				<tbody>
					<?
						$files = static::search_files();

						if ($files)
						{
							foreach ($files as $index => $file)
							{
								$info = static::parse($file);

								?>
								<tr>
									<td class="center"><?= $index + 1 ?></td>
									<td><?= filesystem::file_basename($file) ?></td>
									<td><?= get('title', $info) ?></td>
									<td class="center"><?= get('artist', $info) ?></td>
									<td class="center"><?= get('genre', $info) ?></td>
									<td><?= (string) get('comment', $info) ?></td>
								</tr>
								<?
							}
						}
					?>
				</tbody>
			</table>
		</div>
		<?
	}

	public function import()
	{
		$files = static::search_files();

		if (!$files)
		{
			return true;
		}

		foreach ($files as $index => $file)
		{
			$info = static::parse($file);

			if (!get('comment', $info))
			{
				$info->comment = '';
			}


			$genre = song_genres::get_by_name($info->genre, true);

			if (!$genre)
			{
				return static::errors('File #' . $index . ' [' . $file . ']: genre "' . $info->genre . '" not found in the database.');
			}


			$author_id = song_authors::get_by_name($info->artist, true)->id;

			if (!$author_id)
			{
				$author_id = song_authors::add($info->artist);
			}


			$song_name = 'song_' . string::rand(13) . '.mp3';


			$file_size = filesystem::size($file);


			songs::add($info->title, $info->comment, $author_id, $genre->id, 0, $song_name, $file_size, null, 0);


			filesystem::move($file, RUDE_DIR_AUDIO . DIRECTORY_SEPARATOR . $song_name);
		}

		headers::refresh();

		return true;
	}

	public function errors($val = null)
	{
		if ($val === null)
		{
			$errors = session::get('errors');

			session::remove('errors');

			return $errors;
		}

		$errors = session::get('errors');
		$errors[] = $val;

		session::set('errors', $errors);

		return false;
	}

	public function search_files()
	{
		return filesystem::search_files(RUDE_DIR_IMPORT, 'mp3');
	}

	public function parse($file_path)
	{
		require_once RUDE_DIR_GETID3 . DIRECTORY_SEPARATOR . 'getid3.php';

		$getID3 = new \getID3;

		// analyze file and store returned data in $ThisFileInfo

		$ID3 = $getID3->analyze($file_path);


		if (isset($ID3['tags']['id3v2']))
		{
			$info = $ID3['tags']['id3v2'];
		}
		else if (isset($ID3['tags']['id3v1']))
		{
			$info = $ID3['tags']['id3v1'];
		}
		else
		{
			return null;
		}

		foreach ($info as $key => $val)
		{
			if (isset($val[0]))
			{
				$info[$key] = $val[0];
			}
		}

		return items::to_object($info);
	}
}
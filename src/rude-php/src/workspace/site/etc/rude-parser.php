<?

namespace rude;

class parser
{
	public static function init()
	{
		$__database = new database('localhost', 'root', 1234, 'afrohits_muziki');
		$__database->query('SELECT * FROM song ORDER BY id ASC');

		$songs = $__database->get_object_list();

//		debug($songs);

		$songs_total = count($songs);

		foreach ($songs as $song)
		{
			$obj = new song();

			$obj->id = $song->id;
			$obj->name = $song->name;
			$obj->description = $song->text;

			if (string::contains($obj->description, '<pre>&nbsp;</pre>'))
			{
				$obj->description = string::replace($obj->description, '<pre>&nbsp;</pre>', '');
			}

			if (string::starts_with($obj->description, '<pre>') and string::ends_with($obj->description, '</pre>'))
			{
				$obj->description = string::replace_first($obj->description, '<pre>', '');
				$obj->description = string::replace_last($obj->description, '</pre>', '');
			}

			$obj->author_id = 0;
			$obj->genre_id = 0;

			$author = song_authors::get_by_name($song->author, true);
			$genre = song_genres::get_by_name($song->genre, true);

			if ($author) { $obj->author_id = $author->id; }
			if ($genre)  { $obj->genre_id  = $genre->id;  }

			$obj->length = 0;
			$obj->file_audio = string::replace($song->url, 'musics/', '');
			$obj->file_audio_size = 0;
			$obj->file_image = string::replace($song->img, 'musics/cover/', '');
			$obj->file_image_size = 0;
			$obj->timestamp = $song->date;

			console::progress($obj->save(), $songs_total);
		}
	}
}
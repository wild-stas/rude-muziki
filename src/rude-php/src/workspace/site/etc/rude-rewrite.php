<?

namespace rude;

class rewrite
{
	public static function is_enabled()
	{
		return get('rewrite') == 'on';
	}

	public static function page()
	{
		$url = url::current(true, true);
		$url = trim($url, '/');
		$url = string::explode($url, '/');

		return items::first($url);
	}

	public static function query()
	{
		$url = url::current(true, true);
		$url = trim($url, '/');
		$url = string::read_after($url, '/');

		if (string::contains($url, '?'))
		{
			$url = string::read_until($url, '?');
		}

		if (string::contains($url, '&'))
		{
			$url = string::read_until($url, '&');
		}

		return $url;
	}

	public static function load()
	{

	}

	public static function update()
	{
		$database = database();
		$database->query(
		'
			SELECT
				songs.id,
				songs.name,

				song_authors.name AS author_name

			FROM
				songs

			LEFT JOIN
				song_authors ON song_authors.id = songs.author_id

			WHERE
				songs.alias IS NULL
		');


		$songs = $database->get_object_list();

		foreach ($songs as $song)
		{
			$song_author = static::format($song->author_name);
			$song_name   = static::format($song->name);

			$alias = $song_author . '-' . $song_name;

			while (songs::get_by_alias($alias))
			{
				$alias .= string::rand(1, '0123456789abcdefghijklmnopqrstuvwxyz');
			}

			$q = new query_update('songs');
			$q->update('alias', $alias);
			$q->where('id', $song->id);
			$q->query();
		}
	}

	public static function format($string)
	{
		$string = string::replace($string, ['/', '.', ',', '&', '?', ':', 'amp;', '#', '!'], '');
		$string = string::replace($string, ['_', ' '], '-');
		$string = string::replace($string, '--', '-');
		$string = string::to_lowercase($string);
		$string = char::first($string, 100);

		return $string;
	}
}
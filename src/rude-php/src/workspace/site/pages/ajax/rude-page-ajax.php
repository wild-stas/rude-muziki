<?

namespace rude;

class page_ajax
{
	public static function init()
	{
		switch (get('task'))
		{
			case 'rating':
				static::rating();
				break;

			case 'repaint_menu':
				site::menu();
				break;
			case 'lazy':

				$songs = page_homepage::get_songs(get('genre_id'), get('offset'), get('limit'));


				$database = database();
				$database->query('
					SELECT
						songs.*,

						song_authors.name AS author_name,
						song_genres.name  AS genre_name,

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
						1 = 1
					AND
						songs.genre_id = ' . (int) get('genre_id') . '

					ORDER BY
						songs.id DESC LIMIT ' . (int) get('offset') . ',' . (int) get('limit') . '
				');


				if (!$songs)
				{
					headers::not_found(); die;
				}


				page_homepage::html_songs($songs);

				break;

			case 'vk_login':
				$expire = get('expire');
				$mid = get('mid');
				$secret = get('secret');
				$sid = get('sid');
				$sig = get('sig');
				$secret_key = 'sG4dvFBbeHKkCC6QVki9';

			//	if (md5($expire.$mid.$secret.$sid.$secret_key)==$sig){

					if( users::is_exists_uid($mid)){
						site::auth_social('vk',$mid);
					}else
					{
						users::add('2',null,null,null,null,null,'vk',$mid);
						site::auth_social('vk',$mid);
					}
				//}
				break;
		}
	}

	public static function rating()
	{
		$value = get('value');

		$song_id = get('song_id');
		$user_id = current::user_id();

		if (!$song_id or !current::user_is_logged())
		{
			return;
		}


		$q = new query_select('ratings');
		$q->where('song_id', $song_id);
		$q->where('user_id', $user_id);
		$q->query();

		$rating = $q->get_object();

		if (!$rating)
		{
			ratings::add($user_id, $song_id, $value);
		}
		else
		{
			$q = new query_update('ratings');
			$q->update('value', $value);
			$q->where('song_id', $song_id);
			$q->where('user_id', $user_id);
			$q->query();
		}
	}
}
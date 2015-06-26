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
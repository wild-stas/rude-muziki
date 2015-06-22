<?
namespace rude;

class pagination
{	  
	public function __construct()
	{
		
	}


	public static function html($total_items, $current_page, $items_per_page, $max_buttons = 6, $param = 'p')
	{
		$total_pages =floor($total_items / $items_per_page);
		if ($total_pages <= $max_buttons)
		{
			$page_ids = null;

			for ($i = 1; $i <= $total_pages; $i++)
			{
				$page_ids[] = $i; # we can show all buttons on the current page
			}
		}
		else
		{
			$page_ids[] = 1;                  # let's show the first one navigation button on the page...
			$page_ids[] = $total_pages; # ...and same things with the last one

			if ($current_page != 0 and
				$current_page != $total_pages)
			{
				$page_ids[] = $current_page; # also we should show current page if it's not the first one or the last one
			}



			for ($i = 0; count($page_ids) <= $max_buttons - 2; $i++)
			{
				if ($current_page + $i < $total_pages)
				{
					$page_ids[] = $current_page + $i;
				}

				$page_ids = array_unique($page_ids);

				if (count($page_ids) > $max_buttons - 2)
				{
					break;
				}

				if ($current_page - $i > 0)
				{
					$page_ids[] = $current_page - $i;
				}

				$page_ids = array_unique($page_ids);
			}


			sort($page_ids); # 1 7 3 4 5 => 1 3 4 5 7


			$tmp_ids = null;

			foreach ($page_ids as $page_id)
			{
				if ($tmp_ids == null)
				{
					$tmp_ids[] = $page_id;
					continue;
				}

				if (end($tmp_ids) + 1 != $page_id)
				{
					$tmp_ids[] = '...';
					$tmp_ids[] = $page_id;
					continue;
				}

				$tmp_ids[] = $page_id;
			}

			$page_ids = $tmp_ids;
		}

		?>
		<div class="ui pagination menu">
			<a class="item<? if ($current_page < 2) { ?> disabled<? } ?>"<? if ($current_page > 1) { ?> href="?page=admin&task=song&num_page=<?=$current_page-1;?>"<? } ?>>
				<i class="left arrow icon"></i> Previous
			</a>

			<?
			foreach ($page_ids as $page_id)
			{
				if ($page_id == '...')
				{
					?><a class="item">...</a><?
				}
				else
				{
					$bold = false;

					if ($current_page == $page_id)           { $bold = true; }
					else if ($current_page < 2 and $page_id == 1) { $bold = true; }

					?><a class="item" href="?page=admin&task=song&num_page=<?=$page_id;?>"><? if ($bold) { ?><b><? } ?><?= $page_id ?><? if ($bold) { ?></b><? } ?></a><?
				}
			}
			?>

			<a class="item<? if ($current_page == $total_pages) { ?> disabled<? } ?>"<? if ($current_page < $total_pages) { ?> href="?page=admin&task=song&num_page=<?=$current_page+1;?>"<? } ?>>
				Next <i class="icon right arrow"></i>
			</a>
		</div>
	<?
	}
}
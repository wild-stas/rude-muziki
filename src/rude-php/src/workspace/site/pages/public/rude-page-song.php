<?

namespace rude;

class page_song
{
	public function __construct()
	{

	}

	public function init()
	{
		site::doctype();

		?>
		<html>

		<? site::head(true) ?>

		<body>
		<div id="container">

			<? site::logo() ?>

			<div id="page-song">

				<? site::menu() ?>

				<div id="content">
					<? static::main() ?>
				</div>
			</div>

			<? site::footer() ?>
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
			errors::add('Комментарий не должен быть пустым.');
		}

		if (!errors::get())
		{
			$comment_id = comments::add($this->service->id, current::user_id(), $message);

			if ($comment_id)
			{
				headers::refresh(url::current() . '#comment-' . $comment_id);
			}
			else
			{
				errors::add('При попытке добавления нового комментария в базу возникли неожиданные проблемы. Если вы видите это сообщение - пожалуйста, свяжитесь с владельцем сайта и сообщите ему об этом');
			}
		}
	}

	public function main()
	{
		?>
		<div id="main">
			<? static::comments() ?>
		</div>
		<?
	}

	public function info()
	{
		?>
		<div class="ui segment">

			<div class="ui grid">
				<div class="eight wide column">
					<h2 class="ui header"><?= html::escape($this->service->name) ?></h2>
				</div>

				<div class="eight wide column right">

					<?
						if ($this->service->user_id == current::user_id())
						{
							?>
							<a href="<?= site::url('company', 'service') ?>&id=<?= $this->service->id ?>">
								<button class="ui button orange tiny icon">
									<i class="icon edit"></i> Редактировать
								</button>
							</a>
							<?
						}
					?>

					<a href="<?= site::url('homepage') ?>&user_id=<?= $this->service->user_id ?>">
						<button class="ui button blue tiny icon">
							<i class="icon unhide"></i> Все сервисы данной компании
						</button>
					</a>
				</div>
			</div>


			<div class="ui grid">
				<div class="eight wide column">

					<?
						if ($this->service->logo)
						{
							?><img class="ui bordered image" src="<?= filesystem::combine(RUDE_SITE_URL, 'src', 'img', 'companies', $this->service->user_id, 'services', $this->service->id, $this->service->logo) ?>"><?
						}
					?>


					<h4 class="ui header dividing">Адрес</h4>

					<p><?= html::escape($this->service->address) ?></p>

					<div class="ui header"></div>

					<div class="phones">
						<?
							if ($this->service_phones)
							{
								?><h4 class="ui header dividing">Телефоны</h4><?

								foreach ($this->service_phones as $service_phone)
								{
									?><p><?= html::escape($service_phone->phone) ?></p><?
								}
							}
						?>
					</div>

					<?
						if (!$this->service->logo)
						{
							?>
							<h4 class="ui header dividing">Описание сервиса</h4>

							<p><?= html::escape($this->service->description) ?></p>
							<?
						}
					?>
				</div>

				<div class="eight wide column">
					<h4 class="ui header dividing">График работы</h4>

					<table class="ui table striped small very basic celled">
						<thead>
							<tr>
								<th class="center">День</th>
								<th class="center">Рабочее время</th>
								<th class="center">Перерыв</th>
							</tr>
						</thead>

						<tbody>
							<?
								foreach ($this->timetable_items as $timetable_item)
								{
									if ($timetable_item->is_day_off)
									{
										?>
										<tr>
											<td class="center"><?= $timetable_item->timetable_day_name ?></td>
											<td class="center"><i class="icon minus"></i></td>
											<td class="center"><i class="icon minus"></i></td>
										</tr>
										<?

										continue;
									}

									?>
									<tr>
										<td class="center"><?= $timetable_item->timetable_day_name ?></td>
										<td class="center"><?= date('H:i', strtotime($timetable_item->working_begin)) ?> - <?= date('H:i', strtotime($timetable_item->working_end)) ?></td>
										<td class="center">
											<?
												if (!$timetable_item->lanch_begin or !$timetable_item->lanch_end or ($timetable_item->lanch_begin == $timetable_item->lanch_end))
												{
													?><i class="icon minus"></i><?
												}
												else
												{
													echo date('H:i', strtotime($timetable_item->lanch_begin)) . ' - ' . date('H:i', strtotime($timetable_item->lanch_end));
												}
											?>
										</td>
									</tr>
									<?
								}
							?>
						</tbody>
					</table>


					<?
						if ($this->service->logo)
						{
							?>
							<h4 class="ui header dividing">Описание сервиса</h4>

							<p><?= html::escape($this->service->description) ?></p>
							<?
						}
					?>
				</div>
			</div>
		</div>
		<?
	}

	public function timetable()
	{
		if ($this->service->user_id == current::user_id())
		{
			?>
			<div id="information" class="ui segment secondary red">
				<div class="ui grid">
					<div class="sixteen wide column">
						<p>Обращаем ваше внимание на то, что вы авторизованы как владелец данного сервиса. Это значит, что вы можете бронировать время сервиса собственноручно. Это также значит, что нажатие вами на зелёные метки времени приведёт к оформлению пустого заказа, что не позволит другим пользователям бронировать выбранное вами время.</p>

						<p>Убрать эти заказы, также как и все подобные заявки бронирования времени, можно в <a href="<?= site::url('company', 'orders') ?>">панели управления заказами</a>.</p>
					</div>
				</div>
			</div>
			<?
		}
		?>

		<div class="ui small modal transition service-order-message">
			<i class="close icon"></i>
			<div class="header">
				Системное сообщение
			</div>
			<div class="content">
				<p></p>
			</div>
			<div class="actions">
				<div class="ui positive right icon button">
					ОК
				</div>
			</div>
		</div>

		<div id="timetable" class="ui segment">

			<input type="hidden" id="page-service-order" value="<?= site::url('service-order') ?>">

			<div class="buttons">
				<div id="service-pickadate" class="ui button blue labeled icon"><i class="icon calendar"></i> <?= $this->date_selected ?></div>
			</div>

			<div class="ui divider"></div>

			<div class="jobs">
			<?
				if ($this->service->user_id != current::user_id())
				{
					foreach ($this->service_jobs as $service_job)
					{
						$length = $this->timetable->interval * $service_job->multiplier;

						?>
						<div class="field">
							<div class="ui checkbox">
								<input type="checkbox" data-id="<?= (int) $service_job->id ?>" data-multiplier="<?= (int) $service_job->multiplier ?>" onchange="rude.service.timetable.refresh()">
								<label><?= $service_job->name ?> (<?= $length ?> мин)</label>
							</div>
						</div>
						<?
					}

					?><div class="ui divider"></div><?
				}
			?>
			</div>


			<div class="items">
				<div class="ui inverted dimmer">
					<div class="ui text loader">Загрузка</div>
				</div>

				<div class="content">
					<? page_ajax::timetable_items($this->service->id, $this->date_selected) ?>
				</div>
			</div>

		</div>

		<script>
			rude.semantic.init.checkbox();


			var date = new Date();

			$('#service-pickadate').pickadate(
			{
				min: date,

				onClose: function()
				{
					rude.url.param.add('date', $('#timetable .buttons input').val())
				}
			});
		</script>
		<?
	}

	public static function is_time_ordered($orders, $required_from, $required_length = 0, $service_time_end)
	{
		######################
		# B > E     => true  #
		# B > D     => true  #
		# C < B < D => true  #
		# A < D < B => true  #
		#                    #
		# other     => false #
		######################

		$order_required_from = strtotime($required_from);                            # A
		$order_required_to   = $order_required_from + ($required_length * 60) - 0.1; # B
		$order_required_max  = strtotime('24:00');                                   # E
		$service_time_end    = strtotime($service_time_end);                         # D

		if (($order_required_to > $order_required_max) or # B > E => true
			($order_required_to > $service_time_end))     # B > D => true
		{
			return true;
		}

		foreach ($orders as $order)
		{
			$order_from = strtotime($order->time_from) + 0.1; # C
			$order_to   = strtotime($order->time_to);         # D

			if (($order_from < $order_required_to and $order_required_to < $order_to) or # C < B < D => true
				($order_required_from < $order_to and $order_to < $order_required_to))   # A < D < B => true
			{
				return true;
			}
		}

		return false;
	}

	public function map()
	{
		?>
		<div id="map" class="ui segment"></div>

		<script type="text/javascript">
			// Создавать карту следует после того, как веб-страница загрузится целиком. Это
			// даст уверенность в том, что контейнер для карты создан и к нему можно обраща
			// ться по id. Чтобы инициализировать карту после загрузки страницы, можно восп
			// ользоваться функцией ready().

			ymaps.ready(init);

			function init()
			{
				rude.yandex.map.settings.zoom = 18;
				rude.yandex.map.settings.center = [<?= $this->service->latitude ?>, <?= $this->service->longitude ?>];

				rude.yandex.map.init();
				rude.yandex.map.add.mark(<?= $this->service->latitude ?>, <?= $this->service->longitude ?>);
			}
		</script>
		<?
	}

	public function comments()
	{
		if (!$this->comments and !current::user_is_logged())
		{
			return;
		}


		?>
		<div class="ui comments segment">
		<?
			if ($this->comments)
			{
				foreach ($this->comments as $comment)
				{
					?>
					<div class="comment">
						<a class="avatar">
							<img src="<?= RUDE_SITE_URL ?>src/img/avatar.png">
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
								<a class="reply" onclick="$('#message').val($(this).parent().parent().find('.author').html() + ', ').focus();">Ответить</a>
							</div>
						</div>
					</div>
					<?
				}
			}
			else
			{
				?>В данный момент нету ни одного комментария к данному сервису. Вы можете оставить первый.<?
			}

			if (current::user_is_logged())
			{
				?>
					<form class="ui reply error form" method="post">

						<? site::error('При попытке добавления нового комментария возникли некоторые сложности:') ?>

						<input type="hidden" name="action" value="comment-add">

						<div class="field">
							<textarea id="message" name="message" placeholder="Оставьте свой комментарий"><?= get('message') ?></textarea>
						</div>
						<button type="submit" class="ui primary submit labeled icon button">
							<i class="icon edit"></i> Оставить комментарий
						</button>
					</form>
				<?
			}
		?>
		</div>
		<?
	}
}
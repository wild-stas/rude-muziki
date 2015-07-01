<?

namespace rude;

class page_user_dashboard
{	

	public function __construct()
	{
		
	}

	public function init()
	{
		?>
		<script>
			rude.crawler.init();
		</script>
		<div id="dashboard" class="ui grid">
			<div class="four wide column">
				<h4 class="ui header dividing">Сводная информация</h4>

				<table class="ui small table celled striped">
					<thead>
						<tr>
							<th>Наименование</th>
							<th class="width-5">Количество</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td><a href="<?= site::url('company', 'services') ?>">Сервисов</a></td>
							<td class="bold center"><?= count($this->services) ?></td>
						</tr>
						<tr>
							<td><a href="<?= site::url('company', 'orders') ?>">Заказов</a></td>
							<td class="bold center"><?= count($this->orders) ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="four wide column"></div>

			<div class="four wide column"></div>
		</div>
		<?
	}
}
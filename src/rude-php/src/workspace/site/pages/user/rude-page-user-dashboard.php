<?

namespace rude;

class page_user_dashboard
{
	private $services = null;
	private $orders = null;

	public function __construct()
	{
		$this->services = services::get_by_user_id(current::user_id());

		if ($this->services)
		{
			$service_ids = [];

			foreach ($this->services as $service)
			{
				$service_ids[] = $service->id;
			}

			$this->orders = orders::get_by_service_id($service_ids);
		}
	}

	public function init()
	{
		?>
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
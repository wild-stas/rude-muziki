<?

namespace rude;

class page_admin_dashboard
{
	public static function init()
	{
		?>
		<div id="dashboard" class="ui grid">
			<div class="eight wide column">
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
							<td><a href="<?= site::url('admin', 'users') ?>">Пользователей</a></td>
							<td class="bold center"><?= users::count() ?></td>
						</tr>
						<tr>
							<td><a href="<?= site::url('admin', 'users') ?>">Компаний</a></td>
							<td class="bold center"><?= count(users::get_by_role_id(RUDE_ROLE_COMPANY)) ?></td>
						</tr>
						<tr>
							<td><a href="<?= site::url('admin', 'services') ?>">Услуг</a></td>
							<td class="bold center"><?= services::count() ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="eight wide column">
				<h4 class="ui header dividing">Новые пользователи</h4>

				<table class="ui small table celled striped">
					<thead>
					<tr>
						<th>Имя</th>
						<th class="center">Роль</th>
						<th class="center">Регистрация</th>
					</tr>
					</thead>

					<tbody>
					<?
						$users = users::get_last(3);

						$user_roles = users_roles::get();


						if ($users)
						{
							foreach ($users as $user)
							{
								?>
								<tr>
									<td><?= $user->name ?></td>
									<td class="center">
									<?
										foreach ($user_roles as $user_role)
										{
											if ($user->role_id == $user_role->id)
											{
												echo $user_role->name; break;
											}
										}
									?>
									</td>
									<td class="center"><?= $user->registered ?></td>
								</tr>
								<?
							}
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<?
	}


}
<?

namespace rude;

class page_admin_users
{
	private $users = null;
	private $user_roles = null;

	public function __construct()
	{
		$database = database();

		$database->query('
		SELECT
			users.*,
			users_roles.name as role_name
		FROM
			users
		LEFT JOIN
			users_roles ON users.role_id = users_roles.id
		WHERE
			1 = 1
		');


		$this->users = $database->get_object_list();
	}

	public function init()
	{
		?>
		<table class="ui table celled striped">
			<thead>
				<tr>
					<th class="center width-3">#</th>
					<th class="width-10">Роль</th>
					<th>Имя</th>
					<th>E-mail</th>
					<th class="center width-20">Дата регистрации</th>
				</tr>
			</thead>

			<tbody>
				<?
					if ($this->users)
					{
						foreach ($this->users as $user)
						{
							?>
							<tr class="<?= site::highlight_time($user->registered) ?>">
								<td class="center"><?= $user->id ?></td>
								<td><?= $user->role_name ?></td>
								<td><?= $user->name ?></td>
								<td><?= $user->email ?></td>
								<td class="center"><?= $user->registered ?></td>
							</tr>
							<?
						}
					}
				?>
			</tbody>
		</table>
		<?
	}
}
<?

namespace rude;

class page_admin_settings
{
	private $settings = null;

	public function __construct()
	{
		static::validate();

		$this->settings = settings::get();
	}

	public function init()
	{
		if (!$this->settings)
		{
			return;
		}

		?>
		<form class="ui form error" method="post">

			<? site::error('Во время сохранения настроек окружения возникли следующие ошибки:') ?>

			<input type="hidden" name="action" value="save">

			<?
				foreach ($this->settings as $setting)
				{
					?>
					<div class="field">
						<label for="<?= $setting->key ?>"><?= $setting->description ?>:</label>

						<input id="<?= $setting->key ?>" name="<?= $setting->key ?>" value="<?= $setting->val ?>">
					</div>
					<?
				}
			?>

			<button type="submit" class="ui button green">Сохранить</button>
		</form>
		<?
	}

	public function validate()
	{
		if (get('action') != 'save' or !$this->settings)
		{
			return;
		}

		foreach ($this->settings as $setting)
		{
			$val = get($setting->key);

			if ($setting->val != $val)
			{
				if (!settings::update($setting->id, null, $val))
				{
					errors::add('Не удалось сохранить настройки для переменной ' . $setting->key . '.');
				}
			}
		}
	}
}
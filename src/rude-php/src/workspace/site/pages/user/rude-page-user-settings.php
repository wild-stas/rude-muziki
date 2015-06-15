<?

namespace rude;

class page_company_settings
{
	public static function init()
	{
		?>
		<div id="service">
			<form method="post" class="ui form">

				<h4 class="ui header dividing">Настройки компании</h4>

				<div class="two fields">
					<div class="field">
						<label for="service-name">Наименование организации</label>
						<input id="service-name" name="company[name]" placeholder="ЗАО «Рога и Копыта»">
					</div>

					<div class="field">
						<label for="service-address">Адрес организации</label>
						<input id="service-address" name="company[address]" placeholder="Россия, г. Иваново, ул. Партизанская, д. 16">
					</div>
				</div>


				<h4 class="ui header dividing">Географические координаты</h4>

				<div class="two fields">
					<div class="field latitude" data-content="Данное поле для заполнения не обязательно. Вместо этого, вы можете указать «Адрес организации» в соответствующем месте. При корректном заполнении координаты будут вычислены автоматически.">
						<label>Широта</label>
						<input name="company[latitude]" placeholder="55.755831">
					</div>

					<div class="field longitude" data-content="Данное поле для заполнения не обязательно. Вместо этого, вы можете указать «Адрес организации» в соответствующем месте. При корректном заполнении координаты будут вычислены автоматически.">
						<label>Долгота</label>
						<input name="company[longitude]" placeholder="37.617673">
					</div>
				</div>

				<script>
					$('.field.latitude').popup();
					$('.field.longitude').popup();
				</script>


				<div class="field">
					<label for="service-phone">Телефоны компании (по одному на каждой строке)</label>
					<textarea id="service-phone" name="company[phones]" placeholder="<?= '+7(920)3736291' . PHP_EOL . '+7(920)3736292' . PHP_EOL . '+7(920)3736293' ?>"></textarea>
				</div>
			</form>

			<script>
				rude.semantic.init.dropdown();
				rude.semantic.init.checkbox();
			</script>
		</div>
		<?
	}
}
<?

namespace rude;

class page_about
{
	public static function init($title = 'О нас')
	{
		if (get('ajax')=='1'){
			static::main();

			return;
		}

		site::doctype();

		?>
			<html>

			<? site::head($title) ?>

			<body>
				<div id="container">

					<? site::header($title) ?>

					<div id="page-about">
						<? site::menu() ?>

						<div id="content">
							<? static::main() ?>
						</div>
					</div>

					<? site::footer() ?>

					<? site::player() ?>
				</div>
			</body>
		</html>
		<?
	}

	public static function main()
	{
		?>
		<div id="main" class="ui segment">
			<h4 class="ui header dividing">About Muziki.Net</h4>

			<p>Muziki.Net enables people to find, listen to and enjoy the music any time they want.</p>

			<p>Muziki.Net provides listeners access to stream over 10 0000 songs from across East Africa and other parts of Africa for FREE.</p>

			<p>Muziki.Net Office</p>

			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15846.457236239794!2d39.2913875!3d-6.8166764!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2e0d589446864c07!2sMuziki.Net!5e0!3m2!1sru!2sby!4v1448496266350" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		<div id="homefooter" class="ui menu visible">

			<div class="item" onclick=" rude.menu.navigation.hide();">
				<a href="<?= site::url('about') ?>">
					About
				</a>
			</div>

			<div class="item" onclick="rude.menu.navigation.hide();">
				<a href="<?= site::url('help') ?>">
					Help and Contacts
				</a>
			</div>

			<div class="item" onclick=" rude.menu.navigation.hide();">
				<a href="<?= site::url('terms') ?>">
					Terms & Conditions
				</a>
			</div>



			<div class="item" onclick="rude.menu.navigation.hide();">
				<a class="footersocial" href="http://www.facebook.com/Muziki.net" title="We're on Facebook" target="_blank">Facebook</a>
			</div>

			<div class="item" onclick="rude.menu.navigation.hide();">
				<a class="footersocial" href="http://www.twitter.com/MuzikiNet" title="We're on Twitter" target="_blank">Twitter</a>
			</div>

			<div class="item" onclick=" rude.menu.navigation.hide();">
				<a class="footersocial" href="http://www.google.com/+MuzikiNet" title="We're on Google+" target="_blank">Google+</a>
			</div>

		</div>
		<?
	}
}
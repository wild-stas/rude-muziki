<?

namespace rude;

class page_help
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
			<h4 class="ui header dividing">Help and Contacts</h4>

			<p>
			</p><div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">
						<p>Know the cost of using Muziki.Net</p>
					</h5>
				</div>
				<div id="collapse-0" class="panel-collapse in" style="height: auto;">
					<div class="panel-body"><p></p>
						<p>Muziki.Net costs you almost nothing. Only charges from your ISP (internet service provider)</p>
						<p>
						</p></div>
				</div>
			</div><p></p>
			<p>
			</p><div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">
						<p>Listen to music</p>
					</h5>
				</div>
				<div id="collapse-1" class="panel-collapse in" style="height: auto;">
					<div class="panel-body"><p></p>
						<p>To listen to a specific song, just hover on a song and a play button will appear right on top of song artwork (see the image below). Click that “Play Button” and you are set.</p>
						<p>
						</p></div>
				</div>
			</div><p></p>
			<p>
			</p><div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">
						<p>Add to playlist</p>
					</h5>
				</div>
				<div id="collapse-2" class="panel-collapse in" style="height: auto;">
					<div class="panel-body"><p></p>
						<p>To add a specific song to your playlist, just hover on a song and an “Add button” will appear on the far right corner of the music details row (see the image below). Click that “Add Button” and your favorite song is added.</p>
						<p>If the song is already on your favorite list a message like this one below will show up.</p>
						<p>To know how many songs are on your playlist/favorite list just look here.</p>
						<p>
						</p></div>
				</div>
			</div><p></p>
			<p>
			</p><div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">
						<p>Share a song to social media</p>
					</h5>
				</div>
				<div id="collapse-3" class="panel-collapse collapse">
					<div class="panel-body"><p></p>
						<p>Sharing a song from Muziki.Net is so easy. After clicking on the “Share Button” here (image) or here (image), choose from the available options: Facebook, Twitter or Google + to share your song.</p>
						<p>
						</p></div>
				</div>
			</div><p></p>
			<p>
			</p><div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">
						<p>Search for a song</p>
					</h5>
				</div>
				<div id="collapse-4" class="panel-collapse collapse">
					<div class="panel-body"><p></p>
						<p>From the search form on top of the website, just type artist name, song name or any combination of latters you remember about the song and our magic algorithm will do the rest. From the search results you can: Play, Add and Share your favorite song or add all songs to playlist.</p>
						<p>
						</p></div>
				</div>
			</div><p></p>
			<p>
			</p><div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">
						<p>Listen to music from my playlist</p>
					</h5>
				</div>
				<div id="collapse-5" class="panel-collapse collapse">
					<div class="panel-body"><p></p>
						<p>By clicking here (image) you will jump straight to you playlist where you can listen to the songs you like in an ordered form. You can even shuffle them by clicking here (image).</p>
						<p>
						</p></div>
				</div>
			</div><p></p>
			<p>
			</p><div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">
						<p>Read song’s lyrics</p>
					</h5>
				</div>
				<div id="collapse-6" class="panel-collapse collapse">
					<div class="panel-body"><p></p>
						<p>Muziki.Net provides you the ability to read lyrics of songs you love. From the music list, click on the Artist’s name or Song title and you will be taken to the lyrics page.</p>
						<p>
						</p></div>
				</div>
			</div><p></p>
			<p>
			</p><div class="panel panel-default">
				<div class="panel-heading">
					<h5 class="panel-title">
						<p>Contact Muziki.Net for further information</p>
					</h5>
				</div>
				<div id="collapse-7" class="panel-collapse collapse">
					<div class="panel-body"><p></p>
						<p>We are always available to help on anything concerning our website and music industry.</p>
						<p>
						</p></div>
				</div>
			</div><p></p>
			<h3>Feedback</h3>
			<p>We value your comments about our website. Please let us know what you think so that we can continue to improve it. &nbsp;info@muziki.net.</p>

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
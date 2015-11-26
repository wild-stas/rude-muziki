<?

namespace rude;

class page_terms
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
			<h4 class="ui header dividing">Muziki.Net Terms and Conditions of Service</h4>


			<p>Welcome to Muziki.net your home of African music and specifically the East African Music under all categories. We hope you will enjoy your visit in this website because that is our solely primary target.</p>
			<p>By using this website it automatically means you agree to our terms of service, so we advise you to carefully read these terms as they will mean an important part of your agreement with us as you use our services.</p>
			<p>Note that our terms may be subjected to periodic changes as we flexibly move to cover your needs whenever we see any necessity, and any additional term will move to that auto agreement between Muziki.net and our visitors hence a part of the general terms of services.</p>
			<h4>Using our services</h4>
			<p>Tempering or misuse of our services is completely unacceptable. Once you are in our website, we have provided you with an interface of which we believe is enough to access all that is available for you as our esteemed visitor. Trying to interfere with our services or accessing them using an interface or instructions that aren’t provided by our team is illegal and may result into legal proceedings or blocking you from further access of our services.</p>
			<p>Being allowed to use our services doesn’t give you ownership of any intellectual property rights in our Services or the content you access. Either you are not allowed to misuse, remove or alter any branding or logo found in our website, the use of these additional third part brandings must be requested prior by contacting Muziki.net team of which there is no guarantee that permission will be granted, remember these things are guided by ownership/copyright laws.</p>
			<p>Our Services will soon be available on mobile devices though our Muziki.net App, currently you can just access them with a mobile equipment with capability to load our website contents. Please be careful when using our services through your mobile equipment, do not use the services in a way that distracts you and prevents you from obeying traffic or safety laws.</p>
			<h4>Content sharing and business use of our services.</h4>
			<p>It is strictly prohibited to use any content of our website for business purpose without permission from Muziki.net administration. Violation of this clause will result into monetary compensation with reference to how the contents have been used in a particular business base and in accordance with the copyright laws. Non business sharing of contents of this site is allowed be it on social networks or through other feasible means. We have provided you with the links towards the social media network of your interest whenever you want to share our services with your friends. We consider that more than enough.</p>
			<h4>Software requirements in our services</h4>
			<p>We do not have specifically recommended software or media on accessing our services but any software/media that allows you to play an audio music online is acceptable. Either we do not interfere with the rights of the owners of those soft wares or media. That means you will need to have an independent compliance with the owners of that particular software you are using. In anyway Muziki.net is not responsible with any complications that may arise between the service user and the owner of that particular media used in accessing our services.&nbsp; &nbsp; &nbsp;&nbsp;</p>
			<h4>Modification and Termination of Services</h4>
			<p>As you will always observe, we are constantly changing and improving our services. Thus we may add or remove functionalities or features as well as suspend or stop a service altogether. Muziki.net may also stop providing Services to you, or add or create new limits to our Services at any time. We as owners of the services you access, we are entitled to giving you a reasonable advance notice in case we are to discontinue serving you. Just know that you can stop using our Services at any time, although we’ll be sorry to see you go. Don’t forget that we’ll always welcome you back whenever you wish.</p>
			<h4>Changes in Terms and Conditions of service.</h4>
			<p>These terms and any additional terms that apply to a service are subjected to modifications; It may reflect changes to the law or changes to our services. You should be reading these terms regularly. We’ll be posting notice of modifications to these terms on this page. Changes will not apply retroactively and will become effective no sooner than two weeks after they are posted. However, changes addressing new functions for a Service or changes made for legal reasons will be effective immediately. If you do not agree to the modified terms for a service, you should discontinue your use of the Muziki.net site.</p>
			<p>Remember that the additional terms always controls the existing terms, so in case of any conflicting interpretation, the additional terms will overweigh the old terms.</p>
			<p>The mostly important thing is for you to know that these terms controls the relationship between Muziki.net and you whenever you are visiting the site. They do not associate any third party beneficiary rights.</p>
			<p>If it happens that you violate these terms, and no actions are applied right away, it doesn’t mean that we are giving up any rights that we may have regarding any possible actions that may have been taken. You can still face actions in future.</p>
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
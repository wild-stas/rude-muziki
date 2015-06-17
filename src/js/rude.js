var rude =
{
	array:
	{
		unique: function(array)
		{
			function _unique(value, index, self)
			{
				return self.indexOf(value) === index;
			}

			return array.filter(_unique);
		}
	},

	string:
	{
		starts_with: function(string, substring)
		{
			return string.indexOf(substring) === 0;
		}
	},

	semantic:
	{
		init:
		{
			dropdown: function()
			{
				$(function() {
					$('.ui.dropdown').dropdown();
				});
			},

			checkbox: function()
			{
				$(function() {
					$('.ui.checkbox').checkbox();
				});
			},

			rating: function()
			{
				$(function() {
					$('.ui.rating').rating();
				});
			}
		}
	},

	player:
	{
		manager: null,

		settings:
		{
			directory:
			{
				audio: 'src/audio/'
			},

			selector:
			{
				slider:
				{
					volume: '#player .volume.slider .container',
					song:   '#player .song.slider   .container'
				}
			}
		},

		init: function()
		{
			$(function()
			{
				rude.player.manager = soundManager;
				rude.player.manager.debugMode = true;
//				rude.player.manager.consoleOnly = false;

//				soundManager.url = '../sound-manager/2.97a/swf/soundmanager2.swf';


//				rude.player.manager.setup
//				({
//					defaultOptions:
//					{
//						volume: 33 // set global default volume for all sound objects
//					}
//				});
//
//				rude.player.manager = function()
//				{
////					rude.player.song.add('1', '', '', 'song_555f988e709c7.mp3');
//
////					rude.player.manager.play('1');
////					rude.player.manager.setVolume('1', 50);
////					rude.player.manager.setPan('1', -100);
//
//
//				};

				rude.player.slider.song.init();
				rude.player.slider.volume.init();
			});
		},

		slider:
		{
			song:
			{
				init: function()
				{
					$(rude.player.settings.selector.slider.song).slider
					({
						min: 0,
						max: 100,

						change: function()
						{
							rude.player.slider.song.update();
						}
					});

//					rude.player.slider.volume.enable();
				},

				update: function()
				{
					var value = rude.player.slider.song.value();

				},

				disable: function() { $(rude.player.settings.selector.slider.song).slider('disable'); },
				enable:  function() { $(rude.player.settings.selector.slider.song).slider('enable');  },

				value: function(value)
				{
					if (typeof value === 'undefined')
					{
						return $(rude.player.settings.selector.slider.song).slider('option', 'value');
					}

					return $(rude.player.settings.selector.slider.song).slider('option', 'value', value);
				}
			},

			volume:
			{
				init: function()
				{
					$(rude.player.settings.selector.slider.volume).slider
					({
						min: 0,
						max: 100,

						change: function()
						{
							rude.player.slider.volume.update();
						}
					});

//					rude.player.slider.volume.enable();
				},

				update: function()
				{
					var value = rude.player.slider.volume.value();

					var selector = $(rude.player.settings.selector.slider.volume).parent().find('.icon.volume');

					selector.removeClass('up').removeClass('down').removeClass('off');

					     if (value == 0) { $(selector).addClass('off');  }
					else if (value < 30) { $(selector).addClass('down'); }
					else                 { $(selector).addClass('up');   }

					selector.parent().find('.value').html(value + '%');

				},

				toggle: function()
				{
					var value = rude.player.slider.volume.value();

					var selector = $(rude.player.settings.selector.slider.volume).parent().find('.icon.volume');

					if (value != 0)
					{
						selector.attr('data-value', value);

						rude.player.slider.volume.value(0);
					}
					else
					{
						var loaded = selector.attr('data-value');

						if (!loaded)
						{
							loaded = 100;
						}

						rude.player.slider.volume.value(loaded);
					}

					rude.player.slider.volume.update();
				},

				disable: function() { $(rude.player.settings.selector.slider.volume).slider('disable'); },
				enable:  function() { $(rude.player.settings.selector.slider.volume).slider('enable');  },

				value: function(value)
				{
					if (typeof value === 'undefined')
					{
						return $(rude.player.settings.selector.slider.volume).slider('option', 'value');
					}

					return $(rude.player.settings.selector.slider.volume).slider('option', 'value', value);
				}
			}
		},

		song:
		{
			add: function(id, name, author, file)
			{
				rude.player.manager.createSound
				({
					id: id,

					url: rude.player.settings.directory.audio + file,

					autoLoad: true,

					onfinish: function()
					{

						console.log('playing finished');
					}
				});
			}
		}
	},

	base64:
	{
		decode: function(s)
		{
			var e={},i, b = 0, c, x, l = 0, a, r = '', w = String.fromCharCode, L = s.length;

			var A = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

			for (i = 0; i < 64; i++)
			{
				e[A.charAt(i)] = i;
			}

			for (x = 0; x < L; x++)
			{
				c = e[s.charAt(x)];
				b = (b << 6) + c;
				l += 6;

				while (l >= 8)
				{
					((a = (b >>> (l -= 8)) & 0xff) || (x < (L - 2))) && (r += w(a));
				}
			}

			return r;
		}
	},

	url:
	{
		parse: function(url)
		{
			var parser = document.createElement('a');

			parser.href = url;

			return parser; // http://example.com:3000/pathname/?search=test#hash
			               //
			               // parser.protocol => "http:"
			               // parser.host     => "example.com:3000"
			               // parser.hostname => "example.com"
			               // parser.port     => "3000"
			               // parser.pathname => "/pathname/"
			               // parser.hash     => "#hash"
			               // parser.search   => "?search=test"
		},

		reload: function()
		{
			location.reload();
		},

		redirect: function(url)
		{
			window.location.replace(url);
		},

		host: function()
		{
			return window.location.host;
		},

		param:
		{
			add: function(key, value)
			{
				key   = encodeURIComponent(key);
				value = encodeURIComponent(value);

				var kvp = document.location.search.substr(1).split('&');

				if (kvp == '')
				{
					document.location.search = '?' + key + '=' + value;
				}
				else
				{
					var i = kvp.length;
					var x;

					while (i--)
					{
						x = kvp[i].split('=');

						if (x[0] == key)
						{
							x[1] = value;
							kvp[i] = x.join('=');

							break;
						}
					}

					if (i < 0) { kvp[kvp.length] = [key, value].join('='); }

					// this will reload the page, it's likely better to store this until finished

					document.location.search = kvp.join('&');
				}
			}
		}
	},

	crawler:
	{
		init: function ()
		{
			$(function()
			{
				$('a').click(function ()
				{
					var url = $(this).attr('href');

					if (rude.string.starts_with(url, 'http'))
					{
						var parts = rude.url.parse(url);

						url = parts.search;
					}

					$.ajax
					({
						url: 'index.php' + url,

						type: 'GET',

						data: { ajax: 1 },

						success: function (data)
						{
							$('#content').html(data);

							console.log('success!');
						}
					});


					if (url != window.location) // change current url
					{
						window.history.pushState(null, null, url);
					}

					return false; // ignore default event
				});
			});
		}
	}
};
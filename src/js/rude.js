function debug(variable)
{
	console.log(variable);
}

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
				buttons:
				{
					play: '#player-button-play',
					stop: '#player-button-stop'
				},

				slider:
				{
					volume:       '#player .volume.slider .container',
					volume_icon:  '#player-volume-icon',
					volume_level: '#player-volume-level',
					song:         '#player .song.slider   .container',
					song_title:   '#player-song-title',
					song_length:  '#player-song-length',
					song_current: '#player-song-current'
				}
			}
		},

		init: function()
		{
			$(function()
			{
				rude.player.manager = soundManager;
				rude.player.manager.debugMode = true;

				rude.player.slider.song.init();
				rude.player.slider.volume.init();
			});
		},

		playlist:
		{
			database: [],

			add: function()
			{

			}
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

						range: 'min',

						change: function(event, ui) { rude.player.slider.song.update();         },
						slide:  function(event, ui) { rude.player.slider.song.update(ui.value); }
					});
				},

				update: function(value)
				{
					if (value && rude.player.song.id())
					{
						var song = rude.player.song.get();

						song.setPosition(song.duration * value / 100);
					}
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

						range: 'min',

						change: function(event, ui) { rude.player.slider.volume.update(ui.value); },
						slide:  function(event, ui) { rude.player.slider.volume.update(ui.value); }
					});

					rude.player.slider.volume.value(20);
				},

				update: function(value)
				{
					var icon = $(rude.player.settings.selector.slider.volume_icon);

					icon.removeClass('up').removeClass('down').removeClass('off');

					     if (value == 0) { icon.addClass('off');  }
					else if (value < 45) { icon.addClass('down'); }
					else                 { icon.addClass('up');   }

					$(rude.player.settings.selector.slider.volume_level).html(value + '%');


					if (rude.player.song.id())
					{
						var song = rude.player.song.get();

						song.setVolume(value);
					}
				},

				toggle: function()
				{
					var value = rude.player.slider.volume.value();

					var icon = $(rude.player.settings.selector.slider.volume_level);

					if (value != 0)
					{
						icon.attr('data-value', value);

						rude.player.slider.volume.value(0);
						rude.player.slider.volume.update(0);
					}
					else
					{
						var loaded = icon.attr('data-value');

						if (!loaded)
						{
							loaded = 100;
						}

						rude.player.slider.volume.value(loaded);
						rude.player.slider.volume.update(loaded);
					}
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

		buttons:
		{
			set:
			{
				playing: function()
				{
					$(rude.player.settings.selector.buttons.stop).show();
					$(rude.player.settings.selector.buttons.play).hide();
				},

				pausing: function()
				{
					$(rude.player.settings.selector.buttons.stop).hide();
					$(rude.player.settings.selector.buttons.play).show();
				}
			}
		},

		song:
		{
			id: function(id)
			{
				if (typeof id === 'undefined')
				{
					return $(rude.player.settings.selector.slider.song_current).val();
				}

				return $(rude.player.settings.selector.slider.song_current).val(id);
			},

			get: function(id)
			{
				if (typeof id === 'undefined')
				{
					id = rude.player.song.id();
				}

				return rude.player.manager.getSoundById(id);
			},

			add: function(file, name, author)
			{
				rude.player.song.unload(); // unload previous song from player
				rude.player.song.id(file); // reassign song id (we will use file name as an song identificator)

				$(rude.player.settings.selector.slider.song_title).html(name + ' - ' + author);

				rude.player.buttons.set.playing();

				rude.player.manager.createSound
				({
					id: file,

					url: rude.player.settings.directory.audio + file,

					autoLoad: true,

					onfinish: function()
					{
						console.log('playing finished');
					},

					onload: function()
					{
						soundManager._writeDebug(rude.time.to.string(this.duration));
					},

					whileplaying: function()
					{
						var complete = Math.floor(this.position / this.duration * 100);

						rude.player.slider.song.value(complete);

						$(rude.player.settings.selector.slider.song_length).html(rude.time.to.string(this.position) + '/' + rude.time.to.string(this.duration));
					}
				});
			},

			stop: function()
			{
				var song_id = rude.player.song.id();

				if (!song_id)
				{
					return;
				}

				rude.player.manager.pause(song_id);

				rude.player.buttons.set.pausing();
			},

			play: function()
			{
				var song_id = rude.player.song.id();

				if (!song_id)
				{
					return;
				}

				rude.player.manager.resume(song_id);

				rude.player.buttons.set.playing();
			},

			unload: function()
			{
				var song_id = rude.player.song.id();

				if (song_id)
				{
					soundManager.unload(song_id);
					soundManager.destroySound(song_id);
				}
			}
		}
	},

	comment:
	{
		add: function(url)
		{
			$.ajax
			({
				type: 'POST',
				url: url,
				data: $('#comment-form').serialize(), // serializes the form's elements.

				success: function()
				{
					rude.crawler.open(url);
				}
			});

			return false; // avoid to execute the actual submit of the form.
		}
	},

	time:
	{
		to:
		{
			string: function(milliseconds)
			{
				var minutes = Math.floor(milliseconds / 60000);
				var seconds = Math.floor((milliseconds - (minutes * 60000)) / 1000);

				if (seconds < 10) { seconds = '0' + seconds; }
				if (minutes < 10) { minutes = '0' + minutes; }

				return minutes + ':' + seconds;
			}
		}
	},

	base64:
	{
		decode: function(s)
		{
			var e = {}, i, b = 0, c, x, l = 0, a, r = '', w = String.fromCharCode, L = s.length;

			var A = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

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

					rude.crawler.open(url);

					return false;
				});
			});
		},

		open: function(url)
		{
			$.ajax
			({
				url: 'index.php' + url,

				type: 'GET',

				data: { ajax: 1 },

				success: function (data)
				{
					$('#content').html(data);

					console.log('success!');
				},

				error: function (request, status, error)
				{
					$('#content').html(request.responseText);

					console.log('fail!');
				}
			});

			if (url != window.location) // change current url
			{
				window.history.pushState(null, null, url);
			}
		}
	}
};
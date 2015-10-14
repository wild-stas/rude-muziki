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
		},

		contains: function(string, substring)
		{
			return string.indexOf(substring) > -1;
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
			},

			sticky: function()
			{
				$(function() {
					$('.ui.sticky').sticky();
				});
			}
		}
	},

	jquery:
	{
		escape:
		{
			selector: function(selector)
			{
				if (selector)
				{
					return selector.replace(/([ #;?%&,.+*~\':"!^$[\]()=>|\/@])/g,'\\$1');
				}

				return selector;
			}
		}
	},

	menu:
	{
		navigation:
		{
			title: function(title)
			{
				var text = 'Navigation';

				if (title)
				{
					text += ' (' + title + ')';
				}

				$('#menu .navigation .title').html(text);
			},

			hide: function()
			{
				if ($('#menu .navigation').hasClass('active'))
				{
					$('#menu .navigation').click();
				}
			}
		},

		settings:
		{
			hide: function()
			{
				if ($('#menu .settings').hasClass('active'))
				{
					$('#menu .settings').click();
				}
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
				audio: '/src/audio/'
			},

			selector:
			{
				buttons:
				{
					play:    '#player-button-play',
					stop:    '#player-button-stop',
					repeat:  '#player-button-repeat',
					shuffle: '#player-button-shuffle'
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
				rude.player.manager.debugFlash = true;
				rude.player.manager.useHighPerformance = true;
				rude.player.manager.autoLoad = false;
				rude.player.manager.preferFlash = false;
				rude.player.manager.noSWFCache = true;
				rude.player.slider.song.init();
				rude.player.slider.volume.init();
			});
		},

		playlist:
		{
			database: [],

			add: function(song_id, name, author)
			{
				var item = {song_id: song_id, name: name, author: author};

				rude.player.playlist.database.push(item);

				rude.player.playlist.ui.update();
			},

			get: function(song_id)
			{
				var database = rude.player.playlist.database;

				for (var index = 0; index < database.length; ++index)
				{
					var item = database[index];

					if (item.song_id == song_id)
					{
						return item;
					}
				}

				return null;
			},

			size: function()
			{
				return rude.player.playlist.database.length;
			},

			reindex: function()
			{
				rude.player.playlist.database = rude.player.playlist.database.filter(function (item) { return item != undefined }).join();
			},

			remove: function(song_id)
			{
				var database = rude.player.playlist.database;

				for (var index = 0; index < database.length; index++)
				{
					var item = database[index];

					if (item.song_id == song_id)
					{
						if (rude.player.song.is.playing(item.song_id))
						{
							rude.player.song.stop(item.song_id);
						}

						database.splice(database.indexOf(item), 1);

						break;
					}else{
						rude.player.song.stop();
						database.splice(database.indexOf(item), database.length);
						break;
					}
				}

				rude.player.playlist.ui.update();
			},

			is:
			{
				empty: function()
				{
					return rude.player.playlist.database.length > 0;
				},

				exists: function(song_id)
				{
					var database = rude.player.playlist.database;

					for (var index = 0; index < database.length; ++index)
					{
						var item = database[index];

						if (item.song_id == song_id)
						{
							return true;
						}
					}

					return false;
				}
			},

			ui:
			{
				update: function()
				{
					var html = '<table class="ui table striped celled small compact"><tbody>';


					var database = rude.player.playlist.database;

					for (var index = 0; index < database.length; ++index)
					{
						var item = database[index];

						html += '<tr class="song ' + item.song_id + '"><td class="width-2"><i class="icon video play" onclick="rude.player.song.play(\'' + item.song_id + '\')"></i></td><td>' + item.author + ' - ' + item.name + '</td><td class="width-2"><i class="icon remove" onclick="rude.player.playlist.remove(\'' + item.song_id + '\')"></i></td></tr>';
					}

					html += '</tbody></table>';

					$('#playlist').find('.content').html(html);

					rude.player.playlist.ui.activate();

					$('#playlist-size').html(rude.player.playlist.size());
				},

				activate: function(song_id)
				{
					if (typeof song_id === 'undefined')
					{
						song_id = rude.player.song.id();
					}

					if (!song_id)
					{
						return;
					}

					$('#playlist tr.song').removeClass('active');
					$('.song').removeClass('active');
					$('.'+ rude.jquery.escape.selector(rude.player.song.id())).addClass('active');
					$('#playlist tr.song.' + rude.jquery.escape.selector(song_id)).addClass('active');
				}
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
					debug('sound volume changed to: ' + value + '%');


					var icon = $(rude.player.settings.selector.slider.volume_icon);

					icon.removeClass('up').removeClass('down').removeClass('off');

					     if (value == 0) { icon.addClass('off');  }
					else if (value < 45) { icon.addClass('down'); }
					else                 { icon.addClass('up');   }

					$(rude.player.settings.selector.slider.volume_level).html(value + '%');


					var song_id = rude.player.song.id();

					if (song_id)
					{
						var song = rude.player.song.get(song_id);

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
			id: function(song_id)
			{
				if (typeof song_id === 'undefined')
				{
					return $(rude.player.settings.selector.slider.song_current).val();
				}

				return $(rude.player.settings.selector.slider.song_current).val(song_id);
			},

			get: function(song_id)
			{
				if (typeof song_id === 'undefined')
				{
					song_id = rude.player.song.id();
				}

				return rude.player.manager.getSoundById(song_id);
			},

			title: function(name, author)
			{
				if (typeof name === 'undefined' && typeof author === 'undefined')
				{
					return $(rude.player.settings.selector.slider.song_title).html();
				}

				if (name && author)
				{
					return $(rude.player.settings.selector.slider.song_title).html(name + ' - ' + author);
				}

				return $(rude.player.settings.selector.slider.song_title).html('');
			},

			length: function(position, duration)
			{
				$(rude.player.settings.selector.slider.song_length).html(rude.time.to.string(position) + '/' + rude.time.to.string(duration));
			},

			reset: function()
			{
				rude.player.song.title('', '');
				rude.player.song.id(0);
				rude.player.song.length(0, 0);
				rude.player.slider.song.value(0);
				rude.player.slider.song.update();
			},

			add: function(song_id, name, author, enable_autoload)
			{
				if(!enable_autoload) {
					enable_autoload = true;
				}


				enable_autoload = false;

				if (rude.player.playlist.is.exists(song_id))
				{
					return false;
				}

				rude.player.playlist.add(song_id, name, author);


				rude.player.manager.createSound
				({
					id: song_id,

					url: rude.player.settings.directory.audio + song_id,

					autoPlay: false,
					autoLoad: enable_autoload,

					onfinish: function()
					{
						console.log('playing finished');

						rude.player.song.next();
					},

					onload: function()
					{
						soundManager._writeDebug(rude.time.to.string(this.duration));
					},

					whileplaying: function()
					{
						var complete = Math.floor(this.position / this.duration * 100);

						rude.player.slider.song.value(complete);

						rude.player.song.length(this.position, this.duration);
					}
				});


				var song_previous = rude.player.song.id();

				if (!rude.player.song.is.playing(song_previous))
				{
					rude.player.song.play(song_id);
				}

				return true;
			},

			pause: function(song_id)
			{
				if (typeof song_id === 'undefined')
				{
					song_id = rude.player.song.id();
				}

				if (!song_id)
				{
					return;
				}

				rude.player.manager.pause(song_id);
				rude.player.buttons.set.pausing();
			},

			resume: function(song_id)
			{
				if (typeof song_id === 'undefined')
				{
					song_id = rude.player.song.id();
				}

				if (!song_id)
				{
					return;
				}

				rude.player.manager.resume(song_id);
				rude.player.buttons.set.playing();
			},

			stop: function(song_id)
			{
				if (typeof song_id === 'undefined')
				{
					song_id = rude.player.song.id();
				}

				if (!song_id)
				{
					return;
				}

				var song = rude.player.song.get(song_id);

				song.setVolume(rude.player.slider.volume.value());
				song.stop();

				rude.player.buttons.set.pausing();
			},

			stop_all: function()
			{
				var database = rude.player.playlist.database;

				for (var index = 0; index < database.length; index++)
				{
					var item = database[index];

					if (rude.player.song.is.playing(item.song_id))
					{
						rude.player.song.stop(item.song_id);
					}
				}
			},

			play: function(song_id)
			{
				if (typeof song_id === 'undefined')
				{
					song_id = rude.player.song.id();
				}

				if (!song_id)
				{
					return;
				}


				rude.player.song.stop_all();
				rude.player.song.reset();

				rude.player.song.id(song_id);

				rude.player.playlist.ui.activate(song_id);

				if (!rude.player.song.title())
				{
					var item = rude.player.playlist.get(song_id);

					rude.player.song.title(item.name, item.author);
				}

				var song = rude.player.song.get(song_id);

				song.setVolume(rude.player.slider.volume.value());
				song.play();

				rude.player.buttons.set.playing();
			},

			previous: function()
			{
				var song_id = rude.player.song.id();

				if (rude.player.song.is.playing(song_id))
				{
					rude.player.song.stop(song_id);
				}

				var database = rude.player.playlist.database;

				for (var index = 0; index < database.length; index++)
				{
					var item = database[index];

					if (item.song_id != song_id)
					{
						continue;
					}

					var last = database[database.length - 1];
					var previous  = database[index - 1];

					if (!previous && rude.player.song.is.enabled.repeat())
					{
						return rude.player.song.play(last.song_id);
					}
					else if (previous)
					{
						return rude.player.song.play(previous.song_id);
					}
				}

				rude.player.song.reset();

				return false;
			},

			next: function()
			{
				var song_id = rude.player.song.id();

				if (rude.player.song.is.playing(song_id))
				{
					rude.player.song.stop(song_id);
				}

				var database = rude.player.playlist.database;

				for (var index = 0; index < database.length; index++)
				{
					var item = database[index];

					if (item.song_id != song_id)
					{
						continue;
					}

					var first = database[0];
					var next  = database[index + 1];

					if (!next && rude.player.song.is.enabled.repeat())
					{
						return rude.player.song.play(first.song_id);
					}
					else if (next)
					{
						return rude.player.song.play(next.song_id);
					}
				}

				rude.player.song.reset();

				return false;
			},

			unload: function(song_id)
			{
				if (typeof song_id === 'undefined')
				{
					song_id = rude.player.song.id();
				}

				if (song_id)
				{
					soundManager.unload(song_id);
					soundManager.destroySound(song_id);
				}
			},

			is:
			{
				playing: function(song_id)
				{
					if (typeof song_id === 'undefined')
					{
						song_id = rude.player.song.id();
					}

					if (!song_id)
					{
						return false;
					}

					var song = rude.player.song.get(song_id);

					if (!song)
					{
						return false;
					}

					return song.playState === 1;
				},

				enabled:
				{
					repeat: function()
					{
						return $(rude.player.settings.selector.buttons.repeat).hasClass('active');
					}
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

	lazy:
	{
		limit: 100,
		offset: 100,

		init: function()
		{
			$(window).unbind('scroll');

			$(window).scroll(function()
			{
				if ($(window).scrollTop() + $(window).height() > rude.lazy.get.height() - 500)
				{
					$(window).unbind('scroll');

					rude.lazy.load();
				}
			});
		},

		reset: function()
		{
			rude.lazy.limit = 100;
			rude.lazy.offset = 100;
		},

		load: function()
		{
			var genre_id = rude.url.param.get('genre_id');

			debug('lazy load [offset: ' + rude.lazy.offset + ', limit: ' + rude.lazy.limit + ']');

			$.ajax
			({
				type: 'POST',

				url: '?page=ajax&task=lazy',

				data:
				{
					limit:  rude.lazy.limit,
					offset: rude.lazy.offset,

					genre_id: genre_id
				},

				success: function(html)
				{
					$('#recent').append(html);

					rude.lazy.init();
				}
			});

			rude.lazy.offset += 100;
		},

		get:
		{
			height: function()
			{
				return Math.max
				(
					document.body.scrollHeight, document.documentElement.scrollHeight,
					document.body.offsetHeight, document.documentElement.offsetHeight,
					document.body.clientHeight, document.documentElement.clientHeight
				);
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
			},

			get: function(key)
			{
				return location.search.split(key + '=')[1] ? location.search.split(key + '=')[1] : '';
			}
		}
	},

	crawler:
	{
		init: function ()
		{
			$(function()
			{
				$('a').not('.flex-control-nav li a').unbind('click');

				$('a').not('.flex-control-nav li a').click(function ()
				{
					$('#content').html('');
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
			console.log(url);

			if (rude.string.contains(url, '/song/'))
			{
				//
			}
			else
			{
				url = '/index.php' + url;
			}

			$.ajax
			({
				url: url,

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

		},

		repaint_site_menu: function()
		{
			$.ajax
			({
				url: '?page=ajax&task=repaint_menu',

				type: 'GET',

				data: { ajax: 1 },

				success: function (data)
				{
					$('#menu').html(data);

					console.log('success update menu!');
				}
			});


			rude.lazy.reset();
			rude.lazy.init();
		}
	}
};
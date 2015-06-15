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

	homepage:
	{

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
	}
};
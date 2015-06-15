// IE indexOf - http://stackoverflow.com/questions/1744310/how-to-fix-array-indexof-in-javascript-for-internet-explorer-browsers

if (!Array.prototype.indexOf)
{
	Array.prototype.indexOf = function (obj, start)
	{
		for (var i = (start || 0), j = this.length; i < j; i++)
		{
			if (this[i] === obj)
			{
				return i;
			}
		}

		return -1;
	}
}


// simulate click on mobile devices

$('.ui.label').on('tap', function()
{
	$(this).trigger('click');
});
/**
 * Created with IntelliJ IDEA.
 * Project: SmartHome GUI
 * User: Bubelbub <bubelbub@gmail.com>
 * Date: 12.12.13
 * Time: 12:36
 */

var SmartHome = {
	load: function ()
	{
		$(document).on('click', 'a.ajax', function(e)
		{
			e.preventDefault();
			$('#content').load($(this).attr('href') + ' #content > *');
		});

		$(document).on('click', 'a.jsmodal', function(e)
		{
			e.preventDefault();
			var target = $(this).attr('href'),
				dataTarget = $(this).attr('data-target');
			if($(dataTarget).length < 1)
			{
				$('body').append('<div class="modal fade" id="theModal" tabindex="-1" role="dialog" aria-labelledby="theModal" aria-hidden="true"></div>');
				dataTarget = '#theModal';
			}
			$(dataTarget).load(target, function()
			{
				$(dataTarget).modal('show');
			});
		});
	}
};

$(function()
{
	SmartHome.load();
});

//TODO Needs compressing
jQuery(document).ready(function($) {
	$('.eo-inline-help').each(function() {
		var id = $(this).attr('id').substr(15);
		$(this).qtip({
			content: {
				text: eoHelp[id].content,
				title: {
					text: eoHelp[id].title
				}
			},
			show: {
				solo: true,
				event: 'click mouseenter',
			},
			hide: 'unfocus, click',
			style: {
				classes: 'qtip-eo ui-tooltip-shadow'
			},
			position : {
				 viewport: $(window)
			}
		});
		$(this).click(function(e){
			e.preventDefault();
		});
	});
});

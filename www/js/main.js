$(function(){

	$.ajaxSetup({
		cache: false,
		success: function(payload) {
			if (payload.snippets) {
				for (var i in payload.snippets) {
					$('#' + i).html(payload.snippets[i]);
				}
			}
		}
	});

	// odesilani odkazu AJAXem
	$('a.ajax').live('click', function(event) {
		event.preventDefault();
		$.get(this.href);
	});

	// odesilani formularu AJAXem
	$('form.ajax').live('submit', function(event) {
		event.preventDefault();
		$.post(this.action, $(this).serialize());
	});

});
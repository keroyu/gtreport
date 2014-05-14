$(document).ready(function(){

	$('.toggle-btn').on( 'click', function(e){
		e.preventDefault();
		var target = $(this).data('target');
		$(target).slideToggle('fast');
	});

	$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

	
});
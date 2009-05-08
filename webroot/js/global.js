$(document).ready(function(){
	$('a.button.submit').click(function(){
		$(this).closest('form').get(0).submit();
	});
});
$(function(){
	$('#iconSearch').click(function() {
		let keyword = $('#s').val().trim();
		window.location.href = "/search?q=" + keyword;
	});
});

$(document).on('keypress', function(e) {
	let keyword = $('#s').val().trim();
	if(e.which === 13 && keyword.length > 0){
		console.log(keyword);
		window.location.href = "/search?q=" + keyword;
	}
});
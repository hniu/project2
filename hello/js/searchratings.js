$(document).ready(function() {  
	//live search function for ratings; queries database for each key entered
	function search() {
		var query_value = $('input#search').val();
		$('b#search-string').html(query_value);
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: "core/search.php",
				data: { query: query_value },
				cache: false,
				success: function(html){
					$("ul#results").html(html);
				}
			});
		}return false;    
	}

	$("input#search").live("keyup", function(e) {
		//set a timeout in case takes too long
		clearTimeout($.data(this, 'timer'));

		//the search term
		var search_string = $(this).val();

		//execute the search
		if (search_string == '') {
			$("ul#results").fadeOut();
			$('h4#results-text').fadeOut();
		}else{
			$("ul#results").fadeIn();
			$('h4#results-text').fadeIn();
			$(this).data('timer', setTimeout(search, 100));
		};
	});

$("input#search").keyup();

});
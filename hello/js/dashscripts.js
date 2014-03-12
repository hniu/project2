//Search database for courses within a current term and display results
//on the DASHBOARD.  Predefined search buttons allow the user to specify
//what type of courses to display e.g. CIS, BI, PHYS. 
$(function() {
    $(document).on("click", ".search, .searchonload", function() {
            var searchString = $(this).attr('value');
            var data = 'search='+ searchString;
            // call to ajax
            $.ajax({
                type: "POST",
                url: "core/dashschedule.php",
                data: data,
                beforeSend: function(html) { 
                    $("#results").html(''); 
                    $("#searchresults").show();
                    $(".word").html(searchString);
                },
                success: function(html){
                    $("#results").show();
                    $("#results").append(html);
                }
            });

            return false;
        });
});

//When page loads trigger the CIS button so the initial results on page load
//is for CIS courses
jQuery(function(){
    jQuery('.searchonload').click();
});

//Table decoration for readability.  Applies a light, dark pattern to results
$(document).ready(function(){
    $("ol > li").each(function(i, val) {
        $(this).css("background", i & 1 ? "#f1f1f1" : "#fafafa");
    });
    $("input#search").keyup();
});

//Dashboard popup
$(document).ready(function(){
 //In screen pop up for dash-schedule on dashboard.
	$(document).on("click", "#pop", function(){
		$("#overlay_form").fadeIn(300);
	});

	$(document).on("click", "#close", function(){
		$("#overlay_form").fadeOut(100);
	});

});
//maintain the popup at center of the page when browser resized
$(window).bind('resize',positionPopup);

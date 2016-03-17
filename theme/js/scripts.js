
$.fn.cycle.defaults.timeout = 6000;
$(function() {
    // run the code in the markup!


	$('#slider').cycle({ 
    fx:     'fade', 
    timeout: 2000, 
	next:   '#next',
    prev:   '#prev',
	vertical: true,
    pause:   1 
});
	
$(".flipbox img").hover(function() {

$('#flipbox').addClass( "selected" );
	$("#flipbox").flip({
	direction:'rl',
	speed:60,
	content:'<a href="#" class="nacirprofile">List Of Areas Under NA-251</a>',
})


	
$(".selected").on("mouseleave",function(){
	$('#flipbox').removeClass( "selected" );
	$("#flipbox").revertFlip();
	

});


});



	





	});
	
/**/



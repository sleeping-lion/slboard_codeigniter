$(document).ready(function() {
	//$('header nav ul').superfish({delay:400,animation:{opacity:'show', height:'show'},speed:400,autoArrows:  false,dropShadows: false});	

	$('.modal_link').click(function(event){
  	event.preventDefault();
  	$('#myModal').removeData("modal");
  	$('#myModal').modal({'remote':$(this).attr('href')+'?no_layout=true'});
	});  
  
});

if(!$('#myCanvas').tagcanvas({
    outlineThickness : 1,
    maxSpeed : 0.05,
			textFont: null,
			textColour: null,
			weight: true,   
    depth : 1
  },'tags')) {
    // TagCanvas failed to load
    $('#myCanvasContainer').hide();
    $("#tags ul").css({'margin':0,'padding':0,'list-style':'none'});
    $("#tags ul li").css({'float':'left','margin':'0 10px'});     
  }


$(document).ready(function(){
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

	$(".btn_minimize").click(function(){
		var i=$(this).parent().find('i:first');
        if(i.hasClass('glyphicon-chevron-down')) {
            i.removeAttr('class').addClass('glyphicon').addClass('glyphicon-chevron-up');
            $(this).parent().parent().parent().find('.box_content').slideDown();
        } else {
            i.removeAttr('class').addClass('glyphicon').addClass('glyphicon-chevron-down');
            $(this).parent().parent().parent().find('.box_content').slideUp();
        }
		return false;
	});
	
	$(".btn_close").click(function(){
		$(this).parent().parent().parent().remove();
		return false;
	});
	
	$("#sl_blog_categories .box_content ul span.c_pointer").click(function(){
		if($(this).parent().find('ul').is(':visible')) {
		$(this).parent().find('ul').hide();
		$(this).find('span:eq(1)').html('&nbsp;&lt;&lt;');
		} else {
		$(this).parent().find('ul').show();
		$(this).find('span:eq(1)').html('&nbsp;&gt;&gt;');
		}
	});
});
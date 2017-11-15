$(".menu-contents").click(function(){
	var $menu_content = $(this);
	  $(".menu-contents").each( function() {
		  if($menu_content!=$(this)){
        	  if($(this).hasClass("active")){
        		$(this).removeClass("active");
        	  }
		  }else{
			$(this).addClass("active");
		  }
	  });
});
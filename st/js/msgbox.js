ui = window.ui ||{
	success:function(message,error){
		var style = (error==1)?"html_clew_box clew_error ":"html_clew_box";
		var html   =   '<div id="ui_messageBox" style="display:none">'
					   + '<div class="html_clew_box_con" id="ui_messageContent">&nbsp;</div></div>';
		var init      =  0;
		
		var showMessage = function( message ){		
			if( !init ){
				$('body').append( html );
				init = 1;
			}
			
			var top_jl = $(window).scrollTop();
			
			$( '#ui_messageContent' ).html( message );
			$('#ui_messageBox').attr('class',style);
			var now_height = $(window).height();
	        var now_width = $(window).width();			
				
			$( '#ui_messageBox' ).css({
			left:( now_width/2  - $( '#ui_messageBox' ).outerWidth()/2 ) + "px",
			top:( now_height/2 - $( '#ui_messageBox' ).outerHeight()/2 + top_jl ) + "px"
			});	
			
			$( '#ui_messageBox' ).fadeIn("slow");
			
		}
		
		var closeMessage = function(){
			setTimeout( function(){  
				$( '#ui_messageBox' ).fadeOut("fast");
			} , 3500);
		}
		
		showMessage( message );
		closeMessage();

	},
	
	error:function(message){
		ui.success(message,1);
		
	}
	
}

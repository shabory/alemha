jQuery(document).ready(function($){
         var count=0;
         $("#dialog").dialog({ autoOpen: false });
 
        $("#preview_btn").click(
            function () {
                count++;
                //alert(count);
                var formElements = new Array();

                   formElements=$("form :input").serialize(); 
                //alert(formElements);
               
				jQuery.ajax({
					type : "post",
					 url: myAjax.ajaxurl,
					  data: {
						  
					action: "preview_img",
                                        formElements : formElements,
                                        count :count
					
				},
				
				success: function(response){
//                                    if(!$('#dialog').is(':visible'))
//                                    {
//                                      $("#dialog > img").attr('src', " ");
//                                    }
//                                    alert( $('#dialog > img').prop('src') );
                                    //$("#dialog > img").attr('src', "");
                                    //$("#dialog").load();
                                    
                                    $("#dialog > img").attr('src', response);
                                    //alert( $('#dialog > img').prop('src') );
                                    $("#dialog").dialog('open');
					
                                }
			   });
               
               
               
                return false;
                
            }
            
        );
//if(!$('#dialog').is(':visible'))
//{
//    alert("hii");
//}    

//    if($('#yourID').css('display') == 'none')
//{
//
//}   

	
});
jQuery(function($) {
//    jQuery(".ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close").click(function(){
//           alert("hii");
//        });
        
//    if(!$('#dialog').is(':visible'))
//{
//    alert("hii");
//}    

});


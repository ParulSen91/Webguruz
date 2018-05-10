  jQuery(document).ready(function($) { 
	      $("#package_requiest").validate({ 
			rules: {
				
				username: {
					required: true,

					
				},

				  password: {
					required: true,
					minlength: 5
				},

			
			 email: {
                           required: true,
                           email: true

                           },
				
				tel: {
					required: true,
					digits: true,
					minlength:10,
					maxlength:10
				}
				
			},
			messages: {
				username: "Please enter a valid username",
				username: {
					required: "Please enter a username",
					
				},

				password: {
					required: "Please enter a password",
					minlength: "Your password must be at least 5 characters long"
				},
				
				email: "Please enter a valid email address",
				email: {

					required:"Please enter an email",
					
				},

				//tel:"Please enter a valid number",

				tel: {
					required:"Please enter a number",
					digits: "This field can only contain numbers",
					minlength:"Please enter a valid number",
					maxlength:"Please enter a valid number",

				}
			}
		

		});

		
	$( "#package_requiest" ).submit(function( event ) {


          if ($(this).valid()) {
				alert( "Handler for .submit() called." );
				event.preventDefault();

					var ajax_url = $(this).attr( 'action' );



					var serializedData =$(this).serialize();

				
                          
                $.ajax({
                      type: 'POST',
                      url: ajax_url,
                      data: serializedData,
                      

                      success: function(data)
                      {
                      alert(data);  //Hide loader here
                                 /*          if($.trim(data) === "successfully"){
                                          $("#form1").trigger("reset");
                                         $("#upload-file-info").hide();
                                         $('#form1').each(function(){
                                         this.reset();
                                             });
                                                $(".requstpopup").modal('show');
                        //$('#resformmessage').show();
                                                //alert(data);
                                             }
                                             if(data=='capcha-error'){
                                              jQuery("#captcha_err").html(data).css("color", "red");
                                             }*/
                      },
                      error: function()
                      {
                        /*jQuery("#resformmessage").html('<p>There has been an error</p>');*/
                      }
                    });
					}
		});
	});
 
 jQuery(document).ready(function($) {

$( "#valid" ).validate({
 rules: {
   email1: {
      required: true,
      
    }
  },
  messages: {
  	email: "Please enter a valid email address",
				email: {

					required:"Please enter an email",
					
				}
  }
});

		

});
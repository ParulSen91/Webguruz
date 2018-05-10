<?php
/**
 * The template name:Special Offers
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */


// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$config = Presscore_Config::get_instance();
$config->set('template', 'page');
if (is_front_page())
{

get_header('home');

}
else
{
  get_header();

}
$rqf = $_REQUEST['rqf'];
if($_REQUEST['promo']){
   $promo=$_REQUEST['promo'];
}
else{
  $promo='';

}
 ?>
<style>
.ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.ui-resizable {
  left: 50% !important;
  margin-left: -150px;
  top: 50% !important;
}
</style>
 <script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript">
jQuery(document).ready(function(){
   var rqf = "<?php echo $rqf; ?>";
  jQuery('select').val(rqf).attr("selected", "selected");

});
  </script>

    <?php if ( presscore_is_content_visible() ): ?>

      <div id="content" class="content" role="main">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script>
jQuery(function($) {
 

  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\- . @\s]+$/i.test(value);
    }, "Please enter only letters, numbers, or (@ , . , -) only.");
    $("#form1").validate({
        // Specify the validation rules

    
    
        rules: {
            fname: {
      required: true,
      minlength: 3,
      maxlength: 25,
      loginRegex : true
       },
      email: {
                required: true,
                  email: true
               },
            phone: {
      required: true,
      number: true,
      minlength: 10,
      maxlength: 10
       },
       
       des : { loginRegex : true },
       skype_id : { loginRegex : true }
        },
        // Specify the validation error messages
        messages: {
            fname: {
                   required: "Please enter name",
                   minlength: "Minimum 3 Character",
       maxlength: "Maximum 25 Character"
            },
      email: {
                   required: "Please enter email address", 
                   email: "Please enter a valid email address"
            },
      phone: {
                   required: "Please provide a phone",
                   minlength: "Minimum 10 digit number",
       maxlength: "Maximum 10 digit number"
            },
      
           
      service: "Please select any one service"  
          },
    
  errorPlacement: function(error, element) {
   if (element.attr("name") == "fname" ){
        error.insertAfter("#first"); 
  }
  
  else if (element.attr("name") == "email" ){
        error.insertAfter("#second"); 
  }
  
  else if (element.attr("name") == "phone" ){
        error.insertAfter("#third"); 
  }
  
    else if (element.attr("name") == "website" ){
        error.insertAfter("#fourth"); 
  }
    else if (element.attr("name") == "des" ){
        error.insertAfter("#des"); 
  }
  else if (element.attr("name") == "skype_id" ){
        error.insertAfter("#skype_id"); 
  }
  

},
    
        
    });
    $('input,textarea').focus(function () {
        $(this).data('placeholder', $(this).attr('placeholder'))
               .attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).data('placeholder'));
    });
  $('#close').click(function () {
        $('#resformmessage').hide();
      });

                  $( "#form1" ).submit(function( event ) {
                     var budget=''
                            if($('#pr1').val()!=''){

                          budget=$('#pr1').val();

                            }
                            else{
                              budget=$('#pr2').val();
                            }
                          $('#price1').val(budget);

                    if ($("#form1").valid()) {
                  event.preventDefault();

                              var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
                              var serializedData = new FormData(this);

   serializedData.append( "action", 'special_offer'); 
                          
                $.ajax({
                      type: 'POST',
                      url: ajax_url,
                      data: serializedData,
                        action: 'special_offer',
                       processData: false,
                         contentType: false,
                         cache: false,
                                               
                      
                      success: function(data)
                      {
                      //alert(data);  //Hide loader here
                                           if($.trim(data) === "successfully"){
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
                                             }
                      },
                      error: function()
                      {
                        jQuery("#resformmessage").html('<p>There has been an error</p>');
                      }
                    });
                            
                            //form.submit();
                    }



                });
  });


</script>
  <div class="fancy-header">
    <div class="servicemainhead text-center "><h1 style="margin-bottom:20px;">Special Offers</h1> </div>
    <div class="innerhead-small text-center">Provide Us Opportunity To Serve you And Deliver The Best For You</div>
  </div>
<div class="modal fade requstpopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Thank-you for submitting your requirements !</h4>
      </div>
      <div class="modal-body">
        <p>Our business  team will get back to you in 48 hours.</p>
        <div style="color:#f2a803; padding-top:15px;">Cheers!!<br/>
Team Webguruz</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <div class="entry-content page-content-area container">
        <div class="form-section">
          <div class="frow">
           <div id="resformmessagess" style="display: none;">Thankyou for submitting your requirement. Our business development team will get back to you in 48 hours.Happy business
             <div id="close" class="ult-overlay-closess">Close</div>
              </div>
            <div class="left-sec-form">
              <div class="qupte-form">
                <div id="employeeapp">
                  <form method="post" action="<?php $_SERVER['PHP_SELF'];?>" name="form1" id="form1" enctype="multipart/form-data">
                    <fieldset id="employmentfieldset">
                      <div id="resdd"> <?php echo $msg; ?></div>

                     <?php if($reffer_quote!=''){ ?>
                    <div class="frow">
                    <div class="col-md-12">
                     <label class="control-label">Refference Project</label>
                      <input type="text" id="refference" name="refference" value="<?php echo $reffer_quote;?>" readonly 
                      class="form-control">
                   </div>
                    </div>
                     <?php } ?>
                      <div class="frow">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Your Name</label>
                            <div class="input-group" id="first">
                              <div class="input-group-addon"><i class="fa fa-user"></i></div>
                              <input type="text"  id="fname" class="form-control" name="fname" placeholder="Enter name"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Your Email</label>
                            <div class="input-group" id="second">
                              <div class="input-group-addon"><i class="fa fa-send"></i></div>
                              <input type="text"  id="email" name="email" class="form-control" placeholder="Enter your mail"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="frow">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <div class="input-group" id="third">
                              <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                              <input type="text" maxlength="3"  id="isd" name="isd" class="form-control" placeholder="ISD"/>
                              <input type="text" maxlength="10"  id="phone" name="phone" class="form-control" placeholder="Enter phone"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Skype ID</label>
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-skype"></i></div>
                              <input type="text"  id="skype_id" name="skype_id" class="form-control"  placeholder="Enter Skype ID" >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="frow">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Existing Website</label>
                            <div class="input-group" id="fourth">
                              <div class="input-group-addon"><i class="fa fa-firefox"></i></div>
                              <input type="text"  id="website" name="website" class="form-control"  placeholder="Enter url"/>
                            </div>
                          </div>
                        </div>

                         <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">HOW DID YOU HEAR ABOUT US</label>
                            <div class="input-group select-wrap">
                              <div class="input-group-addon"><i class="fa fa-file-text"></i></div>
                              <select class="" name="refference">
                              <option value="Google Search">Google Search</option>
                              <option value="Social Media">Social Media</option>
                              <option value="Referral">Referral</option>
                              <option value="LinkedIn">LinkedIn</option>
                              <option value="Blog">Blog</option>
                              <option value="Directory/Classifieds">Directory/Classifieds</option>
                              <option value="Newspaper">Newspaper</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="frow">
                          <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Web Services that you want :</label>
                            <div class="input-group select-wrap">
                              <div class="input-group-addon"><i class="fa fa-list"></i></div>
                              <select class="service" name="service" id="service">
                              <option value="">Select</option>
                              <option data-id="1" value="Web-Development">Web-Development</option>
                              <option data-id="2" value="Ecommerce store">Ecommerce store</option>
                              <option data-id="3" value="Iphone application">Iphone application</option>
                              <option data-id="4" value="Android application development">Android application development</option>
                              <option data-id="5" value="Web-Designing">Web-Designing</option>
                              <option data-id="6" value="Logo Designing">Logo Designing</option>
                              <option data-id="7" value="UX Design">UI/UX designing</option>
                              <option data-id="8" value="HTML 5 Development">HTML5</option>
                              <option data-id="9" value="Real-Estate web Maintenance">Real-Estate web Maintenance</option>
                              <option data-id="10" value="Responsive website">Responsive website</option>
                              <option data-id="11" value="Hubspot Development">Hubspot Development</option>
                              <option data-id="12" value="Infusionsoft development">Infusionsoft development</option>
                              <option data-id="13" value="Digital Marketing">Digital Marketing</option>
                              <option data-id="14" value="SEO">SEO</option>
                              <option data-id="15" value="SMM">SMM</option>
                              <option data-id="16" value="ORM">ORM</option>
                              <option data-id="17" value="Inbound marketing">Inbound marketing</option>
                              <option data-id="18" value="Content Marketing">Content Marketing</option>
                              <option data-id="19" value="Content Writing/Copy-writing">Content Writing/Copy-writing</option>
                              <option data-id="20" value="Linkedin Marketing">Linkedin Marketing</option>
                              <option data-id="21" value="Facebook Marketing">Facebook Marketing</option>
                              <option data-id="22" value="Email Marketing">Email Marketing</option>
                              <option data-id="23" value="Adwords/PPC">Adwords/PPC</option>
                              <option data-id="24" value="Shopify Maintenance">Shopify Maintenance</option>
                              <option data-id="25" value="Magento Maintenance">Magento Maintenance</option>
                              <option data-id="26" value="Website Maintenance">Website Maintenance</option>
                              <option data-id="27" value="Wordpress Maintenance">Wordpress Maintenance</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Estimate Budget</label>
              <div id="fourth" class="input-group">
              <div class="input-group-addon"><i class="fa fa-money"></i></div>
             <!--  
              <div id="mySlider"></div> -->
              <div id="price-budget">
              <select class="package-1" id="pr1" style="display:none">
               <option value="">Select Plan</option>
             </select>
          <input type='text' id="pr2" />
              </div>
              </div>
              <input type="hidden" name="est_budget" id="price1" /> 
                  
              
                          
                          </div>
                        </div>
                      </div>
                      <div class="frow">
                        <div class="col-md-12 short-dis">
                          <div class="form-group">
                            <label class="control-label">Short description of the Project </label>
                            <textarea  class="form-control1" id="des" name="des" ></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="frow">
                        <div class="col-md-6">
                          <!-- <label class="control-label">Initial Documentation</label> -->
                          <div class="form-group">
                           <!--  <div class="uploadbutton"> <i class="fa fa-cloud-upload"></i> Upload file
                              <input type="file"  id="file" class="file-load-btn" name="file" >
                            </div> -->
                            <span class='label label-info' id="upload-file-info"></span> </div>
                            <div class="g-recaptcha" data-sitekey="6LdgFykUAAAAAKXNwuiFHZK20mgvZ9h6EMUGDC0S"></div>
                            <div id="captcha_err"></div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Promocode</label>
                           <input type="text"  id="promocode" name="promocode" class="form-control"  placeholder="Promocode" value="<?php echo $promo; ?>" /> </div>
                          <input type="submit" value="Get Quote" class="quote-btn" name="submit"  style="padding:1px 38px !important; border:0px !important; font-size:20px; font-weight:400; margin-top:43px; float:right; text-transform:capitalize;"/>
                        </div>
                      
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <?php //get_template_part( 'inc/emp', 'none' ); ?>
      </div>
    </main>
    <!-- .site-main --> 
  </div>
  <!-- .content-area --> 
 <?php the_content(); ?>

        <?php endwhile; ?>

      <?php else : ?>

        <?php get_template_part( 'no-results', 'page' ); ?>

      <?php endif; ?>

      </div><!-- #content -->

      <?php do_action('presscore_after_content'); ?>

    <?php endif; // if content visible ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/custom/js/bootstrap.min.css" >
<script src="<?php bloginfo('template_url'); ?>/custom/js/bootstrap.min.js" ></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />
<script>
// $.noConflict();
        jQuery(document).ready(function($) {
           var arr = [];
        $( ".service" ).change(function() {
  
              if($(this).val()=='Web-Designing'){
                arr =['Basic: $120 Monthly', 'Standard: $225 Monthly', 'Premium: $325 Monthly']

                }
              else if($(this).val()=='Ecommerce store'){
                arr =['Economy Plan: $100 Monthly', 'Business Plan: $150 Monthly', 'Enterprise Plan: $200 Monthly']
                
                }
              else if($(this).val()=='Inbound marketing'){
                arr =['Basic: $2000 Monthly', 'Professional: $3000 Monthly', 'Enterprise: $5000 Monthly']
                
                }

             else if($(this).val()=='Magento Maintenance'){
                arr =['Economy Plan: $199 Monthly', 'Business Plan: $249 Monthly', 'Enterprise: Plan: $229 Monthly']
                
                }
              else if($(this).val()=='Real-Estate web Maintenance'){
                arr =['Up & Coming: $35 Monthly', 'Progressive: $79 Monthly', 'Enterprise: $125 Monthly']
                
                }
             else if($(this).val()=='Shopify Maintenance'){
                arr =['Basic: $99 Monthly', 'Premium: $129 Monthly']
                
                } 
            else if($(this).val()=='Website Maintenance'){
                arr =['Up& Coming: $49 Monthly', 'Progressive: $99 Monthly', 'Enterprise: $149 Monthly']
                
                }

              else if($(this).val()=='Wordpress Maintenance'){
                arr =['Economy Plan: $55 Monthly', 'Business Plan: $99 Monthly', 'Enterprise Plan: $229 Monthly']
                
                } 

             else if($(this).val()=='SEO'){
                arr =['Starter: $299 Monthly', 'Booster: $499 Monthly', 'Edge: $599 Monthly', 'Edge Plus: $649 Monthly']
                
                } 

              else if($(this).val()=='Content Writing/Copy-writing'){
                arr =['Basic: $1000 Monthly', 'Edge: $1800 Monthly', 'Edge Plus: $2500 Monthly']
                
                }
                else{
                 arr ='';

                }  
                      if(arr.length>0){ 

                              var myselect=$('<select>');

                            for ( var i = 0, l = arr.length; i < l; i++ ) {
                               
                               $(myselect).append($("<option></option>").attr("value",arr[ i ]).text(arr[ i ])); 

                            } 

                             $('#price-budget #pr2').hide();
                            $('#pr1').find('option').remove().end().append(myselect.html()).show();
                            }
                    else{
                     $('#price-budget #pr1').hide();
                     $('#price-budget #pr2').show();
                   }
});
          
        });
    </script>
<?php get_footer(); ?>

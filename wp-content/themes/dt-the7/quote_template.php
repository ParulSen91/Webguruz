<?php
/**
 * The template name:Quote
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
          function countChar() {
                     /*alert();*/
                      var val = document.getElementById("des");
                      var len = val.value.length;
                      if (len <= 500) {
                      jQuery('#charNum').text(500 - len+' characters remaining.').css('color','#EDA100');
                      }
                      else{
                      val.value = val.value.substring(0, 500);
                      jQuery('#charNum').text('Maximum characters limit of 500 is over').css('color','red');
                       }
                    };
jQuery(function($) {
   

  $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\- . @\s]+$/i.test(value);
    }, "Please enter only letters, numbers, or (@ , . , -) only.");

    $.validator.addMethod("filetype", function(value, element) {
    var types = ['doc', 'docx', 'csv', 'pdf', 'xls', 'txt','jpg','jpeg','png'],
        ext = value.replace(/.*[.]/, '').toLowerCase();

    if (types.indexOf(ext) !== -1 || value =='') {
            //$("#city_banner-error").html('');
        return true;
    }
    return false;
    },
  "Please select doc, docx, csv, pdf, xls, jpg, jpeg, png or txt file"
  );


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
       file:
      {
        filetype: true
      },
      
       des : { 
      
        loginRegex : true },
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
    /*    error.insertAfter("#des"); */
         //error.appendTo('#charNum');
         $('#charNum').html(error);
  }
  else if (element.attr("name") == "skype_id" ){
        error.insertAfter("#skype_id"); 
  }
  else if (element.attr("name") == "file" ){
        error.insertAfter(".uploadbutton"); 
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

                    if ($("#form1").valid()) {
                  event.preventDefault();
               $('#loaderpage').show();
                              var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;


 var serializedData = new FormData(this);

   serializedData.append( "action", 'request_filter'); 
                          
                $.ajax({
                      type: 'POST',
                      url: ajax_url,
                      data: serializedData,
                        action: 'request_filter',
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
                                         $('#charNum').text('');
                                            $( "#price" ).text("$0 - $100000");
                                            $( "#price1" ).val("$0 - $100000" );
                                            $('#loaderpage').hide();
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
    <div class="servicemainhead text-center "><h1 style="margin-bottom:20px;">Request A Free Quote</h1> </div>
    <div class="innerhead-small text-center">Provide Us Opportunity To Serve you And Deliver The Best For You</div>
  </div>
  <div style="display: none; " id="loaderpage">
  <img style="
    position: fixed;
    left: 50%;
    top: 35%;
    z-index: 1000;
    height: 40px;
    width: 40px;
    background: transparent;    
" src="<?php echo get_template_directory_uri();?>/images/loaderquote.gif ">
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
                     <label class="control-label">Reference Project</label>
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
                              <select class="service" name="service">
                              <option value="">Select</option>
                              <option data-id="1" value="Web- Development">Web- Development</option>
                              <option data-id="2" value="Ecommerce store">Ecommerce store</option>
                              <option data-id="3" value="Iphone application">Iphone application</option>
                              <option data-id="4" value="Android application development">Android application development</option>
                              <option data-id="5" value="Web-Designing">Web-Designing</option>
                              <option data-id="6" value="Logo Designing">Logo Designing</option>
                              <option data-id="7" value="UX Design">UI/UX designing</option>
                              <option data-id="8" value="HTML 5 Development">HTML5</option>
                              <option data-id="9" value="Real-Estate web application">Real-Estate web application</option>
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
                              <option data-id="24" value="Shopify development">Shopify development</option>
                              <option data-id="25" value="Magento Development">Magento Development</option>
                              <option data-id="26" value="full-stack-js">Full Stack JS Development</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label">Estimate Budget</label>
              <div id="fourth" class="input-group">
              <div class="input-group-addon"><i class="fa fa-money"></i></div>
              <div id="price" class="form-control"></div>
              <div id="mySlider"></div>
              </div>
              <input type="hidden" name="est_budget" id="price1" /> 
                        
                          </div>
                        </div>
                      </div>
                      <div class="frow">
                        <div class="col-md-12 short-dis">
                          <div class="form-group">
                            <label class="control-label">Short description of the Project </label>
                            <textarea onkeyup="countChar()" maxlength="500" class="form-control1" id="des" name="des" ></textarea>
                            <div id="charNum"></div>
                          </div>
                        </div>
                      </div>
                      <div class="frow">
                        <div class="col-md-6">
                          <label class="control-label">Initial Documentation</label>
                           <div class="form-group">
                            <div class="uploadbutton"> <i class="fa fa-cloud-upload"></i> Upload file
                              <input type="file"  id="file" class="file-load-btn" name="file" >
                            </div>
                            <span class='label label-info' id="upload-file-info"></span> </div>
                            <div class="g-recaptcha" data-sitekey="6LdgFykUAAAAAKXNwuiFHZK20mgvZ9h6EMUGDC0S"></div>
                            <div id="captcha_err"></div>
                        </div>
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <!-- <label class="control-label">Promocode</label> -->
                           </div>
                          <input type="submit" value="Get Quote" class="quote-btn" name="submit"  style="padding:1px 38px !important; border:0px !important; font-size:20px; font-weight:400; margin-top:43px; float:right; text-transform:capitalize;"/>
                        </div>
                     
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
            <div class="right-sec-form">
              <div class="strenghts">
                <div  class="strength-title">
                  <h3>Our Strengths</h3>
                </div>
                <div class="strength-body">
                  <div class="strength-list">
                    <div class="idustrial item-list">
                      <div class="strength-item">
                        <p>9 Years Of Industrial <br/>
                          Working Experience</p>
                      </div>
                    </div>
                    <div class="tech item-list">
                      <div class="strength-item">
                        <p>1 Year Free <br/>
                          Technical Support</p>
                      </div>
                    </div>
                    <div class="project-del item-list">
                      <div class="strength-item">
                        <p>More than 1000<br/>
                          Projects Delivered</p>
                      </div>
                    </div>
                    <div class="creative item-list">
                      <div class="strength-item">
                        <p>Innovative & Creative<br/>
                          Concept</p>
                      </div>
                    </div>
                    <div class="affordable item-list">
                      <div class="strength-item">
                        <p>Solutions At<br/>
                          Affordable  Price</p>
                      </div>
                    </div>
                    <div class="quality item-list">
                      <div class="strength-item">
                        <p>We Believe In <br/>
                          Quality Work</p>
                      </div>
                    </div>
                  </div>
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
         
        $( "#mySlider" ).slider({
          range: true,
          min: 0,
          max: 100000,
          values: [ 0, 100000 ],
          step: 1000,
          slide: function( event, ui ) {
         $( "#price" ).text( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
     $( "#price1" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
         }
      });
          
      $( "#price" ).text( "$" + $( "#mySlider" ).slider( "values", 0 ) +
               " - $" + $( "#mySlider" ).slider( "values", 1 ) );
          
        });
    </script>
<?php get_footer(); ?>

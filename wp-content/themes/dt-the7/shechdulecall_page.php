<?php
/**
 * The template name: schedule form
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
define( 'WPFP_PATH', get_template_directory_uri() ); 
$config = Presscore_Config::get_instance();
$config->set('template', 'page');
get_header();

global $wpdb;
$urlDir = get_template_directory_uri();
include('/home/proglasscpanel/webguruz.in/wp-content/themes/dt-the7/google-api-php-client/src/Google_Client.php');
include('/home/proglasscpanel/webguruz.in/wp-content/themes/dt-the7/google-api-php-client/src/contrib/Google_CalendarService.php');

session_start();
?>

<link rel="stylesheet" type="text/css" href="<?php echo  $urlDir; ?>/custom/jquery/jquery.datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo  $urlDir; ?>/custom/jquery/style.css"/>
<script>
     function countChar() {
                         /*alert();*/
                          var val = document.getElementById("desc");
                          var len = val.value.length;
                          if (len <= 500) {
                          jQuery('#charNum').text(500 - len+' characters remaining.').css('color','#EDA100');
                          }
                          else{
                          val.value = val.value.substring(0, 500);
                          jQuery('#charNum').text('Maximum characters limit of 500 is over').css('color','red');
                           }
                        };
      jQuery(document).ready(function($){
      $('input[name="phone"]').keyup(function(e)
                                      {
        if (/\D/g.test(this.value))
        {
          // Filter non-digits from input value.
          this.value = this.value.replace(/\D/g, '');
        }
      });
        $("#sltCountry").on("change", function(event) { 
          var sltCountry = $(this).val();
          var form_data = new FormData(); 
          form_data.append('sltCountry', sltCountry);
          country_upload(form_data);
        } );
        $('.submit_btn').click(function(){
            //alert("dsf1");
          error = false;
      var phoneno = /^\d{10}$/;  
      var descerr = /^[a-z0-9\- . @\s]+$/i;  

          var regex = /[0-9]|\./;
          var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          $('form.regform').find('.team_require').each(function(){
           // alert($(this).attr('id'));
            if(!$(this).val()){
              error = true;
              jQuery('.error').html('All (*) fields are required.');
              return false;
            } else {
             jQuery('.error').html('');
           }
           if(!jQuery('#email').val()){
             error = true;
             jQuery('.error').html('All (*) fields are required.'); 
             return false; 
           }
           else {
            if(!re.test(jQuery('#email').val())){
             error = true;
             jQuery('.error').html('Please enter a valid email address');
             return false;
           }else {
             jQuery('.error').html('');
           }
         }
         if(!jQuery('#phone').val()){
           error = true;
           jQuery('.error').html('All (*) fields are required.');  
           return false;
         }
         else {
      if(!document.form.phone.value.match(phoneno))  
        {  
           error = true;
           jQuery('.error').html('Please enter 10 numbers only');
           return false; 
        }  
       
      else {
           jQuery('.error').html('');
         }
       }

      if(!jQuery('#desc').val()){
           error = true;
           jQuery('.error').html('All (*) fields are required.');  
           return false;
         }
         else {
      if(!document.form.desc.value.match(descerr))  
        {  
           error = true;
           jQuery('.error').html('Please enter only letters, numbers, or (@ , . , -) only');
           return false; 
        }  
       
      else {
           jQuery('.error').html('');
         }
       }

      });
          //var sltCountry = $('#sltCountry').val();
          var sltTimeZone = $('#sltTimeZone').val();
          var datetimepicker3 = $('#datetimepicker3').val();
          var name = $('#name').val();
          var email = $('#email').val();
          var phone = $('#phone').val();
          var desc = $('#desc').val();

          var form_data = new FormData();                  
          //form_data.append('sltCountry', sltCountry);
          form_data.append('sltTimeZone', sltTimeZone);
          form_data.append('datetimepicker3', datetimepicker3);
          form_data.append('name', name);
          form_data.append('email', email);
          form_data.append('phone', phone);
          form_data.append('desc', desc);
      //alert(form_data);
      if(error)
        return false;
      post_upload(form_data);
        });
    });
</script>
<div class="modal fade requstpopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Thank You for providing us your schedule!</h4>
      </div>
      <div class="modal-body">
        <p>We will get in touch with you as per the date and time indicated by you.</p>
        <div style="color:#f2a803; padding-top:15px;">Cheers!!<br/>
Team Webguruz</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<?php if ( presscore_is_content_visible() ): ?>

 <div id="content" class="content" role="main">


   <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

          <?php //echo $rfc;

          ?>

          <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main" style="padding:20px 0px;">
              <div class="entry-content page-content-area container">
                <div class="schedule-head"><h2>Schedule A Call</h2></div>
                <div class="schedule-section">
                  <font></font><form name="form" class="regform" action="" method ="get">
                  
                    <fieldset id="first">
                      <?php 
                       // $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$_SERVER['REMOTE_ADDR']); 
                        ini_set('max_execution_time', 500); 
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
                       /*  print_r($ipInfo);*/
                        $ipInfo1 = json_decode($ipInfo);

                        $timezone = $ipInfo1->timezone;
                        $rows = $wpdb->get_results( "SELECT * FROM timezonesdb group by utc" );
$time_zone= array('Europe/London'=>'UK Time ( UTC + 0.00 )','Asia/Kolkata'=>'India IST ( UTC + 5.30 )','Australia/Perth'=>' Australia - Perth ( UTC +08:00 )','Australia/Adelaide'=>'Australia - Adelaide ( UTC +09:30 )','Australia/Sydney'=>'Australia – Sydney NSW ( UTC +09:30 )','US/Mountain'=>'USA Mountain Standard Time MST ( UTC +09:30 ','US/Central'=>'USA Central Standard Time CST ( UTC +09:30 )','US/Pacific'=>'USA Pacific Standard Time PST ( UTC +09:30 )');
                      ?>
                      <select class="textInput2 team_require" id="sltTimeZone" name="sltTimeZone" tabindex="-1">
  <?php

                      foreach($time_zone as $key=>$value) {
                        echo strpos($key, $timezone);
                       ?>
  
                        <option <?php if ($key == $timezone){ echo "selected='selected'";} ?> value="<?php echo $key; ?>"><?php echo $value; ?> </option>
                      <?php
                      } 
                      ?>
                      </select>
                      <h2 class="title">Select Date Time</h2>
                      <input type="text" id="datetimepicker3" name="Datetime" class="team_require"/>
                      <!--input type="button" name="previous" class="pre_btn" value="Previous" /-->
                      <!--input type="button" name="next" class="next_btn" value="Next" /-->
                    </fieldset>
                    <fieldset>
                      <h2 class="title">Personal Details</h2>
                      <input type="text" class="text_field team_require" name="name" id="name" placeholder="Your Name *" /><br/>
                      <input type="email" class="text_field team_require" name="email" id="email" placeholder="Your Email *" /><br/>
                      <input type="text" class="text_field team_require" name="phone" id="phone" placeholder="Phone *" minlength="10" maxlength="10" /><br/>                      
                      <textarea name="desc" id="desc" class="team_require" maxlength="500" placeholder="Description *" onkeyup="countChar()"></textarea><p id="charNum"></p><br/>
                      <div class="error"></div>
                      <progress id="progress_s" value="0" style="display:none;"></progress><br/>
                      <input type="button" class="pre_btn" value="Previous" />
                      <input type="button" class="submit_btn" id="submit_btn" value="Submit"/>
                    </fieldset>
                  </form>
                  <?php //get_template_part( 'inc/emp', 'none' ); ?>
                </div>
              </div>
            </main>
            <!-- .site-main --> 
          </div>
          <!-- .content-area --> 
          <?php //the_content(); ?>

        <?php endwhile; ?>

      <?php else : ?>

      <?php get_template_part( 'no-results', 'page' ); ?>

    <?php endif; ?>

  </div><!-- #content -->

  <?php do_action('presscore_after_content'); ?>

<?php endif; // if content visible ?>
<script src="<?php echo  $urlDir; ?>/custom/jquery/multi_step_form.js"></script>
<script src="<?php echo  $urlDir; ?>/custom/jquery/jquery.datetimepicker.full.js"></script>
<script>
jQuery(document).ready(function($){
  //$('.next_btn').click(function(){
    $('#datetimepicker3').datetimepicker({
     inline:true,
     defaultDate: new Date(),
     minDate: 0,
     formatTime:'h:i a',
     onGenerate: myfunction,
     onSelectTime: timefuntion,
     onSelectDate: datefuntion
   });
  //});
  $('.pre_btn').click(function(){
    $('#datetimepicker3').datetimepicker({
     inline:true,
     defaultDate: new Date(),
     minDate: 0,
     formatTime:'h:i a',
     onGenerate: myfunction,
     onSelectTime: timefuntion,
     onSelectDate: datefuntion
   });
  });


function myfunction() {
 $('.xdsoft_calendar .xdsoft_current').append('<span class="greencircle"></span>');
}
function timefuntion() {
 $('.xdsoft_calendar').addClass("green");
$(this).parent().next().fadeIn('slow');
	$(this).parent().css({'display':'none'});

	$('.active').next().addClass('active');
}
function datefuntion() {
 $('.xdsoft_calendar').removeClass("green");
}
});
function post_upload(data) {
  var progressBar = document.getElementById("progress_s");
  var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", ajax_url+'?action=schedule_form', true);
  if (xhr.upload) {
    xhr.upload.onprogress = function(e) {
      if (e.lengthComputable) {
        progressBar.max = e.total;
        progressBar.value = e.loaded;
        //display.innerText = Math.floor((e.loaded / e.total) * 100) + '%';
      }
    }
    xhr.upload.onloadstart = function(e) {
     jQuery(progressBar).show();
      //jQuery("#closebar").show();
      progressBar.value = 0;
      //display.innerText = '0%';
    }
    xhr.upload.onloadend = function(e) {
      //progressBar.value = e.loaded;
      jQuery(progressBar).hide();
      //jQuery("#closebar").hide();
    }
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        response=JSON.parse(this.responseText);
        if(response.status == 'success'){
                                console.log(response);
                                jQuery('.regform').find("input[type=text], input[type=email], textarea").val("");
                                jQuery('#sltTimeZone,#datetimepicker3','#name','#email','#phone','#desc').val('');
                                jQuery(".requstpopup").modal('show');
                                window.setTimeout('location.reload()', 3000);


                                
                              }
                            } 
                          };

                        }
                        xhr.send(data);
                      }
//============country ===
function country_upload(data) {
  var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
  var xhr = new XMLHttpRequest();
  xhr.open("POST", ajax_url+'?action=country_form', true);
  if (xhr.upload) {
    xhr.upload.onprogress = function(e) {
      if (e.lengthComputable) {
        //progressBar.max = e.total;
       // progressBar.value = e.loaded;
        //display.innerText = Math.floor((e.loaded / e.total) * 100) + '%';
      }
    }
    xhr.upload.onloadstart = function(e) {
       //jQuery(progressBar).show();
      //jQuery("#closebar").show();
      //progressBar.value = 0;
      //display.innerText = '0%';
    }
    xhr.upload.onloadend = function(e) {
      //progressBar.value = e.loaded;
      //jQuery(progressBar).hide();
      //jQuery("#closebar").hide();
    }
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
           // response=JSON.parse(this.responseText);
           jQuery('#sltTimeZone').html(this.responseText);
         } 
       };

     }
     xhr.send(data);
   }
   
   </script>
   <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/custom/js/bootstrap.min.css" >
<script src="<?php bloginfo('template_url'); ?>/custom/js/bootstrap.min.js" ></script>
   <?php get_footer(); ?>

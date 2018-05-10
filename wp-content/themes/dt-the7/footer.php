<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the <div class="wf-container wf-clearfix"> and all content after
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( presscore_is_content_visible() ): ?>

			</div><!-- .wf-container -->
		</div><!-- .wf-wrap -->
	</div><!-- #main -->

	<?php
    	if ( presscore_config()->get( 'template.footer.background.slideout_mode' ) ) {
    		echo '</div>';
    	}

    	do_action( 'presscore_after_main_container' );
    	?>

    <?php endif; // presscore_is_content_visible ?>

    	<a href="#" class="scroll-top" ></a>
      <?php if(!is_page_template('special-offers.php')){ ?>
    	<div class="getstarted">
          <?php if ( is_active_sidebar( 'sidebar_6' ) ) : ?>
          		<div class="footer-getstarted"><?php dynamic_sidebar( 'sidebar_6' ); ?></div>
          <?php endif; ?>
    </div>

    <div class="featured">
          <?php if ( is_active_sidebar( 'sidebar_7' ) ) : ?>
          		<div class="featured-client"><?php dynamic_sidebar( 'sidebar_7' ); ?></div>
          <?php endif; ?>
    </div>
    <?php } ?>
    <div class="custom-footer">
      <div class="wf-wrap">
          <?php if ( is_active_sidebar( 'sidebar_3' ) ) : ?>
          		<div class="footer1"><?php dynamic_sidebar( 'sidebar_3' ); ?></div>
          <?php endif; ?>

          <?php if ( is_active_sidebar( 'sidebar_4' ) ) : ?>
          		<div class="footer1"><?php dynamic_sidebar( 'sidebar_4' ); ?></div>
          <?php endif; ?>

          <?php if ( is_active_sidebar( 'sidebar_5' ) ) : ?>
          		<div class="footer1"><?php dynamic_sidebar( 'sidebar_5' ); ?></div>
          <?php endif; ?>
      </div>
      <div style="clear:both"></div>

          <div class="custom-footer-bot">
          <div class="wf-wrap">
          <div class="bottom-menu">
          <?php
          if ( has_nav_menu( 'primary' ) ) {
               wp_nav_menu( array( 'theme_location' => 'bottom' ) );
          } ?>
          </div>

          <div class="copy">Copyright @ 2017 Webguruz Technologies Private Limited</div>
          </div>
          <div style="clear:both"></div>
          </div>
      </div>

    </div><!-- #page -->

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/57c82ca90e2ec4134ce497fd/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>

    <div id="dialog-message" title="Thank-You !">
        <span class="ui-state-default"><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 0 0;"></span></span>
        <div style="margin-left: 23px;">
            </div>
    </div>
    <div id="dialog-message-call" title="Thank-You !">
        <span class="ui-state-default"><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 0 0;"></span></span>
        <div style="margin-left: 23px;">
            </div>
    </div>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-darkness/jquery-ui.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script type="text/javascript">
        jQuery( ".condes" ).keyup(function() {

          var val = jQuery(this).val();
                      var len = val.length;

                    
                      if (len <= 200) {
                      /*    alert(jQuery(this).parents('span').html())*/
                      jQuery(this).parents('span').next('.charNum').text(200 - len+' characters remaining.').css('color','#EDA100');
                      }
                      else if(len > 200){
                      var n=val.substring(0, 200);
                      jQuery(this).val(n);
                     
                       }

                      if(/^[a-zA-Z0-9- ]*$/.test(val) == false){
                        jQuery(this).parents('span').next('.charNum').text('Only alphanumeric characters are allowd').css('color','red');
                        jQuery(this).parents('#commentform').find('.ripple').css('pointer-events','none');
                  
                  }
                  if(/^[a-zA-Z0-9- ]*$/.test(val) == true){
                       jQuery(this).parents('#commentform').find('.ripple').css('pointer-events','visible');
                  }

                     
        });

          

          WebFontConfig = {
            google: { families: [ 'Noto+Serif:400,400italic,700,700italic' ] }
          };
          (function() {
            var wf = document.createElement('script');
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
          })();
          jQuery(document).ready(function($){
              $('#hearaboutus').each(function (index, element) {
        $(this).parent()
            .after()
            .append("<div class='scrollableList'><div class='selectedOption'></div><ul></ul></div>");

        $(element).each(function (idx, elm) {
            $('option', elm).each(function (id, el) {
                $('.scrollableList ul:last').append('<li>' + el.text + '</li>');
            });
            $('.scrollableList ul').hide();
            $('.makeMeUl').children('div.selectedOption').text("How Did You Hear About Us");
        });
        $('.scrollableList:last').children('div.selectedOption').text("How Did You Hear About Us");
    });

    $('.selectedOption').on('click', function () {
        $(this).next('ul').slideToggle(200);
        $('.selectedOption').not(this).next('ul').hide();
    });

    $('.scrollableList ul li').on('click', function () {
        var selectedLI = $(this).text();
        $(this).parent().prev('.selectedOption').text(selectedLI);
        $(this).parent('ul').hide();
       $('#hearaboutus').val($(this).parent().prev('.selectedOption').text());
    });

    $('.scrollableList').show();
    $('#hearaboutus').hide();
         });

  </script>

<?php wp_footer(); ?>
<script>
jQuery(document).ready(function($){
var shareLinks = $('.social-sharing').find('a');
  shareLinks.on('click', function(e) { 
    var el = $(this),
        popup = el.attr('class').replace('-','_'),
        link = el.attr('href'),
        w = 700,
        h = 400;

 if (popup) {
      e.preventDefault();
      window.open(link, popup, 'width=' + w + ', height=' + h);
    }
});
});
 
</script>
</body>
</html>

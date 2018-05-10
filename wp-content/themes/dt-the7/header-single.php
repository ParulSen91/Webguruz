<?php
/**
 * The Header for single posts.
 *
 * @package the7
 * @since 1.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {



	exit; // Exit if accessed directly

}
?><!DOCTYPE html>



<!--[if lt IE 10 ]>



<html <?php language_attributes(); ?> class="old-ie no-js">



<![endif]-->



<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->



<html <?php language_attributes(); ?> class="no-js">



<!--<![endif]-->



<head>



	<meta charset="<?php bloginfo( 'charset' ); ?>" />
<style>
#leadinModal-104993 .leadin-button-primary {
  background: #f2a803 none repeat scroll 0 0 !important;
  color: #ffffff !important;
}
</style>


	<?php if ( presscore_responsive() ) : ?>



	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<meta name="dc.language" content="en_US" />
<meta content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" http-equiv="Content-Type" />
<!-- <meta http-equiv="Content-Security-Policy" content="self; img-src;"> -->
	<?php endif; ?>



     <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/js"></script-->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/js"></script>


  <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/custom-jquery.js"></script>

	<link rel="profile" href="https://gmpg.org/xfn/11" />



    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">



    <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">  



    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet"> 

    <link rel="author" href="https://plus.google.com/+WebguruzIn"/>

    <link rel="publisher" href="https://plus.google.com/+WebguruzIn"/>



	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />



	<?php wp_head(); ?>
<script>



jQuery(function($){





var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");







	$('a[data-modal-id]').click(function(e) {



		e.preventDefault();



    $("body").append(appendthis);



    $(".modal-overlay").fadeTo(500, 0.7);



    //$(".js-modalbox").fadeIn(500);



		var modalBox = $(this).attr('data-modal-id');



		$('#'+modalBox).fadeIn($(this).data());



	});  

      

$(".js-modal-close, .modal-overlay").click(function() {



    $(".modal-box, .modal-overlay").fadeOut(500, function() {



        $(".modal-overlay").remove();



    });



 



});



 



$(window).resize(function() {



    $(".modal-box").css({



        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,



        left: ($(window).width() - $(".modal-box").outerWidth()) / 3



    });



});



 



$(window).resize();



 



});



</script>







<style>



#default{



height: 450px;



}



</style>
<link rel="apple-touch-icon" href="https://www.webguruz.in/wp-content/uploads/2017/06/apple-touch-icon.png"/>
<?php if ( is_singular() ) { ?>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<?php } ?>
<script type="text/javascript">
    /*(function(p,u,s,h){
        p._pcq=p._pcq||[];
        p._pcq.push(['_currentTime',Date.now()]);
        s=u.createElement('script');
        s.type='text/javascript';
        s.async=true;
        s.src='https://cdn.pushcrew.com/js/56ca40faebae75a991f0cb2ff9459cb7.js';
        h=u.getElementsByTagName('script')[0];
        h.parentNode.insertBefore(s,h);
    })(window,document);*/
</script>
</head>



<body onload="initialize()"  <?php body_class(); ?>>



<?php



do_action( 'presscore_body_top' );







$config = presscore_config();



?>







<div id="page"<?php if ( 'boxed' == $config->get( 'template.layout' ) ) echo ' class="boxed"'; ?>>



	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'the7mk2' ); ?></a>



<?php



if ( apply_filters( 'presscore_show_header', true ) ) {



	presscore_get_template_part( 'theme', 'header/header', str_replace( '_', '-', $config->get( 'header.layout' ) ) );



	presscore_get_template_part( 'theme', 'header/mobile-header' );



}







if ( presscore_is_content_visible() && $config->get( 'template.footer.background.slideout_mode' ) ) {



	echo '<div class="page-inner">';



}
if(is_front_page() || is_home() ){
?>
    <!--script type="text/javascript">
    jQuery(document).ready(function($){
       
           $("#promocode").dialog({
                                            modal: true,
                                            closeOnEscape: false,
                                            autoOpen: true,
                                            
                                            width: '600px',
                                            show: { effect: "blind", width: '500px', duration: 800, top: '400px'}
                                        });
    });</script>
         
			 <div id="promocode" class="offerHome">
            <a href="https://www.webguruz.in/special-offers/?promo=NEWYEAR40"><img src="<?php echo home_url(); ?>/wp-content/uploads/2017/12/new-year40.jpg" width="100%" alt="offers" /></a>      

			</div-->
<?php
}
?>
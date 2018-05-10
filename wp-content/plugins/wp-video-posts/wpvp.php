<?php
/*
Plugin Name: WP Video Posts
Plugin URI: http://cmstactics.com
Description: WP Video Posts creates a custom post for uploaded videos. You can upload videos of different formats (FLV, F4V, MP4, AVI, MOV, 3GP and WMV) and the plugin will convert it to MP4 and play it using Flowplayer.  
Version: 3.5.1
Author: Alex Rayan, cmstactics
Author URI: http://cmstactics.com
License: GPLv2 or later
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

require( dirname(__FILE__) . '/classes/wpvp-widgets-class.php');
require( dirname(__FILE__) . '/classes/wpvp-core-class.php');
require( dirname(__FILE__) . '/classes/wpvp-helper-class.php');
if(!class_exists('WPVPMediaEncoder')):
/*
Main WPVPMediaEncoder Class
*/
class WPVPMediaEncoder{
	/**
	* @var string WPVPMediaEncoder version
	*/
	public $version = '3.5.1';
	public static function init(){
		$class = __CLASS__;
		new $class;
	}
	/**
	* The main loader
	* $uses WPVPMediaEncoder::includes() Include required files
	*/
	public function __construct(){
		$this->setup_actions();
	}
	/**
	*Setup the default hooks and actions
	*@access private
	*/
	private function setup_actions(){
		add_action('widgets_init', create_function('', 'register_widget("WPVideosForPostsWidget");'));
		if(is_admin()){
			add_action('admin_menu',array(&$this,'wpvp_options_page'));
		}
		add_action('init',array(&$this,'wpvp_init_functions'));
		add_action('wp_enqueue_scripts',array(&$this,'wpvp_enqueue_scripts'));
		add_action('wp_footer', array(&$this,'wpvp_footer'), 100);
		add_action('add_attachment', array(&$this,'wpvp_encode'),1);
		add_action('publish_videos',array(&$this,'wpvp_add_code_meta'),20,1);
		add_action('draft_videos',array(&$this,'wpvp_add_code_meta'),20,1);
		add_action('pending_videos',array(&$this,'wpvp_add_code_meta'),20,1);
		add_action('the_content',array(&$this,'wpvp_insert_edit_link_into_video_post'),10,1);
		add_filter('media_send_to_editor',array(&$this,'wpvp_insert_shortcode_into_post'),10,3);
		add_filter('upload_mimes',array(&$this,'wpvp_add_video_formats_support'),10,1);
		add_filter('attachment_fields_to_save',array(&$this,'wpvp_attachment_save'),10,1);
		add_filter('attachment_fields_to_edit',array(&$this,'wpvp_attachment_edit'),10,1);
		add_shortcode('wpvp_flowplayer',array(&$this,'wpvp_register_shortcode'));
		add_shortcode('wpvp_player',array(&$this,'wpvp_register_shortcode'));
		add_shortcode('wpvp_embed',array(&$this,'wpvp_register_embed_shortcode'));
		add_shortcode('wpvp_upload_video',array(&$this,'wpvp_register_front_uploader_shortcode'));
		add_shortcode('wpvp_edit_video',array(&$this,'wpvp_register_front_editor_shortcode'));
		//Only call the published notification email function if the option is set to yes
		$wpvp_published_notification = get_option('wpvp_published_notification','no');
		if($wpvp_published_notification == 'yes') {
	        add_action('draft_to_publish',array(&$this,'wpvp_draft_to_publish_notification'),20,1);
	        add_action('pending_to_publish',array(&$this,'wpvp_draft_to_publish_notification'),20,1);
		}
		$wpvp_main_loop_alter = get_option('wpvp_main_loop_alter','yes');
		if('no' != $wpvp_main_loop_alter && $wpvp_main_loop_alter){
			add_action('pre_get_posts',array(&$this,'wpvp_get_custom_video_posts'),1);
		}
		$wpvp_clean_url = get_option('wpvp_clean_url',false);
		if($wpvp_clean_url){
			add_action('pre_get_posts',array(&$this,'wpvp_parse_request_query'),10,1);
			add_filter( 'post_type_link', array(&$this,'wpvp_remove_slug'), 10, 3 );
		}
		add_action( 'admin_enqueue_scripts', array(&$this,'wpvp_admin_scripts_enqueue'));
		add_action('wp_ajax_wpvp_check_ffmpeg',array(&$this,'wpvp_check_ffmpeg_callback'));
		add_action('wp_ajax_wpvp_process_update',array(&$this,'wpvp_process_update'));
		add_action('wp_ajax_nopriv_wpvp_process_update',array(&$this,'wpvp_process_update'));
		add_action('wp_ajax_wpvp_process_files',array(&$this,'wpvp_process_files'));
                add_action('wp_ajax_wpvp_process_image',array(&$this,'wpvp_process_image'));
		add_action('wp_ajax_wpvp_process_form',array(&$this,'wpvp_process_form'));

                add_action('wp_ajax_wpvp_temp_image',array(&$this,'wpvp_temp_image'));
                add_action('wp_ajax_nopriv_wpvp_temp_image',array(&$this,'wpvp_temp_image'));
		$wpvp_allow_guest = (get_option('wpvp_allow_guest','no')=='yes') ? true : false;
		if($wpvp_allow_guest){
			add_action('wp_ajax_nopriv_wpvp_process_files',array(&$this,'wpvp_process_files'));
                        add_action('wp_ajax_nopriv_wpvp_process_image',array(&$this,'wpvp_process_image'));
			add_action('wp_ajax_nopriv_wpvp_process_form',array(&$this,'wpvp_process_form'));
		}
               //custom
               add_shortcode('wpvp_clint_testimonial',array(&$this,'wpvp_clint_testimonial_shortcode'));
               add_shortcode('wpvp_c_service_testimonial',array(&$this,'wpvp_clint_testimonial_service_shortcode'));//in service page
	}
	/**
	*Run init functions
	*@access public
	**/
	public function wpvp_init_functions(){
		//check for ffmpeg
		if(get_option('wpvp_ffmpeg_exists')===FALSE){
			$helper = new WPVP_Helper();
			$helper->wpvp_command_exists_check('ffmpeg',true);
		}
		//register post types;
		self::wpvp_register_videos_post_type();
	}
	/**
	*Register menu options on admin_menu action hook
	*access public
	*/
	public function wpvp_options_page(){
        add_options_page(
			'WP Video Posts',
			'WP Video Posts',
			'manage_options',
			'wp-video-posts',
			array(&$this,'wpvp_options')
		);
    }
	/**
	*Register tabs
	*access public
	*/
    public function wpvp_options(){
		global $pagenow;
		if ( isset ( $_GET['tab'] ) )
			$this->wpvp_define_tabs($_GET['tab']);
		else
			$this->wpvp_define_tabs('general');
		switch($_GET['tab']){
			case 'front-end-uploader':
				include('options/wpvp-uploader-options.php');
				break;
			case 'front-end-editor':
				include('options/wpvp-editor-options.php');
				break;
			case 'shortcodes':
				include('options/wpvp-shortcodes-options.php');
				break;
			case 'general':
			default:
				include('options/wpvp-options.php');
				break;
		}
    }
	/**
	*Define tabs pages
	*access private
	*/
	private function wpvp_define_tabs($current = 'general'){
        $tabs = array('general'=>'General','front-end-uploader'=>'Front End Uploader','front-end-editor'=>'Front End Editor','shortcodes'=>'Shortcodes Reminder');
        echo '<div id="icon-options-general" class="icon32"><br></div>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $current ) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='?page=wp-video-posts&tab=$tab'>$name</a>";
        }
        echo '</h2>';
    }
	/**
	*Enqueue admin scripts on the plugin's page
	*@access public
	*/
	public function wpvp_admin_scripts_enqueue($hook){
		if( 'options-general.php' != $hook && (!isset($_GET['page']) || $_GET['page']!='wp-video-posts'))
			return;
		wp_enqueue_style( 'wpvp_admin_style', plugin_dir_url( __FILE__ ) . 'css/admin.css' );
		$obj_vars = array('admin_ajax'=>admin_url( 'admin-ajax.php' ));
		wp_enqueue_script('admin_js',plugin_dir_url(__FILE__).'js/admin.js');
		wp_localize_script('admin_js','wpvp_vars',$obj_vars);
	}
	/*
    **register custom post type: videos on init action hook
    *@access static
    */
    static function wpvp_register_videos_post_type(){
		$labels = array(
			'name' => _x('Testimonials', 'post type general name'),
                        'all_items' => _x('Client Testimonials', 'post type general name'),
			'singular_name' => _x('Client Testimonials Item', 'post type singular name'),
			'add_new' => _x('Add Client Testimonials', 'video item'),
			'add_new_item' => __('Add New Testimonials Item'),
			'edit_item' => __('Edit Testimonials Item'),
			'new_item' => __('New Testimonials Item'),
			'view_item' => __('View Testimonials Item'),
			'search_items' => __('Search Testimonials'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => plugins_url('/images/', __FILE__) . 'videos_menu_icon.png',
			'rewrite' => array('slug'=>'videos'),
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail','comments','author','custom-fields'),
			//'taxonomies'=>array('post_tag')
		);
		register_post_type( 'videos' , $args );
		//register_taxonomy_for_object_type('category','videos');
              // Initialize New Taxonomy Labels
	      $labels = array(
		'name' => _x( 'Category', 'taxonomy general name' ),
		'singular_name' => _x( 'Category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Types' ),
		'all_items' => __( 'All Categorys' ),
		'parent_item' => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item' => __( 'Edit Category' ),
		'update_item' => __( 'Update Category' ),
		'add_new_item' => __( 'Add New Category' ),
		'new_item_name' => __( 'New Category Name' ),
	  );
		// Custom taxonomy for Project Tags
		register_taxonomy('ct_testimonials',array('videos'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
                'show_in_menu'=> true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'ct_testimonials' ),
	  ));
    }
    /**
    *Flush rewrite rules on plugin reactivation
    *@access static
    **/
    static function wpvp_create_video_post_flush_rewrite_rules(){
        self::wpvp_register_videos_post_type();
        self::wpvp_flush_rewrite_rules();
    }
	/**
    *Flush rewrite rules
    *@access static
    **/
    static function wpvp_flush_rewrite_rules(){
		flush_rewrite_rules();
    }
	/*
	*Enqueue scripts on wp_enqueue_scripts action hook
	*@action public
	*/
	public function wpvp_enqueue_scripts(){
		$wpvp_player = get_option('wpvp_player','flowplayer') ? get_option('wpvp_player','flowplayer') : 'flowplayer';
		if($wpvp_player=='flowplayer'){
	        //wp_enqueue_script('wpvp_flowplayer',plugins_url('/inc/flowplayer/', __FILE__).'flowplayer-3.2.10.min.js',array('jquery'),NULL);
			//wp_enqueue_script( 'wpvp_flowplayer_js',plugins_url('/inc/flowplayer/',__FILE__).'wpvp_flowplayer.js',array('jquery','wpvp_flowplayer'),NULL);
			$swf_loc = plugins_url('/inc/flowplayer/', __FILE__).'flowplayer-3.2.11.swf';
			$vars_to_pass = array('swf'=>$swf_loc);
			wp_localize_script('wpvp_flowplayer_js','object_name',$vars_to_pass);
		} else if($wpvp_player=='videojs'){
			//version 4.10.1
			wp_enqueue_script('wpvp_videojs',plugins_url('/inc/video-js/', __FILE__).'video.js',array('jquery'),NULL);
			wp_enqueue_script('wpvp_videojs_yt',plugins_url('/inc/video-js/', __FILE__).'vjs.youtube.js',array('wpvp_videojs'),NULL);
			wp_enqueue_style('wpvp_videojs_css',plugins_url('/inc/video-js/', __FILE__).'video-js.min.css');
		}
        wp_enqueue_script( 'wpvp_front_end_js',plugins_url('/js/', __FILE__).'wpvp-front-end.js',array('jquery'),NULL );
		$upload_size = WPVP_Helper::wpvp_max_upload_size();
	    $video_limit =  WPVP_Helper::wpvp_return_bytes($upload_size);
		$wpvp_vars = array('upload_size'=>$upload_size,'file_upload_limit'=>$video_limit,'wpvp_ajax'=>admin_url( 'admin-ajax.php' ));
		wp_localize_script('wpvp_front_end_js','wpvp_vars',$wpvp_vars);
        wp_enqueue_style('wpvp_widget',plugins_url('/css/', __FILE__).'style.css');
	}
	/**
	*Footer scripts
	*@access public
	**/
	public function wpvp_footer(){
		$wpvp_player = get_option('wpvp_player','flowplayer') ? get_option('wpvp_player','flowplayer') : 'flowplayer';
		if($wpvp_player=='videojs'){
			$swf_loc = plugins_url('/inc/video-js/', __FILE__).'video-js.swf';
			?>
			<script>
			  videojs.options.flash.swf = "<?php echo $swf_loc;?>";
			</script>	
<?php
		}
	}
	/**
	*add support for videos of defined extensions on upload_mimes filter hook
	*@access public
	*/
	public function wpvp_add_video_formats_support($existing_mimes){
		$existing_mimes['mov'] = 'video/quicktime';
		$existing_mimes['avi'] = 'video/avi';
		$existing_mimes['wmv|wvx|wm|wmx'] = 'video/x-ms-wmv';
		$existing_mimes['3gp|3gpp|3gpp2|3g2'] = 'video/3gpp';
		return $existing_mimes;
	}
	/**
	*Process encoding on add_attachment action hook
	*@access public
	*/
	public function wpvp_encode($ID){
		$postID = intval($_REQUEST['post_id']);
		if($postID){
		$helper = new WPVP_Helper();
			$options = $helper->wpvp_get_full_options();
			$newEncode = new WPVP_Encode_Media($options);
			$encode_video = $newEncode->wpvp_encode($ID);
		}
		return;
	}
	/**
	*send email on post status change to publish to the post author on draft_to_publish and pending_to_publish action hook
	*@access public
	*/
	public function wpvp_draft_to_publish_notification($postObj) {
		global $post;
		if($postObj->post_type== 'videos'){
			$post_content = $postObj->post_content;
			$post_author_id = $postObj->post_author;
			$userObj = get_userdata($post_author_id);
			$post_author_email = $userObj->user_email;
			$post_author_login = $userObj->user_login;
			$post_thumb = explode('splash=',$post_content);
			$post_thumb = explode(']',$post_thumb[1]);
			$post_thumb = $post_thumb[0];
			$post_permalink = get_permalink($postObj->ID);
			$admin = array($post_author_email);
			if(strlen($postObj->post_title) > 15) {
					$postObj->post_title = substr($postObj->post_title, 0, 15) . '...';
			}
			$subject = get_bloginfo('name').': "'.$postObj->post_title.'" has been published';
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$message = 'Your video has been reviewed by '.get_bloginfo('name').' and it has been published. You can view your video by accessing this link, "<a href="'.$post_permalink.'">'.$postObj->post_title.'</a>".<br /><br /><a href="'.$post_permalink.'"><img src="'.$post_thumb.'" width="250px" height="142px" /><br />'.$postObj->post_title.'</a>';
			$message .= '<br /><br />Regards,<br />'.get_bloginfo('name');
			$send_publish_notice = wp_mail($admin, $subject, $message, $headers);
		}
	}
	/*
	**Update post data on attachment_fields_to_save filter hook
	*@access public
	*/
	public function wpvp_attachment_save($data) {
		$helper = new WPVP_Helper();
		if( $helper->is_video($data['post_mime_type'])=='video' ) {
			$parent_post = $data['post_parent'];
			$newdata = array (
				'ID'            => $parent_post,
				'post_excerpt'  => $data['post_content'],
				'post_title'    => $data['post_title'],
				'tags_input'    => $data['post_excerpt']
			);
			wp_update_post( $newdata );
			return $data;
		}
		else {
			return $data;
		}
	}
	/*
	**Edit attachment data on attachment_fields_to_edit filter hook
	*@access public
	*/
	public function wpvp_attachment_edit($data){
		$helper = new WPVP_Helper();
		$ext = $helper->guess_file_type($data['post_title']['value']);
		if ($ext=='flv') {
			$data['post_excerpt']['label'] = 'Tags';
			$data['post_excerpt']['helps'] = 'Separate tags with commas';
			return $data;
		}
		else {
			return $data;
		}
	}
	/**
	*insert short code into post on media_send_to_editor filter hook
	*@access public
	*/
	public function wpvp_insert_shortcode_into_post ($html, $id, $attachment) {
		$postID = intval($_REQUEST['post_id']);
		
		$postObj = get_post($postID);
		
		$postContent = $html;
		if($postObj->post_type=='videos'){
			$helper = new WPVP_Helper();
			$options = $helper->wpvp_get_full_options();
			$newVideo = new WPVP_Encode_Media($options);
			$postContent = $newVideo->wpvp_insert_video_into_post($postContent, $id, $attachment);
		}
		return $postContent;
	}
	/**
	*function to add code to the post meta and update on post update if needed on publish_videos custom post type action hook
	*@access public
	*/
	public function wpvp_add_code_meta($id){
		$helper = new WPVP_Helper();
		$helper->wpvp_video_code_add_meta($id); 
	}
	/**
	*insert video edit link into video post (only if admin or post author) on the_content action hook
	*@access public
	*/
	public function wpvp_insert_edit_link_into_video_post($content){
		global $post;
		$postID = $post->ID;
		$post_type = get_post_type($postID);
		$post_status = get_post_status($postID);
		$editPageID = get_option('wpvp_editor_page');
		$curr_user = wp_get_current_user();
		$user_id = $curr_user->ID;
		//get post Object based on post id
		$post_author = $post->post_author;
		if(current_user_can('administrator')||$user_id==$post_author){
			$permalink = get_permalink($editPageID);
			if(is_single() && $post_type=='videos' && $post_status=='publish' && $editPageID && $permalink != ""){
				$content='<div class="wpvp_edit_video_link"><a href="'.$permalink.'?video='.$postID.'">Edit Video</a></div>'.$content;
			}
		}
		return $content;
	}
	/**
	*Alter main Wordpress query for latest posts, categories, feed, tags to display videos custom post type
	*on pre_get_posts filter
	*@access public
	*/
	public function wpvp_get_custom_video_posts($query){
		if((is_home()&&$query->is_main_query())||is_feed()||(is_category()&&$query->is_main_query())||(is_tag()&&$query->is_main_query())||(is_front_page()&&$query->is_main_query())||(is_author()&&$query->is_main_query())){
			$query->set( 'post_type', array( 'post','videos'));
		}
		return $query;
	}
          /***COSTOM Jai REGISTER SHORT CODES ***/
	/**
	* Register shortcode for flowplayer videos
	* @access public
	*/
	public function wpvp_clint_testimonial_shortcode(){
		$videos_t_loop = new WP_Query(
		array(
			'post_type'	=> 'videos',
			'order_by'	=> 'title'
			)
		);

	$output = '<div class="gs_testimonial_container">';
		if ( $videos_t_loop->have_posts() ) {

			$output .= '<ul data-autoslide="3000" class="testimonials slider-content ts-cont" >';

			while ( $videos_t_loop->have_posts() ) {
				$videos_t_loop->the_post();
				$meta = get_post_meta( get_the_id() );
                                $contents = get_the_content();

				$videos_testimonial_id = get_post_thumbnail_id();
				$videos_testimonial_url = wp_get_attachment_image_src($videos_testimonial_id, array(86,86),true);

				$videos_testimonial = $videos_testimonial_url[0];
				$videos_testimonial_alt = get_post_meta($videos_testimonial_id,'_wp_attachment_image_alt',true);

				$output .= '<li class="ts-slide ts-loaded" style="left: 0px;"><article><div class="gs_testimonial_single">';
				$output .= '<div class="testimonial-box">';
				$output .= '<div class="box-content"><p>'. substr($contents , 0, 300) .'</p></div>';
				$output .= '<h3 class="box-title">'. get_the_title() .'</h3>';
				$output .= '<div class="box-image"><img src="'. $meta['image_url'][0] .'" alt="'. $videos_testimonial_alt .'"></div>';

				if($meta['wpvp_company'][0]){

					$output .= '<div class="box-companyname"><span>Company Name:</span> '. $meta['wpvp_company'][0] .'</div>';

				}

				if($meta['wpvp_position'][0]){

					$output .= '<div class="box-designation"><span>Designation:</span> '. $meta['wpvp_position'][0] .'</div>';
				}
				$output .= '</div></div></article></li>';
			}

			$output .= '</ul>';
			//$output .= '<div class="center cycle-nav"><a id="prev">Prev</a><a id="next">Next</a></div>';
			//$output .= '<div class="cycle-pager" id="custom-pager"></div>';

		} else {
			$output .= "No Testimonial Added!";
		}
		wp_reset_postdata();
		wp_reset_query();

	$output .= '</div>';

	return $output;
	}
        //========================clint_testimonial_service
        public function wpvp_clint_testimonial_service_shortcode($atts){
                extract(shortcode_atts(array(
			'category'=>'157',
                        'taxonomy'=>'ct_testimonials'
		),$atts));
		$cts_t_loop = new WP_Query(
		array(
			'post_type'	=> 'videos',
			'order_by'	=> 'title',
                        'tax_query' => array( array('taxonomy' => $taxonomy,'field' => 'id','terms' => $category),)
		)
		);

	
		if ( $cts_t_loop->have_posts() ) {

			$output .= '<section class="testimonial-item testimonial-item-slider clint_testimonial"><ul data-autoslide="3000" class="testimonials slider-content ts-cont psWithBullets" style="transform: translate3d(0px, 0px, 0px); visibility: visible; transition: all 439.116ms cubic-bezier(0.445, 0.05, 0.55, 0.95) 0s;">';

			while ( $cts_t_loop->have_posts() ) {
				$cts_t_loop->the_post();
				$meta = get_post_meta( get_the_id() );

				$cts_testimonial_id = get_post_thumbnail_id();
				$cts_testimonial_url = wp_get_attachment_image_src($cts_testimonial_id, array(60,60),true);
                                $image_url = get_post_meta(get_the_ID(),'image_url', true); 

				$cts_testimonial = $cts_testimonial_url[0];
				$cts_testimonial_alt = get_post_meta($cts_testimonial_id,'_wp_attachment_image_alt',true);
                                $output .= '<li class="ts-slide ts-loaded" style="left: 0px;"><article>';
	                        $output .= '<div class="testimonial-content"><p>'. substr(get_the_content(), 0, 200) .'</p><span class="cp-load-after-post"></span></div>';
	                       $output .= '<div class="testimonial-vcard"><div class="wf-td"><span class="alignleft"><img width="60" height="60" alt="" title="client" src="'. $meta['image_url'][0] .'" class="lazy-load preload-me is-loaded" sizes="60px" srcset="'. $meta['image_url'][0] .'"></span></div><div class="wf-td"><span class="text-primary">'. get_the_title() .'</span><br></div></div>';
                                $output .= '</article></li>';
				
			}

			$output .= '</ul></section>';
			

		} else {
			$output .= "No Testimonial Added!";
		}
		wp_reset_postdata();
		wp_reset_query();

	return $output;
	}
	/*** REGISTER SHORT CODES ***/
	/**
	* Register shortcode for flowplayer videos
	* @access public
	*/
	public function wpvp_register_shortcode($atts){
		extract(shortcode_atts(array(
			'src'=>'',
			'width'=>'640',
			'height'=>'360',
			'splash'=>'',
			'autoplay'=>null,
			'audio'=>null
		),$atts));
		$wpvp_player = get_option('wpvp_player','flowplayer') ? get_option('wpvp_player','flowplayer') : 'flowplayer';
		if($wpvp_player=='flowplayer'){
			$player_code = '<a href="'.$src.'" class="myPlayer" style="display:block;width:'.$width.'px;height:'.$height.'px;margin:10px auto"><img width="'.$width.'" height="'.$height.'" src="'.$splash.'" alt="" /></a>';
		} else if($wpvp_player=='videojs'){
			if(is_null($autoplay))
				$autoplay = get_option('wpvp_autoplay',false) ? get_option('wpvp_autoplay',false) : false;
			if(is_null($audio))
				$audio = get_option('wpvp_audio',100) ? get_option('wpvp_audio',100) : 100;
			$splash_check = get_option('wpvp_splash',false) ? get_option('wpvp_splash',false) : false;
			if($autoplay)
				$ap = 'autoplay ';
			else
				$ap = '';
			if($splash_check)
				$sp = 'poster="'.$splash.'"';
			else
				$sp = '';
			$player_code = '<video id="wpvp_videojs_'.time().'" '.$ap.'class="video-js vjs-default-skin" controls preload="none" data-audio="'.$audio.'" width="'.$width.'" height="'.$height.'"'.$sp.' data-setup="{}">
				<source src="'.$src.'" type="video/mp4" />
			</video>';
		}
		return $player_code;
	}
	/**
	* register shortcode to embed videos via video codes
	*@access public 
	*/
	public function wpvp_register_embed_shortcode($atts){
		//require_once( dirname(__FILE__) . '/wpvp-core-class.php');
		extract(shortcode_atts(array(
			'video_code'=>'',
			'width'=>'560',
			'height'=>'315',
			'type'=>''
		),$atts));
		$helper = new WPVP_Helper();
		$options = $helper->wpvp_get_full_options();
		$newDisplay = new WPVP_Encode_Media($options);
		$embedCode = $newDisplay->wpvp_video_embed($video_code, $width, $height, $type);
		return $embedCode;
	}
	/**
	*register shortcode for the front end uploader
	*@access public
	*/
	public function wpvp_register_front_uploader_shortcode($atts){
		extract(shortcode_atts(array(
		),$atts));
		$helper = new WPVP_Helper();
		$options = $helper->wpvp_get_full_options();
		$newMedia = new WPVP_Encode_Media($options);
		$uploader = $newMedia->wpvp_front_video_uploader();
		return $uploader;
	}
	/**
	*register shortcode for the front end editor
	*@access public
	*/
	public function wpvp_register_front_editor_shortcode($atts){
		extract(shortcode_atts(array(
		),$atts));
		$helper = new WPVP_Helper();
		$options = $helper->wpvp_get_full_options();
		$newMedia = new WPVP_Encode_Media($options);
		$editor = $newMedia->wpvp_front_video_editor();
		return $editor;
	}
	/**
	*Remove slug "videos" from our custom post type
	*@access public
	**/
	public function wpvp_remove_slug($post_link, $post, $leavename){
		if ( ! in_array( $post->post_type, array( 'videos' ) ) || 'publish' != $post->post_status )
			return $post_link;
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link ); 
		return $post_link;
	}
	/**
	*Parse request query
	*@access public
	**/
	public function wpvp_parse_request_query($query){
		// Check for the main query
		if ( ! $query->is_main_query() )
			return; 
		if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) )
			return;

		if ( ! empty( $query->query['name'] ) )
			$query->set( 'post_type', array( 'post', 'videos', 'page' ) );
	}
	/**
	*Ajax check for ffmpeg and update options
	*@access public
	**/
	public function wpvp_check_ffmpeg_callback(){
		$helper = new WPVP_Helper();
		$ffmpeg = $helper->wpvp_command_exists_check('ffmpeg',true);
		if($ffmpeg)
			echo '<span class="true">FOUND</span>';
		else
			echo '<span class="false">NOT FOUND</span>';
		die();
	}
	/**
	*Process video post update
	*@access public
	**/
	public function wpvp_process_update(){
		$data = array();
		$formD = isset($_POST['formData']) ? $_POST['formData'] : false;
		if(!$formD)
			die();
		parse_str($formD,$data);
		$post_id = isset($data['wpvp_video_id']) ? (int)$data['wpvp_video_id'] : 0;
		if(!$post_id)
			die();
		$response = array('status'=>'error');
		if ( wp_verify_nonce( $data['wpvp_video_update_field'], 'wpvp_video_update' ) ) {
			$title = isset($data['wpvp_title']) ? $data['wpvp_title'] : 0;
			$desc = isset($data['wpvp_desc']) ? $data['wpvp_desc'] : 0;
			$desc_status = (int)get_option('wpvp_uploader_desc',false);
			if(!$title||(!$desc&&!$desc_status)){
				if(!$title)
					$response['msg'][] = __('Title is required.');
				if(!$desc&&!$desc_status)
					$response['msg'][] = __('Description is required.');
			} else {
				$post_cat = isset($data['wpvp_category']) ? $data['wpvp_category'] : 0;
				$tags_list = isset($data['wpvp_tags']) ? $data['wpvp_tags'] : 0;
				if(!empty($tags_list)){
					$tags = explode(',',strtolower($tags_list));
				}
				$video_data = get_post_meta($post_id,'wpvp_fp_code',true);
				$video_shortcode = '';
				if(!empty($video_data)){
					$v_data = json_decode(stripslashes($video_data),true);
					$src = isset($v_data['src']) ? $v_data['src'] : false;
					$splash = isset($v_data['splash']) ? $v_data['splash'] : false;
					$width = isset($v_data['width']) ? $v_data['width'] : false;
					$height = isset($v_data['height']) ? $v_data['height'] : false;
					if($src)
						$video_shortcode= '[wpvp_player src="'.$src.'"';
					if($splash)
						$video_shortcode.= ' splash="'.$splash.'"';
					if($width)
						$video_shortcode.= ' width="'.$width.'"';
					if($height)
						$video_shortcode.= ' height="'.$height.'"';
					if($src)
						$video_shortcode.= ']';
				}
				$post = array(
					'ID'=>$post_id,
					'post_title'=>$title,
					'post_type'=>'videos',
					'post_content'=>$desc
				);
				$update_post = wp_update_post($post);
				if($update_post){
					wp_set_post_categories($update_post,array($post_cat));
					if($tags_list!=''){
						wp_set_object_terms($update_post,$tags,'post_tag');
					} else {
						wp_set_object_terms($update_post,'','post_tag');
					}
					$response['status'] = 'success';
					$response['msg'][] = '<span style="color:green;">'.__('Video record is successfully updated.').'</span>';
				} else {
					$response['msg'][] = '<span style="color:red;">'.__('Something went wrong.').'</span>';
				}
			}
		} else {
			$response['msg'][] = __('Invalid referrer set.');
		}
		echo json_encode($response);
		die();
	}
	/**
	*Ajax process files upload from the front end
	*@access public
	**/
	public function wpvp_process_files(){
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		$helper = new WPVP_Helper(); 
		$options = $helper->wpvp_get_full_options();
		$newMedia = new WPVP_Encode_Media($options);
		$upload_size_unit = WPVP_Helper::wpvp_max_upload_size();
		$error = false;
		$errors = array();
		$video_limit = WPVP_Helper::wpvp_return_bytes($upload_size_unit);
		$default_ext = array('video/mp4','video/x-flv','video/wmv','video/webm','video/flv');
		$video_types = get_option('wpvp_allowed_extensions',$default_ext) ? get_option('wpvp_allowed_extensions',$default_ext) : $default_ext;
		$ext_list = implode(', ',$video_types);
		$post_id = isset($_POST['postid']) ? (int)$_POST['postid'] : 0;
		if(!$post_id){
			echo json_encode(array('status'=>'error','errors'=>array(0=>__('Invalid post id.'))));
			die();
		}
		foreach($_FILES as $file){
			if(in_array($file['type'],$video_types)){
				if($file['size']>$video_limit){
					$error = true;
					$errors[] = __('The file exceeds the maximum upload size.');
				} else {
					//process file
					$override = array( 'test_form' => FALSE );
					$uploaded_file = wp_handle_upload($file, $override);
					if($uploaded_file){
						$attachment = array(
							'post_title' => $file['name'],
							'post_content' => '',
							'post_type' => 'attachment',
							'post_parent' => 0,
							'post_mime_type' => $file['type'],
							'guid' => $uploaded_file['url']
						);
						$id = wp_insert_attachment($attachment,$uploaded_file[ 'file' ]);
						wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $uploaded_file['file'] ) );
						$encodedVideoPost = $newMedia->wpvp_encode($id,$post_id);
						if(!$encodedVideoPost){
							$errors[] = __('There was an error creating a video post.');
						} else{
							$post_url = get_permalink($post_id);
							$msg= __('Successfully uploaded. ');
							//$msg.= __('If you are not redirected in 5 seconds, go to ').'<a href="'.$post_url.'">'.__('uploaded video').'</a>.';
						}
                                               update_post_meta($post_id,'video_url',$uploaded_file['url']);
						$data=array();
						$data['post_id'] = $post_id;
						$data['html'] = $msg;
						$data['url'] = $post_url;
						$data['status'] = 'success';
					} else {
						$error = true;
						$errors[] = $uploaded_file['error'];
					}
					unset($file);
				}
			} else {
				$error = true;
				$errors[] = __('The file extension is not supported: '.$file['type'].'. Supported extensions are: '.$ext_list.'.');
			}
		}
		if($error){
			$data = array('status' => 'error', 'errors' => $errors);
			//delete tmp post if video errored out
			wp_delete_post( $post_id, true );
		} else {
			// send email notification to an admin
			//$admin = get_bloginfo('admin_email');
			//$subject = get_bloginfo('name').': New Video Submitted for Review';
			//$message = __('New video uploaded for review on ').get_bloginfo('name').'. '.__('Moderate the ').'<a href="'.get_bloginfo('url').'/?post_type=videos&p='.$post_id.'">'.__('uploaded video').'</a>.';
			//$send_draft_notice = wp_mail($admin, $subject, $message);
		}
		echo json_encode($data);
		die();
	}
        /**
	*Ajax process image upload from the front end
	*@access public
	**/
	public function wpvp_process_image(){
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$helper = new WPVP_Helper(); 
		$options = $helper->wpvp_get_full_options();
		$newMedia = new WPVP_Encode_Media($options);
		$upload_size_unit = WPVP_Helper::wpvp_max_upload_size();
		$error = false;
		$errors = array();
		$video_limit = WPVP_Helper::wpvp_return_bytes($upload_size_unit);
		$default_ext = array('video/mp4','video/x-flv','video/wmv','video/webm','video/flv');
                $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png','image/bmp');
		$video_types = get_option('wpvp_allowed_extensions',$default_ext) ? get_option('wpvp_allowed_extensions',$default_ext) : $default_ext;
		$ext_list = implode(', ',$allowed_file_types);
		$post_id = isset($_POST['postid']) ? (int)$_POST['postid'] : 0;
		if(!$post_id){
			echo json_encode(array('status'=>'error','errors'=>array(0=>__('Invalid post id.'))));
			die();
		}
		foreach($_FILES as $file){
			  if(in_array($file['type'],$allowed_file_types)){
				if($file['size']>$video_limit){
					$error = true;
					$errors[] = __('The file exceeds the maximum upload size.');
				} else {
					//process file
					$override = array( 'test_form' => FALSE );
					$uploaded_file = wp_handle_upload($file, $override);
					if($uploaded_file){
						$attachment = array(
							'post_title' => $file['name'],
							'post_content' => '',
							'post_type' => 'attachment',
							'post_parent' => 0,
							'post_mime_type' => $file['type'],
							'guid' => $uploaded_file['url']
						);
						$id = wp_insert_attachment($attachment,$uploaded_file[ 'file' ]);
						wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $uploaded_file['file'] ) );
                                                set_post_thumbnail( $post_id, (int) $id );
						$encodedVideoPost = $newMedia->wpvp_encode($id,$post_id);
						if(!$id){
							$errors[] = __('There was an error creating a video post.');
						} else{
							$post_url = get_permalink($post_id);
							$msg= __('Successfully uploaded. ');
							//$msg.= __('If you are not redirected in 5 seconds, go to ').'<a href="'.$post_url.'">'.__('uploaded video').'</a>.';
						}
                                                //set_post_thumbnail( $post_id, $id );
                                                update_post_meta($post_id,'image_url',$uploaded_file['url']);
                                              
						$data=array();
						$data['post_id'] = $post_id;
						$data['html'] = $msg;
						$data['url'] = $uploaded_file['url'];
                                                $data['img'] = 'done';
						$data['status'] = 'success';
					} else {
						$error = true;
						$errors[] = $uploaded_file['error'];
					}
					unset($file);
				}
                     }
                        else {
                            $error = true;
				$errors[] = __('The file extension is not supported. Supported extensions are: jpg,png,jpeg,gif,bmp.');
                            }
			
		}
		if($error){
			$data = array('status' => 'error', 'errors' => $errors);
			//delete tmp post if video errored out
			wp_delete_post( $post_id, true );
		} else {
			// send email notification to an admin
$post = get_post($post_id); //assuming $id has been initialized
setup_postdata($post);
//array('wpvp_position' => $position,'wpvp_company' => $company, 'wpvp_email' => $email)
// display the post here
$title = get_the_title($post_id);
$desc = get_the_content();
$position = get_post_meta($post_id,'wpvp_position',true);
$company = get_post_meta($post_id,'wpvp_company',true);
$email = get_post_meta($post_id,'wpvp_email',true);
$videou = get_post_meta($post_id,'video_url',true);
$img = get_post_meta($post_id,'image_url',true);
$postt_url = get_permalink($post_id);
$url = admin_url('post.php?post='.$post_id.'&action=edit');
                   $admin = get_bloginfo('admin_email');
			$subject = get_bloginfo('name').': New Testimonials Submitted';
                        $headers = 'From: Webguruz <info@webguruz.in>' . "\r\n";
			$message = __('');
  $message .='<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#dbdbdb">
  <tr>
    <td width="100%"><table width="600" border="0" cellspacing="0" cellpadding="0" style="background:url(http://webguruz.in/wp-content/uploads/email/header-bg.jpg) center no-repeat; padding:5px; background-size:cover;">
  <tr>
    <td><table width="408" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="208"><a href="http://webguruz.in/"><img src="http://webguruz.in/wp-content/uploads/email/logo.png" alt="" /></a></td>
  </tr>
</table>
</td>
    <td align="right" width="100%">
    <table width="192" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="https://www.facebook.com/webguruztechnologies/"><img src="http://webguruz.in/wp-content/uploads/email/fb.png" alt="" /></a></td>
    <td><a href="https://www.linkedin.com/company/webguru-technologies-pvt.-ltd.?trk=company_logo"><img src="http://webguruz.in/wp-content/uploads/email/in.png" alt="" /></a></td>
    <td><a href="https://twitter.com/Webguruz"><img src="http://webguruz.in/wp-content/uploads/email/twitter.png" alt="" /></a></td>
    <td><a href="https://plus.google.com/+WebguruzIn/"><img src="http://webguruz.in/wp-content/uploads/email/g-plus.png" alt="" /></a></td>
    <td><a href="https://www.youtube.com/channel/UC-xaX1FJWj40ED-cTm2Lq6w"><img src="http://webguruz.in/wp-content/uploads/email/youtube.png" alt="" /></a></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:40px; text-align:left; font-weight:bold; color:#1fb5ac;">Hello Admin</td>
  </tr>
<tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; padding-top:15px">Here are the Testimonial details :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    <div style="width:600px; float:left;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Name: </strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$title.'</td>
  </tr>
  <tr>
    <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Position:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$position.'</td>
  </tr>
  <tr>
    <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Company:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac;">'.$company.'</td>
  </tr>
  <tr>
    <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Email:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$email.'</td>
  </tr>
  <tr>
    <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Description:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac;">'.substr($desc, 0, 100).'.</td>
  </tr>
<tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:center; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;"><a href="'.$url.'" target="_blank">Click here to view</a></td>
  </tr>
<tr>
    <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left;background:#e8e8e8; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Approval:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;background:#e8e8e8;  border-right:1px solid #acacac;"><a href="'.$url.'" target="_blank">Approval</a></td>
  </tr>
</table>
</div>
    </td>
  </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; color:#1fb5ac;">Thanks</td>
    </tr>
    <tr>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; color:#1fb5ac; padding:5px 0px;">Webguruz Admin</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
  </tr>
 <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000" style="padding:30px 0;" >
  <tr>
    <td>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center"><h2 style="color:#fff; text-transform:uppercase; font-size:18px; font-family:Arial, Helvetica, sans-serif;">Corporate Head Office-India:</h2></td>
  </tr>
  <tr>
    <td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">IT-C2, Dibon Building, 4th Floor, Sector 67, Mohali,<br /> India. Pin:160062</p></td>
  </tr>
  <tr>
    <td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">Phone: +91 172 4666 711-712<br />
    Mobile: 9592016444
</p></td>
  </tr>
  <tr>
    <td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">E-mail: <a href="mailto:info@webguruz.co.uk" style="color:#a0a0a0; text-decoration:none;">info@webguruz.co.uk</a><br />
Website: <a href="http://webguruz.in/" target="_blank" style="color:#a0a0a0; font-family:Arial, Helvetica, sans-serif; text-decoration:none;">www.webguruz.co.uk</a> </p></td>
  </tr>
   <tr>
    <td align="center">
    <table width="224" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:center"><a href="https://www.facebook.com/webguruztechnologies/"><img src="http://webguruz.in/wp-content/uploads/email/fb.png" alt="" /></a></td>
    <td style="text-align:center"><a href="https://www.linkedin.com/company/webguru-technologies-pvt.-ltd.?trk=company_logo"><img src="http://webguruz.in/wp-content/uploads/email/in.png" alt="" /></a></td>
    <td style="text-align:center"><a href="https://twitter.com/Webguruz"><img src="http://webguruz.in/wp-content/uploads/email/twitter.png" alt="" /></a></td>
    <td style="text-align:center"><a href="https://plus.google.com/+WebguruzIn/"><img src="http://webguruz.in/wp-content/uploads/email/g-plus.png" alt="" /></a></td>
    <td style="text-align:center"><a href="https://www.youtube.com/channel/UC-xaX1FJWj40ED-cTm2Lq6w"><img src="http://webguruz.in/wp-content/uploads/email/youtube.png" alt="" /></a></td>
  </tr>
</table>

    </td>
  </tr>
</table>
    </td>
  </tr>
</table>

</td>
  </tr>
<tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="center" id="backgroundTable"><table width="570" border="0" cellspacing="0" cellpadding="0" class="devicewidth">
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh with two branches, one in Croydon U.K,  and the second branch in india.<br /><br />
</p></td>
  </tr>
  <tr>
    <td style="padding:15px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Copyright © 2016  Webguruz Technologies Private Limited. All rights reserved.</p></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
</table>';
$message_u .='<div style="margin:0; padding:0;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#dbdbdb">
  <tr>
    <td width="100%"><table width="600" border="0" cellspacing="0" cellpadding="0" style="background:url(http://webguruz.in/wp-content/uploads/email/header-bg.jpg) center no-repeat; padding:5px; background-size:cover;">
  <tr>
    <td><table width="408" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="208"><a href="http://webguruz.in/"><img src="http://webguruz.in/wp-content/uploads/email/logo.png" alt="" /></a></td>
  </tr>
</table>
</td>
    <td align="right" width="100%">
    <table width="192" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="https://www.facebook.com/webguruztechnologies/"><img src="http://webguruz.in/wp-content/uploads/email/fb.png" alt="" /></a></td>
    <td><a href="https://www.linkedin.com/company/webguru-technologies-pvt.-ltd.?trk=company_logo"><img src="http://webguruz.in/wp-content/uploads/email/in.png" alt="" /></a></td>
    <td><a href="https://twitter.com/Webguruz"><img src="http://webguruz.in/wp-content/uploads/email/twitter.png" alt="" /></a></td>
    <td><a href="https://plus.google.com/+WebguruzIn/"><img src="http://webguruz.in/wp-content/uploads/email/g-plus.png" alt="" /></a></td>
    <td><a href="https://www.youtube.com/channel/UC-xaX1FJWj40ED-cTm2Lq6w"><img src="http://webguruz.in/wp-content/uploads/email/youtube.png" alt="" /></a></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
  <tr>
    <td align="center"><table width="570" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#fff" style="padding:20px;">
  <tr>
    <td><h1 style="font-size:24px; color:#000000; text-align:left; font-family:Arial, Helvetica, sans-serif; padding:0">Dear '.$title.'</h1></td>
  </tr>
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thank you for your feedback
.</p></td>
  </tr>
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thank you for taking the time to provide us with your valuable feedback.  We strive to provide our clients with excellent care and we take your comments to heart.</p></td>
  </tr>
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">As always, we appreciate your confidence and trust in us.</p></td>
  </tr>
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thanks for choosing us</p></td>
  </tr>
  <tr>
    <td style="color:#f2a702; font-size:18px; font-family:Arial, Helvetica, sans-serif;">Cheers!!<br />
Team Webguruz</td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000" style="padding:30px 0;" >
  <tr>
    <td>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center"><h2 style="color:#fff; text-transform:uppercase; font-size:18px; font-family:Arial, Helvetica, sans-serif;">Corporate Head Office-India:</h2></td>
  </tr>
  <tr>
    <td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">IT-C2, Dibon Building, 4th Floor, Sector 67, Mohali,<br /> India. Pin:160062</p></td>
  </tr>
  <tr>
    <td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">Phone: +91 172 4666 711-712<br />
    Mobile: 9592016444
</p></td>
  </tr>
  <tr>
    <td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">E-mail: <a href="mailto:info@webguruz.co.uk" style="color:#a0a0a0; text-decoration:none;">info@webguruz.co.uk</a><br />
Website: <a href="http://webguruz.in/" target="_blank" style="color:#a0a0a0; font-family:Arial, Helvetica, sans-serif; text-decoration:none;">www.webguruz.co.uk</a> </p></td>
  </tr>
   <tr>
    <td align="center">
    <table width="224" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="text-align:center"><a href="https://www.facebook.com/webguruztechnologies/"><img src="http://webguruz.in/wp-content/uploads/email/fb.png" alt="" /></a></td>
    <td style="text-align:center"><a href="https://www.linkedin.com/company/webguru-technologies-pvt.-ltd.?trk=company_logo"><img src="http://webguruz.in/wp-content/uploads/email/in.png" alt="" /></a></td>
    <td style="text-align:center"><a href="https://twitter.com/Webguruz"><img src="http://webguruz.in/wp-content/uploads/email/twitter.png" alt="" /></a></td>
    <td style="text-align:center"><a href="https://plus.google.com/+WebguruzIn/"><img src="http://webguruz.in/wp-content/uploads/email/g-plus.png" alt="" /></a></td>
    <td style="text-align:center"><a href="https://www.youtube.com/channel/UC-xaX1FJWj40ED-cTm2Lq6w"><img src="http://webguruz.in/wp-content/uploads/email/youtube.png" alt="" /></a></td>
  </tr>
</table>
    </td>
  </tr>
</table>
    </td>
  </tr>
</table>

</td>
  </tr>
  <tr>
    <td width="100%" align="center" id="backgroundTable"><table width="570" border="0" cellspacing="0" cellpadding="0" class="devicewidth">
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh with two branches, one in Croydon U.K,  and the second branch in india.<br /> </p></td>
  </tr>
  <tr>
    <td style="padding:15px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Copyright © 2016  Webguruz Technologies Private Limited. All rights reserved.</p></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
</table>
</div>';
			$send_draft_notice = wp_mail('info@webguruz.in', $subject, $message, $headers);
                        $send_draft_notice = wp_mail($email, $subject, $message_u, $headers);
			
		}
		echo json_encode($data);
		die();
	}
/**
	*Ajax process image upload from the front end
	*@access public
	**/
	public function wpvp_temp_image(){
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$helper = new WPVP_Helper(); 
		$options = $helper->wpvp_get_full_options();
		$newMedia = new WPVP_Encode_Media($options);
		$upload_size_unit = WPVP_Helper::wpvp_max_upload_size();
		$error = false;
		$errors = array();
		$video_limit = WPVP_Helper::wpvp_return_bytes($upload_size_unit);
		$default_ext = array('video/mp4','video/x-flv','video/wmv','video/webm','video/flv');
                $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');
                $allowedExts = array("gif", "jpeg", "jpg", "png");
		$video_types = get_option('wpvp_allowed_extensions',$default_ext) ? get_option('wpvp_allowed_extensions',$default_ext) : $default_ext;
		$upType = isset($_POST['upType']) ? $_POST['upType'] : '';
		if($upType=='image'){$fileType=$allowed_file_types;$ext ='gif, jpeg, jpg, png';} else{$fileType=$video_types;$ext = 'mp4, x-flv, wmv, webm, flv';}
                $ext_list = implode(', ',$fileType);
                $extension = explode(".", $_FILES["file"]["name"]);
		foreach($_FILES as $file){ 
			if(in_array($file['type'],$fileType)){
				if($file['size']>$video_limit){
					$error = true;
					$errors = __('The file exceeds the maximum upload size.');
				} else {
					//process file
					        $data=array();
						$data['post_id'] = '';
						$data['html'] = $file['size'];
						$data['url'] = $file['name'];
						$data['status'] = 'success';
					unset($file);
				}
                        }
                        else {
                            $error = true;
				$errors = __('The file extension is not supported. Supported extensions are: '.$ext.'.');
                            }
			
		}
		if($error){
			$data = array('status' => 'error', 'errors' => $errors);
			//delete tmp post if video errored out
			wp_delete_post( $post_id, true );
		} else {
			// send email notification to an admin
			
		}
		echo json_encode($data);
		die();
	}
	/**
	*Ajax process form upload
	*@access public
	**/
	public function wpvp_process_form(){
		global $current_user, $wpdb;
		get_currentuserinfo();
		$user_id = $current_user->ID;
		$wpvp_allow_guest = get_option('wpvp_allow_guest','no') ? get_option('wpvp_allow_guest','no') : 'no';
		if($wpvp_allow_guest=='yes')
			$user_id = (int)get_option('wpvp_guest_userid');
		$data = array();
		parse_str($_POST['data'],$data);
		$helper = new WPVP_Helper();
		//$category = (int)$data['wpvp_category'];
  $title =$data['wpvp_title']; $position=$data['wpvp_position'];$company=$data['wpvp_company'];$email=$data['wpvp_email'];$desc=$data['wpvp_desc'];
 $sim_titles = "SELECT post_title FROM $wpdb->posts WHERE post_type = 'videos' AND post_title = '".$title."'";
			$sim_results = $wpdb->get_results($sim_titles);
             if($sim_results) {
            $response = array('status'=>'error','msg'=>__('Title is already exists'));
                  } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  $response = array('status'=>'error','msg'=>__('Please enter a valid email address'));
} else {
		if ( wp_verify_nonce( $data['wpvp_file_upload_field'], 'wpvp_file_upload' ) ) {
			$wpvp_post_status = get_option('wpvp_default_post_status','pending');
			$post = array(
				'comment_status' => 'open',
				'post_author' => $user_id,
				//'post_category' => array($category),
				'post_content' => $desc,
				'post_title' => $title,
				'post_type' => 'videos',
				'post_status' => $wpvp_post_status,
				//'tags_input' => $data['wpvp_tags'],
                                'meta_input' => array('wpvp_position' => $position,'wpvp_company' => $company, 'wpvp_email' => $email)
			);
			$post_id = wp_insert_post($post);
                        wp_set_object_terms($post_id,(int) $data['wpvp_category'], 'ct_testimonials');
			if(!is_wp_error($post_id)){
				$response = array('status'=>'success','post_id'=>$post_id);
                        
			} else {
				$response = array('status'=>'error','msg'=>$post_id->get_error_message());
			}
		} else {
			$response = array('status'=>'error','msg'=>__('Invalid referrer.'));
		}
            }
		echo json_encode($response);
		die();
	}
}
endif;
add_action('plugins_loaded',array('WPVPMediaEncoder','init'));
register_activation_hook( __FILE__, array('WPVPMediaEncoder', 'wpvp_create_video_post_flush_rewrite_rules' ) );
register_deactivation_hook( __FILE__, array('WPVPMediaEncoder', 'wpvp_flush_rewrite_rules' ) );
?>

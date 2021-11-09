<?php



// Framework functions

require_once( get_template_directory() . '/framework/get-mods.php' );

require_once( get_template_directory() . '/framework/framework-functions.php' );

require_once( get_template_directory() . '/framework/sanitize-data.php' );

require_once( get_template_directory() . '/framework/fonts.php' );

require_once( get_template_directory() . '/framework/typography.php' );

require_once( get_template_directory() . '/framework/accent-color.php' );

require_once( get_template_directory() . '/framework/customizer/customizer.php' );

require_once( get_template_directory() . '/framework/metabox-options.php' );

require_once( get_template_directory() . '/framework/widget-areas.php' );

require_once( get_template_directory() . '/framework/breadcrumbs.php' );

require_once( get_template_directory() . '/framework/plugins.php' );

require_once( get_template_directory() . '/framework/theme-woocommerce.php' );

require_once( get_template_directory() . '/framework/demo-install.php' );



// Visual Composer

if ( class_exists( 'Vc_Manager' ) ) {

	require_once( get_template_directory() . '/framework/visual-composer-config.php' );

	require_once( get_template_directory() . '/framework/visual-composer-custom-row.php' );

}



// Sets up theme defaults and registers support for various WordPress features.

add_action( 'after_setup_theme', 'bauer_theme_setup' );

function bauer_theme_setup() {

	// Make theme available for translation.

	load_theme_textdomain( 'bauer', get_template_directory() . '/languages' );



	// Add default posts and comments RSS feed links to head.

	add_theme_support( 'automatic-feed-links' );



	// Let WordPress manage the document title.

	add_theme_support( 'title-tag' );



	// Enable woocommerce support

	add_theme_support( 'woocommerce' );



	// Enable support for Post Thumbnails on posts and pages.

	add_theme_support( 'post-thumbnails' );

	add_image_size( 'bauer-post-standard', 770, 350, true );

	add_image_size( 'bauer-post-related', 558, 410, true );

	add_image_size( 'bauer-post-widget', 140, 140, true );



	// Register menus

	register_nav_menu( 'top', esc_html__( 'Top Menu', 'bauer' ) );

	register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'bauer' ) );

	register_nav_menu( 'about', esc_html__( 'About Menu', 'bauer' ) );

	register_nav_menu( 'service', esc_html__( 'Service Menu', 'bauer' ) );

	register_nav_menu( 'bottom', esc_html__( 'Bottom Menu', 'bauer' ) );

	register_nav_menu( 'onepage', esc_html__( 'OnePage Menu', 'bauer' ) );



	// Switch default core markup for search form, comment form, and comments to output valid HTML5.

	add_theme_support( 'html5', array(

		'search-form',

		'comment-form',

		'comment-list',

		'gallery',

		'caption',

	) );



	// Enable support for Post Formats.

	add_theme_support( 'post-formats', array(

		'image',

		'gallery',

		'video'

	) );



	/*

	 * This theme styles the visual editor to resemble the theme style,

	 * specifically font, colors, and column width.

 	 */

	add_editor_style( array( 'assets/css/editor-style.css' ) );

}



// Enqueues scripts and styles.

add_action( 'wp_enqueue_scripts', 'bauer_theme_scripts' );

function bauer_theme_scripts() {

	// Vendor Styles & Icons

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css', array(), '3.5.2' );

	wp_enqueue_style( 'animsition', get_template_directory_uri() . '/assets/css/animsition.css', array(), '4.0.1' );

	wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/css/slick.css', array(), '1.6.0' );

	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/fontawesome.css', array(), '5.0' );

	wp_enqueue_style( 'eleganticons', get_template_directory_uri() . '/assets/css/eleganticons.css', array(), '1.0.0' );

	wp_enqueue_style( 'basicui', get_template_directory_uri() . '/assets/css/basicui.css', array(), '1.0.0' );



	// Theme Style

	wp_enqueue_style( 'bauer-theme-style', get_stylesheet_uri(), array(), '1.0.0' );



	// Vendor Scripts

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/assets/js/html5shiv.js', array('jquery'), '3.7.3', true );

	wp_enqueue_script( 'respond', get_template_directory_uri() . '/assets/js/respond.js', array('jquery'), '1.3.0', true );

	wp_enqueue_script( 'matchmedia', get_template_directory_uri() . '/assets/js/matchmedia.js', array('jquery'), '1.0.0', true );

	wp_enqueue_script( 'easing', get_template_directory_uri() . '/assets/js/easing.js', array('jquery'), '1.3.0', true );

	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/assets/js/fitvids.js', array('jquery'), '1.1.0', true );

	wp_enqueue_script( 'animsition', get_template_directory_uri() . '/assets/js/animsition.js', array('jquery'), '4.0.1', true );

	wp_register_script( 'slick', get_template_directory_uri() . '/assets/js/slick.js', array('jquery'), '1.6.0', true );



	// Theme Script

	wp_enqueue_script( 'bauer-theme-script', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '1.0.0', true );



	// Comment JS

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )

		wp_enqueue_script( 'comment-reply' );

}



// Output custom CSS from Customizer

add_action( 'wp_enqueue_scripts', 'bauer_output_custom_color' );

function bauer_output_custom_color( $output = NULL ) {

	$output = apply_filters( 'bauer_custom_colors_css', $output );

    wp_add_inline_style( 'bauer-theme-style', $output );

}



// Registers a widget area.

add_action( 'widgets_init', 'bauer_sidebars_init' );

function bauer_sidebars_init() {

	// Sidebar for Blog

	register_sidebar( array(

		'name'          => esc_html__( 'Sidebar Blog', 'bauer' ),

		'id'            => 'sidebar-blog',

		'description'   => esc_html__( 'Add widgets here to appear in Sidebar Blog.', 'bauer' ),

		'before_widget' => '<div id="%1$s" class="widget %2$s">',

		'after_widget'  => '</div>',

		'before_title'  => '<h2 class="widget-title"><span>',

		'after_title'   => '</span></h2>'

	) );



	// Sidebar for Pages

	register_sidebar( array(

		'name'			=> esc_html__( 'Sidebar Page', 'bauer' ),

		'id'			=> 'sidebar-page',

		'description'	=> esc_html__( 'Add widgets here to appear in Sidebar Page', 'bauer' ),

		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',

		'after_widget'	=> '</div>',

		'before_title'	=> '<h2 class="widget-title"><span>',

		'after_title'	=> '</span></h2>'

	) );



	// Sidebar for Portfolio

	register_sidebar( array(

		'name'			=> esc_html__( 'Sidebar Portfolio', 'bauer' ),

		'id'			=> 'sidebar-portfolio',

		'description'	=> esc_html__( 'Add widgets here to appear in Sidebar Portfolio', 'bauer' ),

		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',

		'after_widget'	=> '</div>',

		'before_title'	=> '<h2 class="widget-title"><span>',

		'after_title'	=> '</span></h2>'

	) );



	// Sidebar for Shop

	register_sidebar( array(

		'name'			=> esc_html__( 'Sidebar Shop', 'bauer' ),

		'id'			=> 'sidebar-shop',

		'description'	=> esc_html__( 'Add widgets here to appear in Sidebar Shop', 'bauer' ),

		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',

		'after_widget'	=> '</div>',

		'before_title'	=> '<h2 class="widget-title"><span>',

		'after_title'	=> '</span></h2>'

	) );



	// 4 Sidebars for Footer

	register_sidebar( array(

		'name'			=> esc_html__( 'Sidebar Footer 1', 'bauer' ),

		'id'			=> 'sidebar-footer-1',

		'description'	=> esc_html__( 'Add widgets here to appear in Sidebar Footer 1', 'bauer' ),

		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',

		'after_widget'	=> '</div>',

		'before_title'	=> '<h2 class="widget-title"><span>',

		'after_title'	=> '</span></h2>'

	) );

	register_sidebar( array(

		'name'			=> esc_html__( 'Sidebar Footer 2', 'bauer' ),

		'id'			=> 'sidebar-footer-2',

		'description'	=> esc_html__( 'Add widgets here to appear in Sidebar Footer 2', 'bauer' ),

		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',

		'after_widget'	=> '</div>',

		'before_title'	=> '<h2 class="widget-title"><span>',

		'after_title'	=> '</span></h2>'

	) );

	register_sidebar( array(

		'name'			=> esc_html__( 'Sidebar Footer 3', 'bauer' ),

		'id'			=> 'sidebar-footer-3',

		'description'	=> esc_html__( 'Add widgets here to appear in Sidebar Footer 3', 'bauer' ),

		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',

		'after_widget'	=> '</div>',

		'before_title'	=> '<h2 class="widget-title"><span>',

		'after_title'	=> '</span></h2>'

	) );

	register_sidebar( array(

		'name'			=> esc_html__( 'Sidebar Footer 4', 'bauer' ),

		'id'			=> 'sidebar-footer-4',

		'description'	=> esc_html__( 'Add widgets here to appear in Sidebar Footer 4', 'bauer' ),

		'before_widget'	=> '<div id="%1$s" class="widget %2$s">',

		'after_widget'	=> '</div>',

		'before_title'	=> '<h2 class="widget-title"><span>',

		'after_title'	=> '</span></h2>'

	) );

}


//custom property/flats/blocks from yapisoft API

add_action('init', 'register_brewery_cpt');
add_action('init', 'register_yapi_projects_cpt');
add_action('init', 'register_yapi');

function register_brewery_cpt() {
	register_post_type( 'brewery', [
		'label' => 'Breweries',
		'public' => true,
		'capability_type' => 'post'

	] );
}

function register_yapi_projects_cpt() {
	register_post_type( 'yapi_project', [
		'label' => 'Yapi Projects',
		'public' => true,
		'capability_type' => 'post'

	] );
}

function register_yapi() {
	register_post_type( 'yproject', [
		'label' => 'Yapi Flats',
		'public' => true,
		'capability_type' => 'post'

	] );
}





//add cron to fetch from API so it doesnt have to be manually done 
if(! wp_next_scheduled( 'update_brewery_list' )) {
	wp_schedule_event( time(), 'weekly', 'get_breweries_from_api');
}

if(! wp_next_scheduled( 'update_token' )) {
	wp_schedule_event( time(), 'hourly', 'get_token_from_api');
}

if(! wp_next_scheduled( 'update_projects' )) {
	wp_schedule_event( time(), 'weekly', 'get_project_from_api');
}

if(! wp_next_scheduled( 'update_blocks' )) {
	wp_schedule_event( time(), 'weekly', 'get_block_from_api');
}

if(! wp_next_scheduled( 'update_flats' )) {
	wp_schedule_event( time(), 'weekly', 'get_flats_from_api');
}

//add action for admin_ajax
/**
 * No priv = if not logged in!
 * 
 */
add_action( 'wp_ajax_nopriv_get_breweries_from_api', 'get_breweries_from_api' );
add_action( 'wp_ajax_get_breweries_from_api', 'get_breweries_from_api' );

//get token
add_action( 'wp_ajax_nopriv_get_token_from_api', 'get_token_from_api' );
add_action( 'wp_ajax_get_token_from_api', 'get_token_from_api' );

//get project
add_action( 'wp_ajax_nopriv_get_project_from_api', 'get_project_from_api' );
add_action( 'wp_ajax_get_project_from_api', 'get_project_from_api' );

//get block
add_action( 'wp_ajax_nopriv_get_block_from_api', 'get_block_from_api' );
add_action( 'wp_ajax_get_block_from_api', 'get_block_from_api' );

//get flats
add_action( 'wp_ajax_nopriv_get_flats_from_apii', 'get_flats_from_api' );
add_action( 'wp_ajax_get_flats_from_api', 'get_flats_from_api' );

function get_token_from_api() {

	$token = "";
	$file = get_stylesheet_directory() . '/token.txt';

	$url = 'https://parvista.yapisoft.com/parvista/token/getToken';

	$body = [
		'secret'  => 'eUuJ660envloBCI84SN9doW5PtojDfG1',
	];
		 
	$body = wp_json_encode( $body );
	
	$options = [
		'body'        => $body,
		'headers'     => [
			'Content-Type' => 'application/json',
		],
		'blocking'    => true,
		'sslverify'   => false
	];

	$response = wp_remote_post(
		$url, $options
	);

	if ( is_wp_error( $response ) || ! is_array($response) || empty($response) ) {

		error_log( print_r( $response['body'], true ) );

	}

	$results = wp_remote_retrieve_body( $response );
	$results = json_decode($results,true);

	//put errors in file if we find
	file_put_contents($file, "Token: ".$results['token']."\n\n", FILE_APPEND);

	$token = $results['token'];

	return $token;
	

}

function get_project_from_api() {
	$file = get_stylesheet_directory(). '/projects.txt';

	$token = get_token_from_api();

	$url = 'https://parvista.yapisoft.com/parvista/api/projects';

	$body = [
		'token' => $token,
	];
	
	$body = wp_json_encode( $body );

	$options = [
		'body' => $body,
		'headers' => [
			'Content-Type' => 'application/json',
		],
		'blocking' => true,
		'sslverify' => false
	];

	$response = wp_remote_post( 
		$url, $options
	);

	if( is_wp_error( $response ) || ! is_array($response) || empty($response) ) {
		error_log(print_r( $response['body'], true));
		return false;
	}

	$results = wp_remote_retrieve_body( $response );
	$results = json_decode($results, true);

	// file_put_contents($file, "Content: ".$results['content'][0]['flat_interior_plans'][0]['flat_interior_plan_id']."\n\n", FILE_APPEND);
	file_put_contents($file, "Content: ".print_r( $results['content'], true)."\n\n", FILE_APPEND);

	$content = $results['content'];

	return $content;
}

function get_block_from_api() {
	$file = get_stylesheet_directory(). '/blocks.txt';

	$token = get_token_from_api();

	$project = get_project_from_api();

	$project_id = $project[0]['project_id'];

	$url = 'https://parvista.yapisoft.com/parvista/api/blocks';

	$body = [
		'token' => $token,
		'project_id' => $project_id
	];

	$body = wp_json_encode($body);

	$options = [
		'body' => $body,
		'headers' => [
			'Content-Type' => 'application/json',
		],
		'blocking' => true,
		'sslvrify' => false
	];

	$response = wp_remote_post( 
		$url, $options
	);

	if( is_wp_error( $response )  || ! is_array($response) || empty($response)) {
		error_log(print_r($responsep['body'], true));
		return false;
	}

	$results = wp_remote_retrieve_body( $response );
	$results = json_decode($results, true);

	file_put_contents($file, "Content: ".print_r($results['content'], true). "\n\n", FILE_APPEND);
	// file_put_contents($file, "Content: ".print_r($results['content'][0]['situation_plan'], true). "\n\n", FILE_APPEND);

	$content = $results['content'];

	return $content;
}

function get_flats_from_api() {

	$token = get_token_from_api();
	$block = get_block_from_api();
	
	$file = get_stylesheet_directory(). '/flats.txt';
	$files = get_stylesheet_directory(). '/flat_pages.txt';

	$fiesACF = get_stylesheet_directory(). '/ACF.txt';
	
	$project = get_project_from_api();
	
	$project_id = $project[0]['project_id'];
	$project_name = $project[0]['project_name'];
	$project_blocks = $project[0]['number_of_blocks'];
	$project_flats = $project[0]['number_of_flats'];
	
	$current_page = ( ! empty($_POST['current_page'])) ? $_POST['current_page'] : 1;
	
	$url = 'https://parvista.yapisoft.com/parvista/api/flats';
	
	$blocks = [];
	
	$blocks[] = $block;
	
	foreach($blocks[0] as $blocked){
	
		$body = [
			'token' => $token,
			'project_id' => $blocked['project_id'],
			'block_id' => $blocked['block_id']
		];
	
		$body = wp_json_encode( $body );
	
		$options = [
			'body' => $body,
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'blocking' => true,
			'sslverify' => false
		];
	
		$response = wp_remote_post( 
			$url, $options
		);
	
		if( is_wp_error( $response )  || ! is_array($response) || empty($response)) {
			error_log(print_r($response['body'], true));
			return false;
		}
	
		$results = wp_remote_retrieve_body( $response );
		$results = json_decode($results, true);
	
		file_put_contents($file, "Content: ".print_r($results['content'][0]['settlement_plan'], true). "\n\n", FILE_APPEND);
		// file_put_contents($file, "Content: ".print_r($results, true). "\n\n", FILE_APPEND);
		file_put_contents($file, "Project Name: ".print_r($project_name, true). "\n\n", FILE_APPEND);
		// file_put_contents($file, "Content: ".print_r($blocked['situation_plan'], true). "\n\n", FILE_APPEND);
	
		$get_flats = $results['content'];
	
		$flats = [];
	
		$flats[] = $get_flats;

		$projectsYapi = [];

		$projectsYapi[] = $project;

		// foreach( $projectsYapi[0] as $projectFillable ) {
		// 	$fillable1 = [
		// 		'field_618543d05c01e' => 'project_id',
		// 		'field_618543fc5c01f' => 'project_name',
		// 		'field_618544165c020' => 'project_blocks',
		// 		'field_618544a85c021' => 'project_flats',
		// 	];
		// }

		// $fillable2 = [
		// 	'field_618546bfcca51' => 'project_id',
		// 	'field_618546cccca52' => 'block_name',
		// 	'field_618546d5cca53' => 'number_of_flats',
		// 	'field_618546e3cca54' => 'project_id',
		// ];

		// $flats = (object) $flats1;
	
		foreach( $flats[0] as $flat ){
	
			$flat_slug = sanitize_title( $project_name.'-'.$flat['flat_id'] );
	
			//update data from api if new changes are made
	
			$existing_flat = get_page_by_path( $flat_slug, 'OBJECT', 'yproject' );
	
			//if it exist then change
			if($existing_flat === null) {
				$inserted_flat = wp_insert_post([
					'post_name' => $flat_slug,
					'post_title' => $flat_slug,
					'post_type' => 'yproject',
					'post_status' => 'publish'
	
				]);
	
				if(is_wp_error( $inserted_flat )){
					continue;
				}

				$fillable = [
					'field_618547bb845eb' => 'flat_id',
					'field_618547cd845ec' => 'block_id',
					'field_618547e4845ed' => 'project_id',
					'field_618547eb845ee' => 'flat_no',
					'field_618547f5845ef' => 'flat_price',
					'field_61854806845f0' => 'flat_floor',
					'field_61854811845f1' => 'gross_m2',
					'field_61854827845f2' => 'net_m2',
					'field_61854838845f3' => 'balcony_m2',
					'field_6185484c845f4' => 'garden_m2',
					'field_61854859845f5' => 'flat_type',
					'field_61854868845f6' => 'flat_direction',
					'field_61854873845f7' => 'flat_status',
				];

				// $fillable = array_merge( $fillable1, $fillable2, $fillable3 );
				
	
				//Add to AFC
				// $fillable = [
				// 	'field_618543d05c01e' => $project_id,
				// 	'field_618543fc5c01f' => $project_name,
				// 	'field_618544165c020' => $project_blocks,
				// 	'field_618544a85c021' => $project_flats,
				// 	// 'field_618545445c023' => 'flat_interior_plan_id',
				// 	// 'field_618545535c024' => 'flat_interior_plan_name',
				// 	// 'field_618545705c025' => 'interior_plan_image',
				// 	'field_618546bfcca51' => $blocked['project_id'],
				// 	'field_618546cccca52' =>$blocked['block_name'],
				// 	'field_618546d5cca53' => $blocked['number_of_flats'],
				// 	'field_618546e3cca54' => $blocked['project_id'],
				// 	// 'field_61854717cca56' => $blocked['situation_plan'][0]['image'],
				// 	'field_618547bb845eb' => $flat['flat_id'],
				// 	'field_618547cd845ec' => $flat['block_id'],
				// 	'field_618547e4845ed' => $flat['project_id'],
				// 	'field_618547eb845ee' => $flat['flat_no'],
				// 	'field_618547f5845ef' => $flat['flat_price'],
				// 	'field_61854806845f0' => $flat['flat_floor'],
				// 	'field_61854811845f1' => $flat['gross_m2'],
				// 	'field_61854827845f2' => $flat['net_m2'],
				// 	'field_61854838845f3' => $flat['balcony_m2'],
				// 	'field_6185484c845f4' => $flat['garden_m2'],
				// 	'field_61854859845f5' => $flat['flat_type'],
				// 	'field_61854868845f6' => $flat['flat_direction'],
				// 	'field_61854873845f7' => $flat['flat_status'],
				// 	// 'field_61854880845f8' => 'flat_interior_plan_ids',
				// 	// 'field_618548af845fa' => $flat['settlement_plan'][0]['settlement_plan_id'],
				// 	// 'field_618548c2845fb' => $flat['settlement_plan'][0]['settlement_plan_tag_left'],
				// 	// 'field_618548d5845fc' => $flat['settlement_plan'][0]['settlement_plan_tag_top'],
				// 	// 'field_618548e3845fd' => $flat['settlement_plan'][0]['settlement_plan_tag_text'],
				// 	// 'field_618548af845fa' => $flat->settlement_plan->settlement_plan_id,
				// 	// 'field_618548c2845fb' => $flat->settlement_plan->settlement_plan_tag_left,
				// 	// 'field_618548d5845fc' => $flat->settlement_plan->settlement_plan_tag_top,
				// 	// 'field_618548e3845fd' => $flat->settlement_plan->settlement_plan_tag_text,
				// ];

				//loop over and update AFC

				foreach($fillable as $key => $name) {
					// update_field( $key, $flat['flat_id'], $inserted_flat );
					update_field( $key, $flat[$name], $inserted_flat );
					file_put_contents($fiesACF, "Project Name: ".print_r($flat[$name], true). "\n\n", FILE_APPEND);
				}
	
			} else {
				//now update with new information
				$existing_flat_id = $existing_flat->ID;
				$existing_flat_status = get_field('flat_status', $existing_flat_id);;
				if($flat['flat_status'] !== $existing_flat_status) {

					// foreach( $projects[0] as $projectFillable ) {
					// 	$fillable1 = [
					// 		'field_618543d05c01e' => 'project_id',
					// 		'field_618543fc5c01f' => 'project_name',
					// 		'field_618544165c020' => 'project_blocks',
					// 		'field_618544a85c021' => 'project_flats',
					// 	];
					// }
			
					// $fillable2 = [
					// 	'field_618546bfcca51' => 'project_id',
					// 	'field_618546cccca52' => 'block_name',
					// 	'field_618546d5cca53' => 'number_of_flats',
					// 	'field_618546e3cca54' => 'project_id',
					// ];

					$fillable = [
						'field_618547bb845eb' => 'flat_id',
						'field_618547cd845ec' => 'block_id',
						'field_618547e4845ed' => 'project_id',
						'field_618547eb845ee' => 'flat_no',
						'field_618547f5845ef' => 'flat_price',
						'field_61854806845f0' => 'flat_floor',
						'field_61854811845f1' => 'gross_m2',
						'field_61854827845f2' => 'net_m2',
						'field_61854838845f3' => 'balcony_m2',
						'field_6185484c845f4' => 'garden_m2',
						'field_61854859845f5' => 'flat_type',
						'field_61854868845f6' => 'flat_direction',
						'field_61854873845f7' => 'flat_status',
					];

					// $fillable = array_merge( $fillable1, $fillable2, $fillable3 );
					//Add to AFC
					// $fillable = [
					// 	'field_618543d05c01e' => $project_id,
					// 	'field_618543fc5c01f' => $project_name,
					// 	'field_618544165c020' => $project_blocks,
					// 	'field_618544a85c021' => $project_flats,
					// 	// 'field_618545445c023' => 'flat_interior_plan_id',
					// 	// 'field_618545535c024' => 'flat_interior_plan_name',
					// 	// 'field_618545705c025' => 'interior_plan_image',
					// 	'field_618546bfcca51' => $blocked['project_id'],
					// 	'field_618546cccca52' =>$blocked['block_name'],
					// 	'field_618546d5cca53' => $blocked['number_of_flats'],
					// 	'field_618546e3cca54' => $blocked['project_id'],
					// 	// 'field_61854717cca56' => $blocked['situation_plan'][0]['image'],
					// 	'field_618547bb845eb' => $flat['flat_id'],
					// 	'field_618547cd845ec' => $flat['block_id'],
					// 	'field_618547e4845ed' => $flat['project_id'],
					// 	'field_618547eb845ee' => $flat['flat_no'],
					// 	'field_618547f5845ef' => $flat['flat_price'],
					// 	'field_61854806845f0' => $flat['flat_floor'],
					// 	'field_61854811845f1' => $flat['gross_m2'],
					// 	'field_61854827845f2' => $flat['net_m2'],
					// 	'field_61854838845f3' => $flat['balcony_m2'],
					// 	'field_6185484c845f4' => $flat['garden_m2'],
					// 	'field_61854859845f5' => $flat['flat_type'],
					// 	'field_61854868845f6' => $flat['flat_direction'],
					// 	'field_61854873845f7' => $flat['flat_status'],
					// 	// 'field_61854880845f8' => 'flat_interior_plan_ids',
					// 	// 'field_618548af845fa' => $flat['settlement_plan'][0]['settlement_plan_id'],
					// 	// 'field_618548c2845fb' => $flat['settlement_plan'][0]['settlement_plan_tag_left'],
					// 	// 'field_618548d5845fc' => $flat['settlement_plan'][0]['settlement_plan_tag_top'],
					// 	// 'field_618548e3845fd' => $flat['settlement_plan'][0]['settlement_plan_tag_text'],
					// 	// 'field_618548af845fa' => $flat->settlement_plan->settlement_plan_id,
					// 	// 'field_618548c2845fb' => $flat->settlement_plan->settlement_plan_tag_left,
					// 	// 'field_618548d5845fc' => $flat->settlement_plan->settlement_plan_tag_top,
					// 	// 'field_618548e3845fd' => $flat->settlement_plan->settlement_plan_tag_text,
					// ];

					foreach( $fillable as $key => $name ) {
						// update_field( $key, $flat['flat_id'], $existing_flat_id );
						update_field( $key, $flat->$flat[$name], $existing_flat_id );
						file_put_contents($fiesACF, "Project Name: ".print_r($flat[$name], true). "\n\n", FILE_APPEND);
					}
				}
			}
	
			// file_put_contents($files, "Content: ".print_r($flat, true). "\n\n", FILE_APPEND);
			file_put_contents($files, "Content: ".print_r($flat['flat_id'], true). "\n\n", FILE_APPEND);
	
		}
	
	}

	// $current_page = $current_page + 1;
	// wp_remote_post(admin_url('admin-ajax.php?action=get_flats_from_api'), [
	// 	'blocking' => false,
	// 	'sslverify' => false,
	// 	'body' => [
	// 		'current_page' => $current_page
	// 	]

	// ]);
}

function get_breweries_from_api(){

	//create a file to log errors
	$file = get_stylesheet_directory() . '/report.txt';
	$fiesACF = get_stylesheet_directory(). '/ACF2.txt';

	$current_page = ( ! empty($_POST['current_page'])) ? $_POST['current_page'] : 1;
	$breweries = [];

	$results = wp_remote_retrieve_body( wp_remote_get('https://api.openbrewerydb.org/breweries/?page=' . $current_page . '&per_page=50') ) ;

	//put errors in file if we find
	file_put_contents($file, "Current Page: ".$current_page."\n\n", FILE_APPEND);

	$results = json_decode($results);

	if( ! is_array($results) || empty($results)) {
		return false;
	}


	$breweries[] = $results;

	foreach($breweries[0] as $brewery){

		$brewery_slug = sanitize_title( $brewery->name .'-' .$brewery->id );

		//update data from api if new changes are made
		$existing_brewery = get_page_by_path( $brewery_slug, 'OBJECT', 'brewery' );

		//if it exist then update data if not add new posts
		if($existing_brewery === null){

			$inserted_brewery = wp_insert_post([
				'post_name' => $brewery_slug,
				'post_title' => $brewery_slug,
				'post_type' => 'brewery',
				'post_status' => 'published'
			]);

			if(is_wp_error( $inserted_brewery)) {
				continue;
			}

			//keys from AFC
			$fillable = [
				'field_6183dea448bcd' => 'name',
				'field_6183ddbc48bc3' => 'brewery_type',
				'field_6183ddeb48bc4' => 'street',
				'field_6183de1748bc5' => 'city',
				'field_6183de2c48bc6' => 'state',
				'field_6183de3b48bc7' => 'postal_code',
				'field_6183de4748bc8' => 'county',
				'field_6183de4f48bc9' => 'longitude',
				'field_6183de5948bca' => 'latitude',
				'field_6183de7648bcb' => 'phone',
				'field_6183de7d48bcc' => 'website',
				'field_6183deb348bce' => 'updated_at',
			];

			//loop over array and update ACF fields

			foreach( $fillable as $key => $name) {
				// update_field( $key, $brewery->$name, $inserted_brewery);
				file_put_contents($fiesACF, "Project Name: ".print_r($brewery->name, true). "\n\n", FILE_APPEND);
			}

		} else {

			//now update with new information
			$existing_brewery_id = $existing_brewery->ID;
			$existing_brewery_timestamp = get_field('updated_at', $existing_brewery_id);

			if($brewery->updated_at >= $existing_brewery_timestamp) {
				//update post meta -- create function later for this

				//keys from AFC
				$fillable = [
					'field_6183dea448bcd' => 'name',
					'field_6183ddbc48bc3' => 'brewery_type',
					'field_6183ddeb48bc4' => 'street',
					'field_6183de1748bc5' => 'city',
					'field_6183de2c48bc6' => 'state',
					'field_6183de3b48bc7' => 'postal_code',
					'field_6183de4748bc8' => 'county',
					'field_6183de4f48bc9' => 'longitude',
					'field_6183de5948bca' => 'latitude',
					'field_6183de7648bcb' => 'phone',
					'field_6183de7d48bcc' => 'website',
					'field_6183deb348bce' => 'updated_at',
				];

				//loop over array and update ACF fields

				foreach( $fillable as $key => $name) {
					// update_field( $key, $brewery->$name, $existing_brewery_id);
					file_put_contents($fiesACF, "Project Name: ".print_r($brewery, true). "\n\n", FILE_APPEND);
				}
			}

		}
		

	}


	$current_page = $current_page + 1;
	wp_remote_post(admin_url('admin-ajax.php?action=get_breweries_from_api'), [
		'blocking' => false,
		'sslverify' => false,
		'body' => [
			'current_page' => $current_page
		]

	]);


}






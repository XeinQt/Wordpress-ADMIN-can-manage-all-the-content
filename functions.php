<?php
/**
 * alentijo_furni functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package alentijo_furni
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function alentijo_furni_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on alentijo_furni, use a find and replace
		* to change 'alentijo_furni' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'alentijo_furni', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'alentijo_furni' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'alentijo_furni_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'alentijo_furni_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function alentijo_furni_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'alentijo_furni_content_width', 640 );
}
add_action( 'after_setup_theme', 'alentijo_furni_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alentijo_furni_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'alentijo_furni' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'alentijo_furni' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'alentijo_furni_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function alentijo_furni_scripts() {
	wp_enqueue_style( 'alentijo_furni-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'alentijo_furni-style', 'rtl', 'replace' );

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
    wp_enqueue_style('tiny-slider', get_template_directory_uri() . '/assets/css/tiny-slider.css');
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.css');

	wp_enqueue_script( 'alentijo_furni-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('tiny-slider', get_template_directory_uri() . '/assets/js/tiny-slider.js', array('jquery'), null, true);
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), null, true);
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'alentijo_furni_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

//services funciton
function wycu() {
	ob_start();
	$args = array(
		'post_type'      => 'home',   // your CPT name
		'posts_per_page' => -1,          // number of posts to show
		'order'          => 'ASC',      // or ASC
		'orderby'        => 'date'       // sort by date, title, etc.
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) :
		while ($query->have_posts()) : $query->the_post(); ?>
			
			<div class="col-6 col-md-6">
				<div class="feature">
					<div class="icon">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) ); ?>
						<?php endif; ?>
					</div>
					<h3><?php the_title(); ?></h3>
					<p><?php the_content(); ?></p>
				</div>
			</div>


		<?php endwhile;
		wp_reset_postdata();
	else :
		echo '<p>No products found.</p>';
	endif;
	return ob_get_clean();
}

add_shortcode('wycuFunction', 'wycu');


//Blog funciton
function blog() {
	ob_start();
	$args = array(
		'post_type'      => 'blog',   // your CPT name
		'posts_per_page' => -1,          // number of posts to show
		'order'          => 'ASC',      // or ASC
		'orderby'        => 'date'       // sort by date, title, etc.
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) :
		while ($query->have_posts()) : $query->the_post(); ?>
			

			<div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
				<div class="post-entry">
					<a href="<?php the_permalink(); ?>" class="post-thumbnail d-block mb-3">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid w-100 rounded' ) ); ?>
						<?php else : ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/default.jpg" alt="No Image" class="img-fluid w-100 rounded">
						<?php endif; ?>
					</a>
					<div class="post-content-entry">
						<h3 class="mb-2">
							<a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
								<?php the_title(); ?>
							</a>
						</h3>
						<div class="meta small text-muted">
							<span>by <a href="#" class="text-secondary text-decoration-none"><?php the_field("blog_author"); ?></a></span>
							<span>on <a href="#" class="text-secondary text-decoration-none">
								<?php the_field('date_blog'); ?>
							</a></span>
						</div>
						
					</div>
				</div>
			</div>



			<!-- <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0">
				<div class="post-entry">
					<a href="#" class="post-thumbnail"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/post-1.jpg" alt="Image" class="img-fluid"></a>
					<div class="post-content-entry">
						<h3><a href="#">First Time Home Owner Ideas</a></h3>
						<div class="meta">
							<span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 19, 2021</a></span>
						</div>
					</div>
				</div>
			</div> -->



		<?php endwhile;
		wp_reset_postdata();
	else :
		echo '<p>No products found.</p>';
	endif;
	return ob_get_clean();
}

add_shortcode('blogFunction', 'blog');

//out team
function team() {
	ob_start();
	$args = array(
		'post_type'      => 'about',   // your CPT name
		'posts_per_page' => -1,          // number of posts to show
		'order'          => 'ASC',      // or ASC
		'orderby'        => 'date'       // sort by date, title, etc.
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) :
		while ($query->have_posts()) : $query->the_post(); ?>
			

			<div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
				
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid mb-5'  ) ); ?>
				<?php endif; ?>

				<h3 clas><a href="#"> <?php the_title(); ?></a></h3>
					<span class="d-block position mb-4"><?php the_field('team_position'); ?></span>
					<p><?php the_content(); ?></p>
					<p class="mb-0"><a href="#" class="more dark">Learn More <span class="icon-arrow_forward"></span></a></p>

	
			</div> 

		<?php endwhile;
		wp_reset_postdata();
	else :
		echo '<p>No products found.</p>';
	endif;
	return ob_get_clean();
}

add_shortcode('teamFunction', 'team');


<?php 
//Getting Theme Templete

require_once ( get_stylesheet_directory() . '/theme-options.php' );

add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
    $GLOBALS['current_theme_template'] = basename($t);
    return $t;
}

function get_current_template( $echo = false ) {
    if( !isset( $GLOBALS['current_theme_template'] ) )
        return false;
    if( $echo )
        echo $GLOBALS['current_theme_template'];
    else
        return $GLOBALS['current_theme_template'];
}


//Example 

//echo get_current_template();
//echo '<br />';

// breadcrumbs

function the_breadcrumb() {
	if (!is_home()) {
		echo '<a href="';
		echo get_option('home');
		echo '">';
		bloginfo('name');
		echo "</a> » ";
		if (is_category() || is_single()) {
		//	the_category('title_li=');
		//print_r(get_the_category());
		$_SERVER['REQUEST_URI_PATH'] = preg_replace('/\\?.*/', '', $_SERVER['REQUEST_URI']);
//		echo "<br/>server=".$_SERVER['REQUEST_URI_PATH'];
		$url_segments= split('/',$_SERVER['REQUEST_URI_PATH']);
		$total = count($url_segments);
//		echo "<br/>count= ". $total;
		if(is_single())
		{
			$category_slug = $url_segments[$total-3];
		}
		else if(is_category())
		{
			$category_slug = $url_segments[$total-2];	
		}
//		echo "<br/>Category slug = ". $category_slug;
		$cat_info= get_category_by_slug( $category_slug );
//		echo "<pre>";
//		print_r($cat_info);
//		echo "</pre>";
		// Type cast for easy handling
		$cat_info = (array) $cat_info;
		$cat_name = $cat_info['name'];
		//echo "<br/>Category name = ". $cat_name;
		echo $cat_name;
			if (is_single()) {
				echo " » ";
				the_title();
			}
		} elseif (is_page()) {
			echo the_title();
		}
	}
}


// navigation 

if ( function_exists( 'register_nav_menus' ) ) {
  	register_nav_menus(
  		array(
  		  //'main' => 'My Custom Main Menu'
                ) );

}
           

function register_my_menus() {
register_nav_menus(
array(
//'footer-menu' => __( 'Footer Menu', 'twentyten' ),
//'usefull-menu' => __( 'Usefull Link Menu', 'twentyten'  )
)
);
}
add_action( 'init', 'register_my_menus' );

// sidebar




if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'sidebar1',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
register_sidebar(array('name'=>'sidebar2',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
register_sidebar(array('name'=>'sidebar3',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));



// widget

class announcement extends WP_Widget {  
        function announcement() {  
            parent::WP_Widget(false, 'Announcement');  
        }  
    function form($instance) {  
            // outputs the options form on admin
			$title = esc_attr($instance['title']);
        }
    
    function update($new_instance, $old_instance) {
		$title = esc_attr($instance['title']);
            // processes widget options to be saved  
            return $new_instance;  
        }  
    function widget($args, $instance) {
		?>
<div class="sections">
        		<h2 class="announce"><img src="<?php bloginfo('template_url'); ?>/images/announcment-icon.jpg" alt=" " width="36" height="31" align="left" />Announcements</h2>
            	<span>Important News and Events to know</span>
        		<img src="<?php bloginfo('template_url'); ?>/images/resource-sep.jpg" width="300" height="2" alt="" />
                
                <?php $my_query = new WP_Query("category_name=announcements&posts_per_page=5");
  					while ($my_query->have_posts()) : $my_query->the_post(); ?>
  <div class="sec-res">
  
            		<p><?php the_title(); ?></p>
            		<img src="<?php bloginfo('template_url'); ?>/images/date-icon.jpg" alt="" align="texttop" /> <strong class="blue"><?php the_date(); ?></strong>
                    </div>
                    <?php endwhile; ?> 
			<?php wp_reset_query(); ?>
            
			<a href="?page_id=46"><strong class="more-articles">See more Articles</strong></a></div>
      <?php      // outputs the content of the widget  
        }  
    }  
register_widget('announcement');

function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}


// geting Slug

function getSlug() {
	$catSlug = get_category(get_query_var('cat'))->slug;
	return $catSlug;
}

/*
single_cat_title(''); 
single_cat_title('You are reading about ').'<br />'; 
echo $current_category = single_cat_title("", false).'<br />'; ;
*/

// catching image from the Post Content

function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = bloginfo('template_directory')."/images/default.jpg";
  }
  return $first_img;
  // Usage :  <img src=" phpStart echo catch_that_image(); phpEnd"  />
}

function catch_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];
  return $first_img;
  // Usage :  <img src=" phpStart echo catch_image(); phpEnd"  />
}

// limiting the string 

// Way One :

//	$title = get_the_title();
//	$title = strip_tags($title);
//	echo substr($title, 0, 32);

// Way Second :	by function 

function showBrief($str, $length) {
  //$str = strip_tags($str);
	$str = preg_replace("/\< *[img][^\>]*[.]*\>/i","",$str,1);
	$str = explode(" ", $str);
	return implode(" " , array_slice($str, 0, $length));
}

// Two Colors 

function multiColor($title,$position){
	$title = explode(" ",$title );
	$count = count($title);
	for($i=0 ; $i < $count ; $i++){
		if($i == $position)echo '<span>';
		echo $title[$i].' ';
		if($i == ($count-1))echo '</span>';
	}
}







add_action('init', 'slider');
 
function slider() {
 
	$labels = array(
		'name' => _x('Slider', 'post type general name'),
		'singular_name' => _x('Slider', 'post type singular name'),
		'add_new' => _x('Add New', 'Slider item'),
		'add_new_item' => __('Add New Slider Item'),
		'edit_item' => __('Edit Slider Item'),
		'new_item' => __('New Slider Item'),
		'view_item' => __('View Slider Item'),
		'search_items' => __('Search Portfolio'),
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
		'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/wp-logo-small.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		//'supports' => array('title','editor','author','thumbnail','post-thumbnails','excerpts','trackbacks','custom-fields','comments','revisions','page-attributes')
		'supports' => array('title','editor','thumbnail')
	  ); 
 
	register_post_type( 'slider' , $args );
}	






add_action('init', 'latestnews');
 
function latestnews() {
 
	$labels = array(
		'name' => _x('Latest News', 'post type general name'),
		'singular_name' => _x('Latest News', 'post type singular name'),
		'add_new' => _x('Add New', 'Latest News item'),
		'add_new_item' => __('Add New Latest News Item'),
		'edit_item' => __('Edit Latest News Item'),
		'new_item' => __('New Latest News Item'),
		'view_item' => __('View Latest News Item'),
		'search_items' => __('Search Portfolio'),
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
		'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/wp-logo-small.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		//'supports' => array('title','editor','author','thumbnail','post-thumbnails','excerpts','trackbacks','custom-fields','comments','revisions','page-attributes')
		'supports' => array('title','editor','thumbnail','custom-fields')
	  ); 
 
	register_post_type( 'latestnews' , $args );
}	






/* Custom Post Type for Blog 

 ----------------------------------------------------------- */

add_action( 'init', 'create_book_taxonomies', 0 );

 

//create two taxonomies, genres and writers for the post type "book"

function create_book_taxonomies() 

{

  // Add new taxonomy, make it hierarchical (like categories)

  $labels = array(

    'name' => _x( 'Blog Category', 'taxonomy general name' ),

    'singular_name' => _x( 'Blog Category', 'taxonomy singular name' ),

    'search_items' =>  __( 'Search Blog Category' ),

    'all_items' => __( 'All Blog Category' ),

    'parent_item' => __( 'Parent Blog Category' ),

    'parent_item_colon' => __( 'Parent Blog Category:' ),

    'edit_item' => __( 'Edit Blog Category' ), 

    'update_item' => __( 'Update  Blog Category' ),

    'add_new_item' => __( 'Add New Blog Category' ),

    'new_item_name' => __( 'New Blog Category' ),

    'menu_name' => __( 'Blog Category' ),

  );           

 

  register_taxonomy('genre',array('blog'), array(

    'hierarchical' => true,

    'labels' => $labels,

    'show_ui' => true,

    'query_var' => true,

    'rewrite' => array( 'slug' => 'genre' ),

  ));

 

  // Add new taxonomy, NOT hierarchical (like tags)

  $labels = array(

    'name' => _x( 'Tags', 'taxonomy general name' ),

    'singular_name' => _x( 'Tags', 'taxonomy singular name' ),

    'search_items' =>  __( 'Search Tags' ),

    'popular_items' => __( 'Popular Tags' ),

    'all_items' => __( 'All Tags' ),

    'parent_item' => null,

    'parent_item_colon' => null,

    'edit_item' => __( 'Edit Tags' ), 

    'update_item' => __( 'Update Tags' ),

    'add_new_item' => __( 'Add New Tags' ),

    'new_item_name' => __( 'New Tags Name' ),

    'separate_items_with_commas' => __( 'Separate Tags with commas' ),

    'add_or_remove_items' => __( 'Add or remove Tags' ),

    'choose_from_most_used' => __( 'Choose from the most used Tags' ),

    'menu_name' => __( 'Tags' ),

  ); 

 

  register_taxonomy('writer','blog',array(

    'hierarchical' => false,

    'labels' => $labels,

    'show_ui' => true,

    'update_count_callback' => '_update_post_term_count',

    'query_var' => true,

    'rewrite' => array( 'slug' => 'writer' ),

  ));

}

 

add_action( 'init', 'codex_custom_init' );

function codex_custom_init() {

  $labels = array(

    'name' => _x('Blog Post', 'post type general name'),

    'singular_name' => _x('Blog Post', 'post type singular name'),

    'add_new' => _x('Add New', 'Blog Post'),

    'add_new_item' => __('Add New Blog Post'),

    'edit_item' => __('Edit Blog Post'),

    'new_item' => __('New Blog Post'),

    'all_items' => __('All Blog Post'),

    'view_item' => __('View Blog Post'),

    'search_items' => __('Search Blog Post'),

    'not_found' =>  __('No Blog Post found'),

    'not_found_in_trash' => __('No Blog Post found in Trash'), 

    'parent_item_colon' => '',

    'menu_name' => 'Blog Post',

 

  );

  $args = array(

    'labels' => $labels,

    'public' => true,

    'publicly_queryable' => true,

    'show_ui' => true, 

    'show_in_menu' => true, 

    'query_var' => true,

    'rewrite' => true,

    'capability_type' => 'post',

    'has_archive' => true, 

    'hierarchical' => false,

    'menu_position' => null,

                'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/wp-logo-small.png',

    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )

  ); 

  register_post_type('blog',$args);

}

 

 

/* ---------------------------------------------------------- */


// custom post type 

/*function post_type_movies() {
register_post_type(
'movies',
array(
'label' => __('Movies'),
'public' => true,
'show_ui' => true,
'supports' => array('title','editor','author','thumbnail','post-thumbnails','excerpts','trackbacks','custom-fields','comments','revisions','page-attributes')
)
);
register_taxonomy( 'actor', 'movies', array( 'hierarchical' => true, 'label' => __('Actor') ) );
register_taxonomy( 'production', 'movies',
array(
'hierarchical' => false,
'label' => __('Production'),
'query_var' => 'production',
'rewrite' => array('slug' => 'production' )
)
);
}
add_action('init', 'post_type_movies');*/
	
	



add_image_size( 'slider', 310, 150, true );


// Get Page ID by name, slug or title

function get_page_id($name)
{
global $wpdb;
// get page id using custom query
$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE ( post_name = '".$name."' or post_title = '".$name."' ) and post_status = 'publish' and post_type='page' ");
return $page_id;
}

// End

// Get Page Permalink by name, slug or title

function get_page_permalink($name)
{
$page_id = get_page_id($name);
return get_permalink($page_id);
}

// End


// Get From the URL Slug

function getSlugFromUrl()
{
	return (basename(get_permalink()));
}

// End

// Get From the URL Slug

function getIdBySlug($slugName)
{ 	
	$idObj = get_category_by_slug($slugName); 
  	$id = $idObj->term_id;
	return $id;
}



if(!function_exists('getPageContent'))
{
	function getPageContent($pageId)
	{
		if(!is_numeric($pageId))
		{
			return;
		}
		global $wpdb;
		$sql_query = 'SELECT DISTINCT * FROM ' . $wpdb->posts .
		' WHERE ' . $wpdb->posts . '.ID=' . $pageId;
		$posts = $wpdb->get_results($sql_query);
		if(!empty($posts))
		{
			foreach($posts as $post)
			{
				return nl2br($post->post_content);
			}
		}
	}
}


function remove_image_content($content) {
return preg_replace("/\< *[img][^\>]*[.]*\>/i","",$content,1);
}

// e.g add_filter('the_content', 'remove_image_content');

//

function attachment_url_extra( $form_fields, $post ) {
	// input field relates to attachments
        // my_field and _my_field is what you should replace with your own
	$post->post_type == 'attachment';
	$form_fields[ 'my_field' ] = array(
		'label' => __( 'MY FIELD' ),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, '_my_field', true )
	);
	$form_fields[ 'my_field' ][ 'label' ] = __( 'MY FIELD' );
	$form_fields[ 'my_field' ][ 'input' ] = 'text';
	$form_fields[ 'my_field' ][ 'value' ] = get_post_meta( $post->ID, '_my_field', true );

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'attachment_url_extra', NULL, 2 );

function attachment_url_extra_save( $post, $attachment ) {

	if( isset( $attachment[ 'my_field' ] ) ) {
		if( trim( $attachment[ 'my_field'] ) == '' ) $post[ 'errors' ][ 'my_field' ][ 'errors' ][] = __( 'Error! Something went wrong.' );
		else update_post_meta( $post[ 'ID' ], '_my_field', $attachment[ 'my_field' ] );
	}
	return $post;

}

add_filter( 'attachment_fields_to_save', 'attachment_url_extra_save', NULL, 2 );



//


/*$labels = array(
		'name' => _x('Galleries', 'post type general name'),
		'singular_name' => _x('Gallery', 'post type singular name'),
		'add_new' => _x('Add New', 'gallery'),
		'add_new_item' => __("Add New Gallery"),
		'edit_item' => __("Edit Gallery"),
		'new_item' => __("New Gallery"),
		'view_item' => __("View Gallery"),
		'search_items' => __("Search Gallery"),
		'not_found' =>  __('No galleries found'),
		'not_found_in_trash' => __('No galleries found in Trash'), 
		'parent_item_colon' => ''
	  );
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail','excerpt')
	  ); 
	  register_post_type('gallery',$args);
	  
	  add_post_type_support('gallery', 'title');
add_post_type_support('gallery', array('title', 'thumbnail', 'excerpt') );


add_action("admin_init", "galleryint");

// Add meta box goes into our admin_init function
function galleryint(){
	add_meta_box(	'gallery-type-div', __('Gallery Type'),  'gallery_type_metabox', 'gallery', 'normal', 'low');
}
 
function gallery_type_metabox($post) {
	$gallery_type = get_post_meta($post->ID, '_gallery_type', TRUE);
	if (!$gallery_type) $gallery_type = 'attachment'; 	 
	?>
        <input type="hidden" name="gallery_type_noncename" id="gallery_type_noncename" value="<?php echo wp_create_nonce( 'gallery_type'.$post->ID );?>" />
	<input type="radio" name="gallery_type" value="any" <?php if ($gallery_type == 'any') echo "checked=1";?>> Any.<br/>
	<input type="radio" name="gallery_type" value="attachment" <?php if ($gallery_type == 'attachment') echo "checked=1";?>> Only Attachments.<br/>
	<input type="radio" name="gallery_type" value="post" <?php if ($gallery_type == 'post') echo "checked=1";?>> Only Posts.<br/>
	<input type="radio" name="gallery_type" value="gallery" <?php if ($gallery_type == 'gallery') echo "checked=1";?>> Only Galleries.<br/>
	<?php
}

// Add to admin_init function
add_action('save_post', array(&$this,'save_gallery_data') );
 
function save_gallery_data($post_id) {	
	// verify this came from the our screen and with proper authorization.
	if ( !wp_verify_nonce( $_POST['gallery_type_noncename'], 'gallery_type'.$post_id )) {
		return $post_id;
	}
 
	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
 
	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;
 
 
	// OK, we're authenticated: we need to find and save the data	
	$post = get_post($post_id);
	if ($post->post_type == 'gallery') { 
		update_post_meta($post_id, '_gallery_type', esc_attr($_POST['gallery_type']) );
                return(esc_attr($_POST['gallery_type']));
	}
	return $post_id;
}

*/
include('class/define_pt.php');


//
/*
add_action('init', 'add_slides_type');
function add_slides_type()
{
  $labels = array(
    'name' => _x('Slides', 'post type general name'),
    'singular_name' => _x('Slide', 'post type singular name'),
    'add_new' => _x('Add New', 'Post'),
    'add_new_item' => __('Add New Slide'),
    'edit_item' => __('Edit Slide'),
    'new_item' => __('New Slide'),
    'view_item' => __('View Slide'),
    'search_items' => __('Search Slides'),
    'not_found' =>  __('No Slides found'),
    'not_found_in_trash' => __('No Slides found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title','editor','author','thumbnail','excerpt','comments','custom-fields','post-formats'),
    'has_archive' => true
  );
  register_post_type('slides',$args);
}

add_action( 'add_meta_boxes', 'nivo_add_custom_box' );
add_action( 'save_post', 'nivo_save_postdata' );

function nivo_add_custom_box() {
    add_meta_box(
        'nivo_options',
        'Slide Options',
        'nivo_inner_custom_box',
        'slides'
    );
}

function nivo_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'nivo_noncename' );

  $mydata = get_post_meta($post->ID, 'nivo_slider', TRUE);

  // The actual fields for data entry
  echo '<label for="nivo_imageurl">';
  echo 'URL to image for slide:';
  echo '</label> ';
  echo '<input type="text" id="nivo_imageurl" name="nivo_imageurl" value="'.$mydata['nivo_imageurl'].'" size="25" />';
  echo '<label for="nivo_caption">';
  echo 'URL to image for slide:';
  echo '</label> ';
  echo '<input type="text" id="nivo_caption" name="nivo_caption" value="'.$mydata['nivo_caption'].'" size="25" />';
  //Add more fields as you need them...
}

function nivo_save_postdata( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

  if ( !wp_verify_nonce( $_POST['nivo_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  $mydata = array();
  foreach($_POST as $key => $data) {
    if($key == 'nivo_noncename')
      continue;
    if(preg_match('/^nivo/i', $key)) {
      $mydata[$key] = $data;
    }
  }
  update_post_meta($post_id, 'nivo_slider', $mydata);
  return $mydata;
}

$nivodata = get_post_meta($post->ID, 'nivo_slider', TRUE);
echo $nivodata['nivo_imageurl'];
*/

add_action( 'right_now_content_table_end' , 'right_now_content_table_end' );

function right_now_content_table_end() {
  $args = array(
    'public' => true ,
    '_builtin' => false
  );
  $output = 'object';
  $operator = 'and';

  $post_types = get_post_types( $args , $output , $operator );

  foreach( $post_types as $post_type ) {
    $num_posts = wp_count_posts( $post_type->name );
    $num = number_format_i18n( $num_posts->publish );
    $text = _n( $post_type->labels->singular_name, $post_type->labels->name , intval( $num_posts->publish ) );
    if ( current_user_can( 'edit_posts' ) ) {
      $num = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
      $text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
    }
    echo '<tr><td class="first b b-' . $post_type->name . '">' . $num . '</td>';
    echo '<td class="t ' . $post_type->name . '">' . $text . '</td></tr>';
  }

}

//
$query = "
		SELECT * FROM $wpdb->posts
		LEFT JOIN $wpdb->postmeta ON($wpdb->posts.ID = $wpdb->postmeta.post_id)
		LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
		LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
		LEFT JOIN $wpdb->terms ON($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
		WHERE $wpdb->terms.slug = 'tvlt-notes'
		AND $wpdb->term_taxonomy.taxonomy = 'tvlt_category'
		AND $wpdb->postmeta.meta_key = 'tvlt_sort'
		AND $wpdb->postmeta.meta_value <> '9999'
 	";

 $tvlt_posts = $wpdb->get_results($query, OBJECT);
//

function category_has_children() {
global $wpdb;	
$term = get_queried_object();
$category_children_check = $wpdb->get_results(" SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id' ");
	if ($category_children_check) {
		return true;
	} else {
		return false;
	}
}	

function count_posts($cat_id){
	global $wpdb;
	
	$query = "
		SELECT COUNT(*) FROM $wpdb->posts
		LEFT JOIN $wpdb->term_relationships ON
		($wpdb->posts.ID = $wpdb->term_relationships.object_id)
		LEFT JOIN $wpdb->term_taxonomy ON
		($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
		WHERE $wpdb->posts.post_status = 'private'
		AND $wpdb->term_taxonomy.taxonomy = 'category'
		AND $wpdb->term_taxonomy.term_id = $cat_id
	";
	return $wpdb->get_var($query);
}




function add_mime_types($mime_types){
	$mime_types['art'] = 'text/plain';
	return $mime_types;
}
add_filter('upload_mimes', 'add_mime_types', 1, 1);


function getCurrentCatID(){

global $wp_query;

if(is_category() || is_single()){

$cat_ID = get_query_var('cat');
}

return $cat_ID;

}

//

//add this to the functions.php file
add_theme_support( 'post-thumbnails' );

//add this to the functions.php file this to only add to page templates not posts
//add_theme_support( 'post-thumbnails', array( 'page' ) );

//

/*
$args = array('post_type' => 'attachment','numberposts' => -1,'post_parent' => $post->ID); 
$attachments = get_posts($args);
$current_post_thumbnail = get_post_thumbnail_id($id);
							
if($attachments){
     foreach($attachments as $attachment){
          if($attachment->ID == $current_post_thumbnail) continue;
	  echo wp_get_attachment_image($attachment->ID, 'thumbnail' );
	  break;
     }
}
*/

//Setup DB
function lmcb_create_db_table(){
	global $wpdb;
	$lmcb_db_version = "1.0";
				
	$table_name = $wpdb->prefix . "band_info";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
				
		$sql = "CREATE TABLE " . $table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				option_name VARCHAR(150) NOT NULL,
				option_value TEXT NOT NULL,
				UNIQUE KEY id (id)
				);";
					
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		add_option("lmcb_db_version", $lmcb_db_version);
		
		//Band Options
		$band_info_options = array('main_image','description');
		foreach($band_info_options as $option){
			$wpdb->insert($table_name, array('option_name' => $option, 'option_value' => ''));
		}	
	}
}

global $test_db_version;
$test_db_version = "1.0";

function test_create_db_table() {
global $wpdb;
global $test_db_version;

$table_name = $wpdb->prefix . "test_table";
if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

$sql = "CREATE TABLE " . $table_name . " (
id mediumint(9) NOT NULL AUTO_INCREMENT,
time varchar(11) NOT NULL,
title text NOT NULL,
body text NOT NULL,
UNIQUE KEY id (id)
);";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

add_option("test_db_version", $test_db_version);
}
}

function test_add_row(){
global $wpdb;
$table_name = $wpdb->prefix . "test_table";

$test_title = "The Title";
$test_body = "The Body Text";

$rows_affected = $wpdb->insert( $table_name, array( 'time' => date("m-d-Y"), 'title' => $test_title, 'body' => $test_body ) );
}

add_action('init','test_create_db_table');
/* Uncomment this action to initiate a new row
Just replcace wp_login with the hook of your choice
add_action('wp_login','test_add_row');
*/

add_action('init','lmcb_create_db_table');	
					
function lmcb_to_band_info_db(){
	global $wpdb;
	
	$table_name = $wpdb->prefix . "band_info";
	foreach($_POST as $key => $value){
		$wpdb->update($table_name, array('option_value' => $value), array('option_name' => $key));
	}			
}

// admin

/*
function testing() {
  //echo 'Hello World!';
}
add_action( 'admin_head', 'testing' ); 

function remove_dashboard_widgets(){
  global$wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); 
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

function remove_menu_items() {
  global $menu;
  $restricted = array(__('Links'), __('Comments'), __('Media'),
  __('Plugins'), __('Tools'), __('Users'));
  end ($menu);
  while (prev($menu)){
    $value = explode(' ',$menu[key($menu)][0]);
    if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
      unset($menu[key($menu)]);}
    }
  }

add_action('admin_menu', 'remove_menu_items');

function remove_submenus() {
  global $submenu;
  unset($submenu['index.php'][10]); // Removes 'Updates'.
  //unset($submenu['themes.php'][5]); // Removes 'Themes'.
  unset($submenu['options-general.php'][15]); // Removes 'Writing'.
  unset($submenu['options-general.php'][25]); // Removes 'Discussion'.
  unset($submenu['edit.php'][16]); // Removes 'Tags'.  
}

add_action('admin_menu', 'remove_submenus');

function remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}

add_action('_admin_menu', 'remove_editor_menu', 1);

function customize_meta_boxes() {
	//   Removes meta boxes from Posts 
  remove_meta_box('postcustom','post','normal');
  remove_meta_box('trackbacksdiv','post','normal');
  remove_meta_box('commentstatusdiv','post','normal');
  remove_meta_box('commentsdiv','post','normal');
  remove_meta_box('tagsdiv-post_tag','post','normal');
  remove_meta_box('postexcerpt','post','normal');
  // Removes meta boxes from pages 
  remove_meta_box('postcustom','page','normal');
  remove_meta_box('trackbacksdiv','page','normal');
  remove_meta_box('commentstatusdiv','page','normal');
  remove_meta_box('commentsdiv','page','normal'); 
}

add_action('admin_init','customize_meta_boxes');

function custom_post_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}

add_filter('manage_posts_columns', 'custom_post_columns');

function custom_pages_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}

add_filter('manage_pages_columns', 'custom_pages_columns');

function custom_favorite_actions($actions) {
  unset($actions['edit-comments.php']);
  return $actions;
}

add_filter('favorite_actions', 'custom_favorite_actions');
*/




//my featured product function 
function featured_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$featured = (bool) $custom["featured"][0];
?>
<label>Check If The Product if featured:</label><input name="featured" type="checkbox" <?php if ( $featured ) {
?>checked="checked"<?php
} ?> />

<?php
 }
//my header slide area

function subtitle_options(){
		global $post;
		$custom = get_post_custom($post->ID);
		$subtitle = (string) $custom["subtitle"][0];
?>
<label>Sub Title </label><br /><input name="subtitle" type="text" <?php if ($subtitle ) {
?> value="<?php echo $subtitle ; ?>"<?php
} ?>  />
<?php

}


//add_action("manage_posts_custom_column",  "products_custom_columns");
//add_filter("manage_edit-".'product'."_columns", "products_edit_columns");
 
//function products_edit_columns($columns){
//  $columns = array(
//    "cb" => "<input type=\"checkbox\" />",
//    "title" => "Title",
//    "description" => "Description",
//    "featured" => "Featured",
//	"tg_blog_category" => "Categories",
//  ); 
//  return $columns;
//
//}
//function products_custom_columns($column){
//  global $post;
// 
//  switch ($column) {
//    case "description":
//      the_excerpt();
//      break;
//   
//	case "featured":
//      $custom = get_post_custom();
//	  if ($custom["featured"][0]==1){
//		  echo 'Featured';
//		}
//		else {
//			echo 'Not Featured';
//		}
//      
//      break;
//    case "tg_blog_category":
//      echo get_the_term_list($post->ID, 'tg_blog_category', '', ', ','');
//      break;
//  }
//}


function insert_complogo($file_handler,$user_id,$setthumb='false') {
// check to make sure its a successful upload
if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');

$attach_id = media_handle_upload( $file_handler, $user_id );

if ($setthumb) update_usermeta($user_id,'_thumbnail_id',$attach_id);
return $attach_id;
}


add_action('admin_menu', 'create_theme_options_page');
add_action('admin_init', 'register_and_build_fields');
 
function create_theme_options_page() {
  // add_options_page('New Options', 'New Options', 'administrator', __FILE__, 'options_page_fn');
}
 
function register_and_build_fields() {
   register_setting('plugin_options', 'plugin_options', 'validate_setting');
 
   add_settings_section('main_section', 'Main Settings', 'section_cb', __FILE__);
 
   add_settings_field('color_scheme', 'Color Scheme:', 'color_scheme_setting', __FILE__, 'main_section');
   add_settings_field('logo', 'Logo:', 'logo_setting', __FILE__, 'main_section'); // LOGO
   add_settings_field('banner_heading', 'Banner Heading:', 'banner_heading_setting', __FILE__, 'main_section');
   add_settings_field('adverting_information', 'Advertising Info:', 'advertising_information_setting', __FILE__, 'main_section');
 
   add_settings_field('ad_one', 'Ad:', 'ad_setting_one', __FILE__, 'main_section'); // Ad1
   add_settings_field('ad_two', 'Second Ad:', 'ad_setting_two', __FILE__, 'main_section'); // Ad2
}
 
function options_page_fn() {
?>
   <div id="theme-options-wrap" class="widefat">
      <div class="icon32" id="icon-tools"></div>
 
      <h2>My Theme Options</h2>
      <p>Take control of your theme, by overriding the default settings with your own specific preferences.</p>
 
      <form method="post" action="options.php" enctype="multipart/form-data">
         <?php settings_fields('plugin_options'); ?>
         <?php do_settings_sections(__FILE__); ?>
         <p class="submit">
            <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
         </p>
   </form>
</div>
<?php
}
 
// Banner Heading
function banner_heading_setting() {
   $options = get_option('plugin_options');
   echo "<input name='plugin_options[banner_heading]' type='text' value='{$options['banner_heading']}' />";
}
 
// Color Scheme
function color_scheme_setting() {
   $options = get_option('plugin_options');
   $items = array("Red", "Green", "Blue");
 
   echo "<select name='plugin_options[color_scheme]'>";
   foreach ($items as $item) {
      $selected = ( $options['color_scheme'] === $item ) ? 'selected = "selected"' : '';
      echo "<option value='$item' $selected>$item</option>";
   }
   echo "</select>";
}
 
// Advertising info
function advertising_information_setting() {
   $options = get_option('plugin_options');
   echo "<textarea name='plugin_options[advertising_information]' rows='10' cols='60' type='textarea'>{$options['advertising_information']}</textarea>";
}
 
// Ad one
function ad_setting_one() {
   echo '<input type="file" name="ad_one" />';
}
 
// Ad two
function ad_setting_two() {
   echo '<input type="file" name="ad_two" />';
}
 
// Logo
function logo_setting() {
   echo '<input type="file" name="logo" />';
}
 
function validate_setting($plugin_options) {
   $keys = array_keys($_FILES);
   $i = 0;
 
   foreach ($_FILES as $image) {
      // if a files was upload
      if ($image['size']) {
         // if it is an image
         if (preg_match('/(jpg|jpeg|png|gif)$/', $image['type'])) {
            $override = array('test_form' => false);
            $file = wp_handle_upload($image, $override);
 
            $plugin_options[$keys[$i]] = $file['url'];
         } else {
            $options = get_option('plugin_options');
            $plugin_options[$keys[$i]] = $options[$logo];
            wp_die('No image was uploaded.');
         }
      }
 
      // else, retain the image that's already on file.
      else {
         $options = get_option('plugin_options');
         $plugin_options[$keys[$i]] = $options[$keys[$i]];
      }
      $i++;
   }
 
   return $plugin_options;
}
 
function section_cb() {}
 
// Add stylesheet
add_action('admin_head', 'admin_register_head');
 
function admin_register_head() {
   $url = get_bloginfo('template_directory') . '/functions/options_page.css';
   echo "<link rel='stylesheet' href='$url' />\n";
}

global $options;
$options = get_option('cOptn');

function post_content($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}



///admin

// admin Theme

function modify_footer_admin () {
 echo '<style type="text/css">
    //#footer{ background:#393737 ; color:#fff }
	#screen-meta-links{ display:block !important}
    </style>';	
  echo 'A Custom WordPress Theme by CMS Xperts';
}

add_filter('admin_footer_text', 'modify_footer_admin');

function custom_logo() {
  echo '<style type="text/css">
    #header-logo { background-image: url('.get_bloginfo('template_directory').'/images/admin/wp-logo.png) !important; }
	//#wphead{ background:#393737 }
	//#wphead h1 a,#user_info a:link, #user_info a:visited, #footer a:link, #footer a:visited,#user_info{ color:#fff}
    #main-bar{ background: url("'.get_bloginfo('template_directory').'/images/admin/logo-bg.jpg") repeat-x; left: 0; position: absolute; top: 0; width: 100%; z-index: 1; height:91px;}
	#wpwrap{margin-top:92px}
	html{ background:#fff}
	#media-upload #main-bar{ display:none !important;}
    </style>';
	?>
  <script>
	jQuery(document).ready(function(){
		jQuery('body').append('<div id="main-bar"><a title="CMS Xperts" target="_blank" href="javascript:;"><img border="0" src="<?php bloginfo('template_directory'); ?>/images/admin/cmslogo.jpg"></a></div>');
	});
  </script>    
<?php 	
}


add_action('admin_head', 'custom_logo');

function custom_login_logo() {
  echo '<style type="text/css">
    h1 a { background-image:url('.get_bloginfo('template_directory').'/images/admin/logo-login.jpg) !important; background-size:210px 86px !important;  }
	#main-bar{ background: url("'.get_bloginfo('template_directory').'/images/admin/logo-bg.jpg") repeat-x; left: 0; position: absolute; top: 0; width: 100%; z-index: 1; height:91px;}
	#backtoblog{top:92px}
	#login{margin:18em auto}	
    </style>';
	?>
    <script type="text/javascript" language="javascript" src="<?php bloginfo('template_directory'); ?>/assets/js/vendor/jquery-1.8.1.min.js"></script>
  <script>
	jQuery(document).ready(function(){
		jQuery('body').append('<div id="main-bar"><a title="cmsxperts" target="_blank" href="http://#"><img border="0" src="<?php bloginfo('template_directory'); ?>/assets/img/admin/cmslogo.jpg"></a></div>');
	});
  </script>    
  <?php 
}

add_action('login_head', 'custom_login_logo');
//add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );


//add_theme_support('post-thumbnails');
//set_post_thumbnail_size( 200, 100, true );


function new_widgets_init() {
register_sidebar( array(
'name' => 'Footer CopyRight Text',
'id' => 'widget-area-one',
'description' => __( 'Here the Widget Area One'),
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => 'Widget Area Two',
'id' => 'widget-area-two',
'description' => __( 'Here the Widget Area Two'),
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
// Add the widget areas
add_action( 'init', 'new_widgets_init' );



add_action('init', 'recommended');
 
function recommended() {
 
	$labels = array(
		'name' => _x('Recommended Stories', 'post type general name'),
		'singular_name' => _x('Recommended Story', 'post type singular name'),
		'add_new' => _x('Add New', 'Recommended Story'),
		'add_new_item' => __('Add New Recommended Story'),
		'edit_item' => __('Edit Recommended Story'),
		'new_item' => __('New Recommended Story'),
		'view_item' => __('View Recommended Story'),
		'search_items' => __('Search Portfolio'),
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
		'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/wp-logo-small.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		//'supports' => array('title','editor','author','thumbnail','post-thumbnails','excerpts','trackbacks','custom-fields','comments','revisions','page-attributes')
		'supports' => array('title','editor','thumbnail','custom-fields')
	  ); 
 
	register_post_type( 'recommended' , $args );
}	


add_action('init', 'products');
 
function products() {
 
	$labels = array(
		'name' => _x('products', 'post type general name'),
		'singular_name' => _x('products', 'post type singular name'),
		'add_new' => _x('Add New', 'products'),
		'add_new_item' => __('Add New products'),
		'edit_item' => __('Edit products'),
		'new_item' => __('New products'),
		'view_item' => __('View products'),
		'search_items' => __('Search Portfolio'),
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
		'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/wp-logo-small.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		//'supports' => array('title','editor','author','thumbnail','post-thumbnails','excerpts','trackbacks','custom-fields','comments','revisions','page-attributes')
		'supports' => array('title','editor','thumbnail','custom-fields')
	  ); 
 
	register_post_type( 'products' , $args );
}	


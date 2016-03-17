<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />

<meta name="viewport" content="width=device-width" />
<title><?php
/*
* Print the <title> tag based on what is being viewed.
*/
global $page, $paged;

wp_title( '|', true, 'right' );

// Add the blog name.
bloginfo( 'name' );

// Add the blog description for the home/front page.
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
echo " | $site_description";

// Add a page number if necessary:
if ( $paged >= 2 || $page >= 2 )
echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.cycle.all.latest.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.flip.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/scripts.js"></script></head>


<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		global $options;global $logo;global $copyrite;
		$options = get_option('cOptn');
		$logo = $options['logo'];
		$copyright = $options['copyright'];
		$twitter_link = $options['twitter_link'];
		$facebook_link = $options['facebook_link'];
		$googleplus_link = $options['googleplus_link'];
		$rss_link = $options['rss_link'];
		$email_link = $options['email_link'];
		$phone_num = $options['phone_num'];
		$fax_num = $options['fax_num'];
		$email = $options['email'];
		$flicker_link = $options['flicker_link'];
		$header_caption = $options['header_caption'];
		$linkedin = $options['linkedin'];
		$youtube = $options['youtube'];
		$size = 334;
		$options['logo'] = wp_get_attachment_image($logo, array($size, $size), false);
		$att_img = wp_get_attachment_image($logo, array($size, $size), false); 
		$logoSrc = wp_get_attachment_url($logo);
		$att_src_thumb = wp_get_attachment_image_src($logo, array($size, $size), false);

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
wp_head();
?>



</head>

<body>


<div class="header">
  <div class="logo"><a href="#">
<?php  echo $options['logo'] ; ?></a></div>
  <div class="header-right">
  
    <div class="social-wrapper"> 
    <a href="http://facebook.com/#" class="facebook"></a> 
    <a href="http://twitter.com" class="twitter"></a> 
 
    <a href="#" class="rss"></a> </div>
  </div>
  
  <div class="navigation">
 <?php wp_nav_menu('menu'); ?>

  </div>
</div>

<div class="main-wrapper">



<?php /*?>            				
       <?php $index_query = new WP_Query(array( 'post_type' => 'slider', 'order' => 'ASC',  'posts_per_page' => 8 )); ?>
       <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
	  
                 <?php endwhile; ?><?php */?>
                
                
  
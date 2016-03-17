<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header('single'); 
?>



       <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div class="single-entry">
 <h1 ><?php the_title(); ?></h1>
  
       <?php the_post_thumbnail(); ?>
       <p><?php the_content(); ?></p></div>
      <?php endwhile; ?>
      
     <?php // get_sidebar(); ?>
     
     

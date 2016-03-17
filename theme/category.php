<?php
get_header(); 
?>



<div class="middle">

     <div class="content">
   
   
   
   <div class="left_area">
       <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>></div>
        <div class="heading-bar"> <h1 class="page-hd"><?php the_title(); ?></h1></div>
        <div class="subtitle"><?php echo get_post_meta($post->ID, 'subtitle', true); ?></div>
       <div class="inner-pages">
       <?php the_post_thumbnail(); ?>
       <p><?php the_content(); ?></p>
      <?php endwhile; ?>
      
      </div>
      </div>
     
     
     <?php get_sidebar(); ?>
     
     
      
     <div class="clear"></div>
     
         
   </div>
   
   
 
   
 
<?php get_footer();  ?>
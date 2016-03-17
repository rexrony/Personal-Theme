<?php
get_header(); 
?>


<style>
.search-block {width:980px;}
.search-block h1 {color:#7EBE4B; font-size:24px; font-family:Verdana; padding:15px 0; display:block; clear:both;}
.search-block h1 a {padding:15px 0; color:#414141;}

</style>

<div class="middle">

     <div class="content">
   
   
   
   <div class="left_area">
<?php if ( have_posts() ) : ?>
    
    

	<h1><?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1>


                
                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                <?php endwhile; ?>
<?php else : ?>
<h1><?php _e( 'OOPS, Nothing Found', 'twentyten' ); ?></h1>
<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
<?php endif; ?>

   
    </div>
   
   <div class="clear"></div>
   </div>
  </div>

<?php get_footer(); ?>
<?php
/*
Template Name:Blog Template
*/
get_header('blog'); 
?>
 <div class="middle">
 <div class="stuff-cage">
   <div class="left">
   

  <?php  
global $paged;
if( get_query_var( 'paged' ) )
	$my_page = get_query_var( 'paged' );
else {
	if( get_query_var( 'page' ) )
		$my_page = get_query_var( 'page' );
	else
		$my_page = 1;
	set_query_var( 'paged', $my_page );
	$paged = $my_page;
} ?>
   		<?php  
	$count=2;
	$args = array( 'post_type' => 'blog', 'taxonomy' => 'blog-post', 'posts_per_page' => 36, 'paged' => $my_page );
	$blog = new WP_Query( $args );
	while ( $blog->have_posts() ) : $blog->the_post(); ?>
		<div class="artical rounded-corner">
        <div class="date"><?php the_time('M') ?><br /><span class="day"><?php the_time('j') ?></span><br /><?php the_time('Y') ?></div>
         <h1><?php the_title(); ?> </h1>
         <div style="float:left; padding:0 20px 0 0"><?php the_post_thumbnail(); ?></div>
        <div class="stuff"><?php the_excerpt(); ?></div>
       
       
       <div class="postMeta">
					<a href="<?php the_permalink() ?>" class="more-link">Readmore &raquo;</a>
					<div class="metaRight">
						<img src="<?php bloginfo('template_directory'); ?>/images/ico_author.png" alt="Author"/> An article by <?php the_author_link(); ?>
						<img src="<?php bloginfo('template_directory'); ?>/images/ico_comments.png" alt="Comments"/> <?php comments_popup_link('No Comments', '1 Comment ', '% Comments'); ?>
					</div>
				</div>
        
    </div>
		<?php $count++; endwhile; wp_reset_query(); ?>
     <?php //wp_pagenavi();?>
     	<?php 
    if(function_exists('wp_pagenavi')) { 
        wp_pagenavi( array(
            'query' =>$blog   
        )); 
    }
    ?>
     
     
  </div>
          <?php get_sidebar('blog');  ?>  </div> </div>
     
<?php get_footer('blog');  ?>
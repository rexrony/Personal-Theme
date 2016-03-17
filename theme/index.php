<?php
/**
 * The main template file.
 
*/


get_header(); ?>
<div class="row">


<div class="big-square ">
<div class="medium-child "><div class="slider-container">
<div id="slider">

       <?php $index_query = new WP_Query(array( 'post_type' => 'slider', 'order' => 'ASC',  'posts_per_page' => 8 )); ?>
       <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
<div class="single-slide"><?php the_post_thumbnail('home-slider'); ?></div>
       
       <?php endwhile;?>
</div>
<a href="#" id="prev">Prev</a>
<a href="#" id="next">Next</a>
</div>
</div>
<div class="big-child purple">
<div class="news">
<h2>My Write Ups</h2>
<ul>

    <?php $index_query = new WP_Query(array( 'post_type' => 'latestnews', 'order' => 'ASC',  'posts_per_page' => 8 )); ?>
       <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
       

<li><span><a href="<?php echo get_post_meta(get_the_id(),'link', true); ?>" target="_blank"><?php the_title(); ?></a></span>
<p>  <?php echo showBrief(get_the_content(),15); ?>... </p>
</li>

<?php endwhile; ?>


	</ul>
</div>
</div>
</div>


<div class="big-square">
<div class="small-child green icon"><a  href="#contact_form_pop" class="fancybox"><img src="<?php bloginfo('template_directory');?>/images/form-ico.png" /><span class="box-title">Quick Contact</span></a></div>

<div class="small-child fbcolor	icon"><a  href="#suggestion-form" class="fancybox"><img src="<?php bloginfo('template_directory');?>/images/form-icon.jpg" /><span class="box-title">Experience</span></a></div>
    <div class="small-child facebookcolor"  ><a href="http://facebook.com/whitelabeled" target="_blank"><img src="<?php bloginfo('template_directory');?>/images/fb.jpg" /></a></div>
 <div class="small-child redish" id=""><a href="#nacir-info" class="fancybox"><img src="<?php bloginfo('template_directory');?>/images/nacirzia.jpg" class="dp-img" /></a></div>
<div class="medium-child pink"><span class="twitter-title">Latest Tweets</span>
<div class="latest-tweets">
<p>Happy happy happy happy and a very happy Birthday Pakistan <a href="#">#ILovePakistan</a></p>
</div>
</div>
</div>



<div class="big-square blue">
<div class="big-child sky">
<div class="complaints"><h2>Recommended Stories</h2>
<ul>
 <?php $index_query = new WP_Query(array( 'post_type' => 'recommended', 'order' => 'ASC',  'posts_per_page' => 8 )); ?>
  <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
<li><div ></div><span><a href="<?php echo get_post_meta(get_the_id(),'link', true); ?>" target="_blank"><?php the_title(); ?></a></span>
<p> <?php echo showBrief(get_the_content(),14); ?>...</p>
</li>
<?php endwhile; ?>
	</ul>
</div></div>
<div class="medium-child linkedin-badge">
<div class="linkedin-dp"><img src="<?php bloginfo('template_directory'); ?>/images/linkedin-dp.jpg" /></div>
<h4>Nasir Zia</h4>
<span><strong>Architect </strong>at <strong>Axact</strong></span>
<span>Pakistan</span>


<a href="#" target="_blank">View Profile</a>
</div>

</div>
</div>



<div style="display:none" class="fancybox-hidden">
    <div id="contact_form_pop">

<?php echo do_shortcode('[contact-form-7 id="13" title="Contact form 1"]'); ?>   
    </div>
</div>



<div style="display:none" class="fancybox-hidden">
    <div id="suggestion-form">
<div class="experience-container">
<div class="single-exp"><h3>Architect - Axact</h3>
<span>Junary 2015 - Present</span>
</div>

<div class="single-exp"><h3>Associate Architect - Axact</h3>
<span>January 2014 - December 2014</span>
</div>

<div class="single-exp"><h3>Assistant Architect - Axact</h3>
<span>July 2013 - December 2013</span>
</div>

<div class="single-exp"><h3>Senior Engineer - Axact</h3>
<span>July 2012  - July 2013</span>
</div>

<div class="single-exp"><h3>Sr. Web Developer - VUSH</h3>
<span>February 2012 - July 2012</span>
</div>

<div class="single-exp"><h3>Web Developer - VUSH</h3>
<span>February 2011 - February 2012</span>
</div>
   </div> </div>
</div>


<div style="display:none" class="fancybox-hidden">

   <div id="nacir-info"><h2>Nasir Zia<span> UI/UX/WordPress Theme Developer </span></h2>
<img src="<?php bloginfo('template_directory');?>/images/nacir-featured.jpg" />
<p>I am working as an Architect at <a href="http://www.axact.com" target="_blank">Axact</a>. I have 5 years of experience in UI Design, WordPress development &amp; Theme Development. Completed my Graduation in 2011 from <a href="http://ssuet.edu.pk" target="_blank">Sir Syed University of Engineering &amp; Technology</a>. </p>

<p>Religiously - Sunni, <BR />
Politically - MQM, <BR />
Corporately - Axactian, <BR />
Indivudally - Human</p>
</div>
</div>

  <?php /*?> 

  <?php   $homeblock = new WP_Query('category_name=homepage&showposts=1&order=ASC'); ?> 
  <?php while( $homeblock->have_posts() ) : $homeblock->the_post();  ?> 
 
  <?php echo showBrief(get_the_content(),20); ?> 

             <?php endwhile; wp_reset_postdata();  ?>
  
  <?php */?>
  
  <?php /*?>            				
       <?php $index_query = new WP_Query(array( 'post_type' => 'home_boxes', 'order' => 'ASC',  'posts_per_page' => 8 )); ?>
       <?php while ($index_query->have_posts()) : $index_query->the_post(); ?>
	  
                 <?php endwhile; ?><?php */?>
   
   
<?php get_footer(); ?>
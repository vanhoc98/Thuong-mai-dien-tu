<?php 
get_header(); 
?>	



<div id="wrap">
	<div class="g_content">
		<div id="breadcrumb" class="breadcrumb">
								<ul>
									<?php  echo the_breadcrumb(); ?>
								</ul>
							</div> 
		<div class="container">
					
			<div class="row">
				<?php 
				if(have_posts()) :
					while(have_posts()) : the_post(); ?>
						<div class=" col-sm-9  content_left">
					
							<article class="content_single_post">
								<div class="single_post_info">
									<h2><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p><?php the_time('d/m/Y');?><span>  <?php the_time('H:i') ?>
									</p>
								</div>
								<div class="post_avt">
									<div class="wrap_post_avt">
										<?php //the_post_thumbnail();?>
									</div>
								</div>
								<div class="text_content">
									<?php  the_content(); ?>
								</div>
							</article>

							<!-- fb-comment-area -->
							<div class="fb-comments" data-href="<?php echo get_permalink(); ?>" data-order-by="reverse_time" data-width="855" data-numposts="20" data-colorscheme="light" ></div>

							<?php $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 6, 'post__not_in' => array($post->ID) ) ); ?>
							<?php if($related){ ?>
							<div class="related_posts">
								<h2>Tin cùng chuyên mục</h2>
								<ul class="row"> 
									<?php
									
									if( $related ) foreach( $related as $post ) {
										setup_postdata($post); ?>

										<li class="col-md-4 col-sm-4 col-xs-12">
											<div class="list_item_related pw">
											<figure class="thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></figure>
											<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
											</div>
									
										</li>

									<?php }
									wp_reset_postdata(); ?>
								</ul>   
							</div>
						<?php } ?> 
						</div>
						<div class="col-md-3 col-sm-3 sidebar">
							<?php dynamic_sidebar('sidebar1'); ?> 
						</div>
					<?php endwhile;
				else:
				endif;
				wp_reset_postdata();
				?>
			</div>
			
		</div>

		
	</div>
</div>


<?php get_footer(); ?>



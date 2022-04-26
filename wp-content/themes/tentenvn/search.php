<?php 
get_header(); 
?>	



<div id="content">
	<div class="container">
		<div class="list_post">
			<?php 
			if(have_posts()): ?>
				<h2 class="title_header">Kết quả tìm kiếm : <strong><?php the_search_query(); ?></strong></h2>
				<?php	while(have_posts()): the_post(); 
					
				get_template_part('includes/frontend/loop/loop_post');
				
				 endwhile;
				 get_template_part('includes/frontend/pagination/pagination');
			else:
				echo '<p> No found content</p>';
			endif;
			wp_reset_postdata();
			?>
		</div>

	</div>
</div>


<?php get_footer(); ?>



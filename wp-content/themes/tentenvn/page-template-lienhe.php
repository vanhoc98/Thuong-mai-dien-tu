<?php 
/*
Template Name: page-template-lienhe
*/
get_header(); 
?>	

<div class="page-wrapper">
	<div class="g_content">
		<div id="breadcrumb" class="breadcrumb">
			<ul>
				<?php  echo the_breadcrumb(); ?>
			</ul>
		</div>
		<div class="container">
			<?php 
		$my_postid = 484;//This is page id or post id
		$content_post = get_post($my_postid);
		$content = $content_post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		echo $content;
		?>
	</div><!-- container -->
</div>
</div>
<?php get_footer(); ?>
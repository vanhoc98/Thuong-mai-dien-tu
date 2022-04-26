<?php 
/*
Template Name: page-template-gioithieu
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
			<div class="row">
				<div class="col-sm-9">
					<div class="g_content_left">
						<?php 
		$my_postid = 540;//This is page id or post id
		$content_post = get_post($my_postid);
		$content = $content_post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		echo $content;
		?>
	</div>
	
</div>
<div class="col-sm-3 sidebar">
	<?php dynamic_sidebar('sidebar1'); ?> 
</div>
</div>

</div><!-- container -->
</div>
</div>
<?php get_footer(); ?>
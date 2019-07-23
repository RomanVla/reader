
<?php 

 get_header();
 $container_s = (r_option('sidebar_s')=='right_s')?'container':'container-fluid';
 $blor_s = (r_option('sidebar_s')=='right_s')?'col-md-18':'col-md-14 col-sm-18';
 $layout = (r_option('select-layout')=='container-fluid')?'container-fluid':'container';
 ?>


<!-- Featured posts -->
<?php
$featured_posts = new WP_Query( array(
    'post_type'         => 'post',
    'posts_per_page'    => -1,
    'meta_key'          => 'set_featured_post',
    'meta_value'        => 'on'
));
?>
<div class="container-fluid">
    <div class="row slider-area">
        <div class="owl-carousel">
            <?php while($featured_posts->have_posts()): $featured_posts->the_post(); ?>
                <div class="col-md-24 carousel-item">
                    <div class="item">
                        <?php the_post_thumbnail('reader_featured_post'); ?>
                        <div class="content">
                            <div class="content-head">
                                <a href="<?php esc_url(the_permalink()); ?>"> <?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>



 <!-- BODY CONTAINER - FULL WIDTH -->

<div class="main-body <?php echo esc_attr($layout); ?>">
    <div class="row">
		<?php if(r_option('sidebar_s')!='right_s'): ?>
		<?php get_template_part('sidebar-left') ?>
		<?php endif; ?>

        
        <!-- =========================
             BLOG SECTION 
        ============================== -->
        <div class="<?php echo esc_attr( $blor_s) ?>">
			<?php if(is_archive()) {show_archive();} ?>
			<?php if(is_search()) {show_search();} ?>
            <div class="blog-style-two <?php if(r_option('ajax_posts')&&(!is_archive())&&!is_search()) echo 'content-to-load' ?>">
                <!-- GENERAL BLOG POST -->
			<div class="row">
			<div class="col-md-12">

				<?php  
				$count = 0;
				$ret = '';
				if ( have_posts() ) :
				while ( have_posts() ) : the_post();
				
				$title_post = get_the_title();
				if($title_post==""){
					$title_post = '(Untitled)';
				}
				if($count%2==0):
				?>
                <article <?php post_class('blog-item'); ?>>
				<?php get_template_part( 'content', 'gallery' ); ?>
                    <header>
                        <h2 class="title">
							<?php if(is_sticky()):?>
								<span class="sticky_label"><?php _e('Featured','reader') ?><i class="fa fa-chevron-right"></i></span>
							<?php endif; ?>
                            <a href="<?php the_permalink() ?>"><?php echo esc_html($title_post) ?></a>
                        </h2>
                        <div class="meta-info">                           
							<?php get_template_part('content','meta') ?>                                
                        </div>
                    </header>
					<div class="post-body">
					<?php the_content() ?>
					<?php 
						wp_link_pages( array(
							'before'      => '<div class="pagination"><div class="navigate-page"><span class="page-links-title">' . __( 'Pages:', 'reader' ) . '</span>',
							'after'       => '</div></div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
					?>
					
					<p><a href="<?php the_permalink() ?>" class="btn btn-prime btn-read-more btn-small"><?php echo r_option('read_more_label') ?></a></p>
					
					</div>
                </article>

				<?php else://even ?>
				<?php
				ob_start();  	
				?>
				 <article <?php post_class('blog-item'); ?>>
				 <?php get_template_part( 'content', 'gallery' ); ?>
                    <header>
                        <h2 class="title">
							<?php if(is_sticky()):?>
								<span class="sticky_label"><?php _e('Featured','reader') ?><i class="fa fa-chevron-right"></i></span>
							<?php endif; ?>
                            <a href="<?php the_permalink() ?>"><?php echo esc_html($title_post) ?></a>
                        </h2>
                        <div class="meta-info">                           
							<?php get_template_part('content','meta') ?>                                
                        </div>
                    </header>
					<div class="post-body">
					<?php the_content() ?>
					<?php 
						wp_link_pages( array(
							'before'      => '<div class="pagination"><div class="navigate-page"><span class="page-links-title">' . __( 'Pages:', 'reader' ) . '</span>',
							'after'       => '</div></div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
					?>
					<p><a href="<?php the_permalink() ?>" class="btn btn-prime btn-read-more btn-small"><?php echo r_option('read_more_label') ?></a></p>
					</div>
                </article>

				<?php 
				$ret .= ob_get_contents();
				ob_end_clean();
				?>
				<?php endif;//odd ?>
				<?php $count++; ?>
				<?php endwhile; ?>
				<?php else: ?>
				<?php _e('No Posts Found.','reader') ?>
				<?php endif; ?>
			</div>	
			
			<div class="col-md-12">
			<?php echo ($ret) ?>			
			</div>	
                
				<?php if(r_option('ajax_posts')&&(!is_archive())&&!is_search()): ?>
				
				<div class="content-loader">
                    <a class="jscroll-load-more btn btn-prime btn-small" href="contents/blog-post-set-1.html">Load More</a>
                </div>

				<?php else: ?>
				
				<!-- PAGINATION -->

				<?php r_pagination()?>

                <!-- /PAGINATION -->
				<?php endif; ?>
                
            </div>
			</div>	
        </div>
        <!-- /END BLOG SECTION -->

       <?php get_sidebar() ?>

    </div>
</div> <!-- end of .container-fluid -->

<?php get_footer() ?>
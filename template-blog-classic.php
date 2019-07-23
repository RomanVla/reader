
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

    <div class="container-fluid featured-post-slider">
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
            <div class="blog-style-one <?php if(r_option('ajax_posts')&&!is_archive()&&!is_search()) echo 'content-to-load' ?>">
                <!-- GENERAL BLOG POST -->
				
				<?php
						if ( have_posts() ) :
						while ( have_posts() ) : the_post();
						$title_post = get_the_title();
						if($title_post==""){
							$title_post = '(Untitled)';
						}
						?>
						
                <article <?php post_class('blog-item'); ?>>				
                    <header>
                        <h2 class="title">
							<?php if(is_sticky()):?>
								<span class="sticky_label"><?php _e('Sticky','reader') ?><i class="fa fa-chevron-right"></i></span>
							<?php endif; ?>
                            <a href="<?php the_permalink() ?>"><?php echo esc_html($title_post) ?></a>
                        </h2>
                        <div class="meta-info">                           
							<?php get_template_part('content','meta') ?>                                
                        </div>
                    </header>
					<?php get_template_part( 'content', 'gallery' ); ?>
					<div class="post-body">
					<?php the_content('') ?>
					<?php 
						wp_link_pages( array(
							'before'      => '<div class="pagination"><div class="navigate-page"><span class="page-links-title">' . __( 'Pages:', 'reader' ) . '</span>',
							'after'       => '</div></div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
					?>
					<?php if(r_option('show_read_more')): ?>
					<p><a href="<?php the_permalink() ?>" class="btn btn-prime btn-read-more2 btn-read-more btn-small"><?php echo r_option('read_more_label') ?></a></p>
					<?php endif; ?>
					</div>
                </article>

                <hr>
				<?php endwhile; ?>
				<?php else: ?>
				<?php _e('No Posts Found.','reader') ?>
				<?php endif; ?>
                
				<?php if(r_option('ajax_posts')&&(!is_archive())&&!is_search()): ?>
				
				<div class="content-loader">
                    <a class="jscroll-load-more btn btn-prime btn-small" href="contents/blog-post-set-1.html"><?php _e('Load More','reader') ?></a>
                </div>

				<?php else: ?>
				
				<!-- PAGINATION -->
                
				<?php r_pagination()?>

                <!-- /PAGINATION -->
				<?php endif; ?>
                
            </div>
        </div>
        <!-- /END BLOG SECTION -->

       <?php get_sidebar() ?>

    </div>
</div> <!-- end of .container-fluid -->

<?php get_footer() ?>
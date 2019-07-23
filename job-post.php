<?php
/*
 * Template Name: Job posts
 *
 * */

get_header();
$container_s = (r_option('sidebar_s')=='right_s')?'container':'container-fluid';
$blor_s = (r_option('sidebar_s')=='right_s')?'col-md-18':'col-md-14 col-sm-18';
$layout = (r_option('select-layout')=='container-fluid')?'container-fluid':'container';

?>

<div class="main-body <?php echo esc_attr($layout); ?>">
    <div class="row">
        <?php if(r_option('sidebar_s')!='right_s'): ?>
            <?php get_template_part('sidebar-left') ?>
        <?php endif; ?>

        <!-- =========================
             JOB POST SECTION
        ============================== -->

        <div class="col-md-14 col-sm-18 job-posts-section">
            <?php
            $job_post = new WP_Query(array(
                'post_type'     => array('jobpost'),
                'posts_per_page'=> -1,
            ));

            while($job_post->have_posts()): $job_post->the_post(); ?>

            <article <?php post_class(); ?> >
                <div class="job-left col-md-15">
                    <div class="job-date-pos">
                        <span class="job-date"> <?php the_date('F d, Y') ?> </span>
                        <span class="job-position"> - <?php
                            $positions = get_the_terms(get_the_ID(), "job_pos");
                            if ( $positions && ! is_wp_error( $positions ) ) {
                                foreach ($positions as $position) {
                                    $position = $position->name;
                                    echo esc_html($position);
                                }
                            }
                            ?> </span>
                    </div>
                    <h1 class="job-title"> <?php the_title(); ?> </h1>
                    <div class="img-company-name">
                        <?php if(has_post_thumbnail()) the_post_thumbnail(array(40, 40), array('class'=>'company-img')); ?>
                        <span class="company-name"><?php
                            $company_names = get_the_terms(get_the_ID(), "job_company");
                        if ( $company_names && ! is_wp_error( $company_names ) ) {
                            foreach ($company_names as $company_name) {
                                $company_name = $company_name->name;
                                echo esc_html($company_name);
                            }
                        }
                            ?></span>
                    </div>
                </div>
                <div class="job-right col-md-9">
                    <a href="<?php
                    $job_link = get_post_meta(get_the_ID(), 'set_job_link', true);
                    if(!empty($job_link)) echo esc_url($job_link); else esc_attr(the_permalink()); ?>"
                   class="btn btn-fullwd btn-prime"
                   <?php if(!empty($job_link)) echo'target="_blank"' ?> > <?php esc_html_e('Apply Now', 'reader'); ?> </a>
                </div>
            </article>

            <hr class="after-job-post">

            <?php endwhile; ?>
        </div>

        <!-- /END JOB POST SECTION -->

        <?php get_sidebar() ?>

    </div>
</div>

<?php
get_footer();
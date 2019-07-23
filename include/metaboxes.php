<?php

// Featured Post Metabox
add_action('cmb2_init', function() {
    $cmb = new_cmb2_box(array(
        'id'            => 'featured_post',
        'title'         => esc_html__('Featured post', 'reader'),
        'object_types'  => array('post'),
        'context'       => 'side',
        'priority'      => 'high'
    ));
    $cmb->add_field(array(
        'id'        => 'set_featured_post',
        'type'      => 'checkbox',
        'desc'      => esc_html__('Set as featured post', 'reader')
    ));
});

add_action('cmb2_init', function() {
    $cmb = new_cmb2_box(array(
        'id'            => 'job_link',
        'title'         => esc_html__('Job Link', 'reader'),
        'object_types'  => array('jobpost'),
    ));
    $cmb->add_field(array(
        'id'        => 'set_job_link',
        'type'      => 'text',
        'desc'      => esc_html__('Give here a external link of this Job Post', 'reader')
    ));
});

<?php

if (have_posts()) {
    the_post();
    kstudio_document(
        apply_filters('the_content', get_the_content()),
        trailingslashit(get_stylesheet_directory_uri()) . 'assets/',
        get_bloginfo('name')
    );
}

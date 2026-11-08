<?php

require_once __DIR__ . '/view.php';

add_action('after_setup_theme', function () {
    add_theme_support('editor-styles');
    add_editor_style('assets/site.css');
    add_theme_support('responsive-embeds');
    add_image_size('kstudio-desktop', 1440, 0);
    add_image_size('kstudio-wide', 1920, 0);
});

add_filter('show_admin_bar', '__return_false');

add_action('template_redirect', function () {
    if (!isset($_GET['kstudio-credits'])) {
        return;
    }
    $html = file_get_contents(__DIR__ . '/assets/credits.html');
    echo str_replace(
        array('href="../"', 'href="site.css"'),
        array('href="' . esc_url(home_url('/')) . '"', 'href="' . esc_url(get_stylesheet_directory_uri() . '/assets/site.css') . '"'),
        $html
    );
    exit;
});

add_filter('render_block_core/button', function ($html) {
    $tags = new WP_HTML_Tag_Processor($html);
    if ($tags->next_tag('a')) {
        $tags->add_class('btn');
    }
    return $tags->get_updated_html();
});

add_filter('render_block_core/group', function ($html, $block) {
    if (($block['attrs']['anchor'] ?? '') !== 'top') {
        return $html;
    }
    $tags = new WP_HTML_Tag_Processor($html);
    if ($tags->next_tag('section')) {
        $tags->set_attribute('data-enter', '');
        $tags->set_attribute('aria-labelledby', 'hero-heading');
    }
    if ($tags->next_tag('h1')) {
        $tags->set_attribute('data-enter-whole', '');
    }
    return $tags->get_updated_html();
}, 10, 2);

add_filter('render_block_core/image', function ($html, $block) {
    $classes = explode(' ', $block['attrs']['className'] ?? '');
    $tags = new WP_HTML_Tag_Processor($html);
    if (in_array('work-feature', $classes, true) && $tags->next_tag('figure')) {
        $tags->set_attribute('data-moment', 'picture-develops');
        $tags->set_attribute('data-moment-opts', '{"look":"film","duration":1300}');
    }
    if ($tags->next_tag('img')) {
        if (in_array('hero-photo', $classes, true)) {
            $tags->set_attribute('fetchpriority', 'high');
            $tags->set_attribute('sizes', '(min-width: 1200px) max(100vw, 1920px), max(100vw, 66.67svh)');
            $tags->set_attribute('loading', 'eager');
            $tags->set_attribute('data-enter-media', '');
        } else {
            $tags->set_attribute('loading', 'lazy');
        }
        $tags->set_attribute('decoding', 'async');
        $tags->set_attribute('data-source', 'stand-in');
    }
    return $tags->get_updated_html();
}, 10, 2);

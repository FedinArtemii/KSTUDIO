<?php

$root = dirname(__DIR__);
require $root . '/.local/wordpress/wp-load.php';

$post = get_post((int) get_option('page_on_front'));
if (!$post || $post->post_status !== 'publish') {
    fwrite(STDERR, "The WordPress front page must be published.\n");
    exit(1);
}
setup_postdata($post);
$content = apply_filters('the_content', $post->post_content);
$docs = $root . '/docs';
$asset_source = get_stylesheet_directory() . '/assets';

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($asset_source, FilesystemIterator::SKIP_DOTS));
foreach ($files as $file) {
    if (!$file->isFile()) {
        continue;
    }
    $relative = substr($file->getPathname(), strlen($asset_source) + 1);
    $destination = $docs . '/assets/' . $relative;
    wp_mkdir_p(dirname($destination));
    if (!copy($file->getPathname(), $destination)) {
        throw new RuntimeException('Could not copy ' . $relative);
    }
}

$uploads = wp_get_upload_dir();
$prefix = trailingslashit($uploads['baseurl']);
$uploads_path = trailingslashit(wp_normalize_path(realpath($uploads['basedir'])));
$paths = array_map(fn($path) => preg_quote($path, '~'), array($prefix, wp_make_link_relative($prefix)));
$pattern = '~(?:' . implode('|', $paths) . ')([^\s"\'<>,]+)~u';
$content = preg_replace_callback($pattern, function ($match) use ($uploads_path, $docs) {
    $relative = rawurldecode(html_entity_decode($match[1], ENT_QUOTES, 'UTF-8'));
    $source = realpath($uploads_path . $relative);
    if (!$source || !str_starts_with(wp_normalize_path($source), $uploads_path) || !is_file($source)) {
        throw new RuntimeException('Missing page image: ' . $relative);
    }
    $destination = $docs . '/assets/media/' . $relative;
    wp_mkdir_p(dirname($destination));
    if (!copy($source, $destination)) {
        throw new RuntimeException('Could not export image: ' . $relative);
    }
    return './assets/media/' . $match[1];
}, $content);

ob_start();
kstudio_document($content, './assets/', get_bloginfo('name'), true);
$html = ob_get_clean();
$html = preg_replace('/[ \t]+$/m', '', $html);
file_put_contents($docs . '/index.html', rtrim($html) . "\n");
file_put_contents($docs . '/.nojekyll', '');
echo "Static site: docs/index.html\n";

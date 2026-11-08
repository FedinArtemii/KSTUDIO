<?php

$root = dirname(__DIR__) . '/.local/wordpress';
$origin = 'http://127.0.0.1:8174';
$login_file = dirname($root) . '/login.txt';

if (!file_exists($root . '/wp-config.php')) {
    $settings = array(
        'DB_NAME' => 'kstudio', 'DB_USER' => 'local', 'DB_PASSWORD' => '',
        'DB_HOST' => 'localhost', 'DB_CHARSET' => 'utf8mb4', 'DB_COLLATE' => '',
        'DB_ENGINE' => 'sqlite', 'WP_HOME' => $origin, 'WP_SITEURL' => $origin,
        'WP_HTTP_BLOCK_EXTERNAL' => true, 'DISABLE_WP_CRON' => true,
        'WP_ENVIRONMENT_TYPE' => 'local', 'WP_DEBUG' => true, 'WP_DEBUG_LOG' => true,
        'WP_DEBUG_DISPLAY' => false,
    );
    foreach (array('AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY',
        'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT') as $key) {
        $settings[$key] = bin2hex(random_bytes(32));
    }
    $config = "<?php\n";
    foreach ($settings as $key => $value) {
        $config .= sprintf("define(%s, %s);\n", var_export($key, true), var_export($value, true));
    }
    $config .= '$table_prefix = \'kstudio_\';' . "\nrequire_once ABSPATH . 'wp-settings.php';\n";
    file_put_contents($root . '/wp-config.php', $config);
}
if (!file_exists($root . '/wp-content/db.php')) {
    copy($root . '/wp-content/plugins/sqlite-database-integration/db.copy', $root . '/wp-content/db.php');
}

define('WP_INSTALLING', true);
require $root . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/upgrade.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once $root . '/wp-content/themes/kstudio/view.php';
require_once $root . '/wp-content/themes/kstudio/starter-content.php';

if (!is_blog_installed()) {
    $password = bin2hex(random_bytes(12));
    wp_install('KSTUDIO', 'kstudio-editor', 'editor@kstudio.example', false, '', $password);
    file_put_contents($login_file, "URL: $origin/wp-admin/\nUsername: kstudio-editor\nPassword: $password\n");
}
switch_theme('kstudio');
update_option('blog_public', 0);
update_option('timezone_string', 'Asia/Yekaterinburg');
update_option('uploads_use_yearmonth_folders', 0);
update_option('default_comment_status', 'closed');

$page = get_page_by_path('kstudio-home');
if (!$page) {
    add_filter('big_image_size_threshold', '__return_false');
    $media = array();
    foreach (array('hero', 'light', 'dark', 'process', 'loft') as $name) {
        $slug = "kstudio-$name-2k";
        $filename = "$slug.webp";
        $existing = get_page_by_path($slug, OBJECT, 'attachment');
        if ($existing) {
            $media[$name] = $existing->ID;
            continue;
        }
        $source = $root . '/wp-content/themes/kstudio/assets/media/' . $filename;
        $tmp = wp_tempnam($filename);
        copy($source, $tmp);
        $id = media_handle_sideload(array('name' => $filename, 'tmp_name' => $tmp), 0, "KSTUDIO · $name");
        if (is_wp_error($id)) {
            @unlink($tmp);
            fwrite(STDERR, $id->get_error_message() . "\n");
            exit(1);
        }
        wp_update_post(array('ID' => $id, 'post_name' => $slug));
        $media[$name] = $id;
    }

    $page_id = wp_insert_post(array(
        'post_title' => 'Главная', 'post_name' => 'kstudio-home', 'post_type' => 'page',
        'post_status' => 'publish', 'comment_status' => 'closed', 'post_content' => kstudio_seed_content($media),
    ), true);
    if (is_wp_error($page_id)) {
        fwrite(STDERR, $page_id->get_error_message() . "\n");
        exit(1);
    }
} else {
    $page_id = $page->ID;
}
update_option('show_on_front', 'page');
update_option('page_on_front', $page_id);
echo "WordPress: $origin/\nPage ID: $page_id\n";

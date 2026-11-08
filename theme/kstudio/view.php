<?php

const KSTUDIO_BOOKING = 'https://vk.ru/uslugi-229430084';
const KSTUDIO_COMMUNITY = 'https://vk.ru/kstudio_colorist74';
const KSTUDIO_PUBLIC = 'https://fedinartemii.github.io/KSTUDIO/';

function kstudio_arrow(): string {
    return '<svg class="m-arrow" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M2 14 14 2M4 2h10v10" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>';
}

function kstudio_nav(): void {
    ?>
    <a href="#works">Работы</a>
    <a href="#services">Услуги</a>
    <a href="#studio">Студия</a>
    <?php
}

function kstudio_document(string $content, string $assets, string $name, bool $static = false): void {
    $title = $name . ' — Пространство Красоты';
    $description = 'KSTUDIO Пространство Красоты. Эксперты в индустрии окрашивания. Онлайн-запись во ВКонтакте.';
    $hero_image = new WP_HTML_Tag_Processor($content);
    $hero_image->next_tag('img');
    $hero_src = $hero_image->get_attribute('src') ?: $assets . 'media/kstudio-hero-2k.webp';
    if ($static && str_starts_with($hero_src, './')) {
        $image_url = KSTUDIO_PUBLIC . substr($hero_src, 2);
    } else {
        $image_url = str_starts_with($hero_src, '/') ? home_url($hero_src) : $hero_src;
    }
    $credits = $static ? $assets . 'credits.html' : home_url('/?kstudio-credits=1');
    ?>
<!doctype html>
<html lang="ru" data-type="place" data-radius="sharp" data-buttons="solid" data-motion>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#171716">
    <meta name="page-type" content="place">
    <meta name="site-kind" content="other">
    <meta name="page-kind" content="place">
    <title><?= esc_html($title) ?></title>
    <meta name="description" content="<?= esc_attr($description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:title" content="<?= esc_attr($title) ?>">
    <meta property="og:description" content="<?= esc_attr($description) ?>">
    <meta property="og:image" content="<?= esc_url($image_url) ?>">
    <?php if ($static): ?>
    <link rel="canonical" href="<?= esc_url(KSTUDIO_PUBLIC) ?>">
    <meta property="og:url" content="<?= esc_url(KSTUDIO_PUBLIC) ?>">
    <?php else: ?>
    <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>
    <link rel="icon" href="<?= esc_attr($assets . 'icon.svg') ?>" type="image/svg+xml">
    <link rel="preload" href="<?= esc_attr($assets . 'fonts/commissioner.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= esc_attr($assets . 'site.css') ?>">
    <link rel="stylesheet" href="<?= esc_attr($assets . 'motion/motion.css') ?>">
    <link rel="stylesheet" href="<?= esc_attr($assets . 'moments/picture-develops/moment.css') ?>">
    <script>document.documentElement.classList.add('m-enter');setTimeout(()=>document.documentElement.classList.add('m-enter-done'),700)</script>
    <script type="module" src="<?= esc_attr($assets . 'site.js') ?>"></script>
</head>
<body>
    <header class="site-header nav">
        <a class="skip-link" href="#main">К содержанию</a>
        <div class="header-inner wrap">
            <a class="wordmark" href="#top" aria-label="<?= esc_attr($name . ' — в начало') ?>"><?= esc_html($name) ?></a>
            <nav class="desktop-nav" aria-label="Основное меню"><?php kstudio_nav(); ?></nav>
            <a class="community desktop-community" href="<?= esc_url(KSTUDIO_COMMUNITY) ?>">ВКонтакте <?= kstudio_arrow() ?></a>
            <details class="mobile-menu">
                <summary aria-label="Меню"><span></span><span></span></summary>
                <nav aria-label="Основное меню">
                    <?php kstudio_nav(); ?>
                    <a href="<?= esc_url(KSTUDIO_COMMUNITY) ?>">ВКонтакте <?= kstudio_arrow() ?></a>
                </nav>
            </details>
        </div>
    </header>
    <main id="main" tabindex="-1">
        <?= $content ?>
    </main>
    <footer class="site-footer closing">
        <div class="wrap footer-inner">
            <a class="wordmark" href="#top" aria-label="<?= esc_attr($name . ' — в начало') ?>"><?= esc_html($name) ?></a>
            <p>Демо · фотографии для иллюстрации</p>
            <a href="<?= esc_attr($credits) ?>">Источники фотографий</a>
        </div>
    </footer>
</body>
</html>
    <?php
}

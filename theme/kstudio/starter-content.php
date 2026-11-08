<?php

function kstudio_seed_content(array $media): string {
    $image = function (string $name, string $class, string $alt) use ($media): string {
        $id = $media[$name];
        $url = wp_get_attachment_url($id);
        $attrs = wp_json_encode(array(
            'id' => $id, 'sizeSlug' => 'full', 'linkDestination' => 'none', 'className' => $class
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return "<!-- wp:image $attrs -->\n"
            . '<figure class="wp-block-image size-full ' . esc_attr($class) . '"><img src="' . esc_url($url)
            . '" alt="' . esc_attr($alt) . '" class="wp-image-' . $id . '"/></figure>' . "\n<!-- /wp:image -->";
    };
    $booking = esc_url(KSTUDIO_BOOKING);
    $community = esc_url(KSTUDIO_COMMUNITY);
    $hero = $image('hero', 'hero-photo', '');
    $light = $image('light', 'work-feature', 'Длинные волнистые волосы с переходом от тёмных корней к светлым прядям');
    $dark = $image('dark', 'work-side', 'Волнистые каштановые волосы, вид со спины');
    $process = $image('process', 'process-photo', 'Пряди, разделённые зажимами для работы колориста');
    $loft = $image('loft', 'loft-photo', 'Пример салона с деревянным потолком, открытым кирпичом и зеркалами');

    return <<<HTML
<!-- wp:group {"tagName":"section","anchor":"top","className":"hero"} -->
<section class="wp-block-group hero" id="top">
$hero
<!-- wp:group {"className":"wrap hero-copy"} -->
<div class="wp-block-group wrap hero-copy">
<!-- wp:heading {"level":1,"anchor":"hero-heading"} -->
<h1 class="wp-block-heading" id="hero-heading">KSTUDIO<br>Пространство Красоты</h1>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Эксперты в индустрии окрашивания</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="$booking">Записаться в VK</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","anchor":"works","className":"works section"} -->
<section class="wp-block-group works section" id="works">
<!-- wp:group {"className":"wrap"} -->
<div class="wp-block-group wrap">
<!-- wp:group {"className":"section-intro"} -->
<div class="wp-block-group section-intro">
<!-- wp:heading -->
<h2 class="wp-block-heading">Оттенки волос</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Референсы для обсуждения с колористом. Здесь можно присмотреть оттенок и взять кадр за ориентир.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"work-grid"} -->
<div class="wp-block-group work-grid">
$light
$dark
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","anchor":"services","className":"services section"} -->
<section class="wp-block-group services section" id="services">
<!-- wp:group {"className":"wrap service-layout"} -->
<div class="wp-block-group wrap service-layout">
<!-- wp:heading -->
<h2 class="wp-block-heading">Услуги и запись</h2>
<!-- /wp:heading -->
$process
<!-- wp:group {"className":"service-answers"} -->
<div class="wp-block-group service-answers">
<!-- wp:details {"showContent":true} -->
<details class="wp-block-details" open><summary>Где посмотреть услуги?</summary>
<!-- wp:paragraph -->
<p>Откройте <a href="$booking">страницу услуг и записи в VK</a>.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->
<!-- wp:details -->
<details class="wp-block-details"><summary>Что показать колористу?</summary>
<!-- wp:paragraph -->
<p>Подготовьте фото своих волос при дневном свете и пример оттенка, который вам нравится.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->
<!-- wp:details -->
<details class="wp-block-details"><summary>Где связаться со студией?</summary>
<!-- wp:paragraph -->
<p>Откройте <a href="$community">сообщество KSTUDIO</a> во ВКонтакте.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","anchor":"studio","className":"studio section"} -->
<section class="wp-block-group studio section" id="studio">
<!-- wp:group {"className":"wrap"} -->
<div class="wp-block-group wrap">
<!-- wp:group {"className":"section-intro"} -->
<div class="wp-block-group section-intro">
<!-- wp:heading -->
<h2 class="wp-block-heading">Студия KSTUDIO</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Студия окрашивания волос в стиле лофт. На фото — пример такого интерьера.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
$loft
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="$booking">Записаться в VK</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
HTML;
}

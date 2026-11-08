---
name: KSTUDIO
description: Графитовый лофт, тёплое дерево и крупная фотография волос.
colors:
  primary: "#c59c79"
  graphite: "#171716"
  charcoal: "#232322"
  cream-ink: "#f4efe8"
  muted-ink: "#c9c1b7"
  milk-paper: "#eee6da"
  warm-ink: "#211e1b"
  gallery-paper: "#e9e3da"
  rule: "#57504a"
  photo-rule: "#80716a"
  paper-focus: "#fff7eb"
typography:
  display:
    fontFamily: 'Commissioner, "Segoe UI", sans-serif'
    fontWeight: 420
    lineHeight: 0.8
  headline:
    fontFamily: 'Commissioner, "Segoe UI", sans-serif'
    fontWeight: 460
    lineHeight: 1.02
    letterSpacing: "-0.035em"
  wordmark:
    fontFamily: 'Commissioner, "Segoe UI", sans-serif'
    fontSize: "30px"
    fontWeight: 720
    lineHeight: 1
    letterSpacing: "-0.025em"
  body:
    fontFamily: '"Golos Text", "Segoe UI", sans-serif'
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.55
  action:
    fontFamily: '"Golos Text", "Segoe UI", sans-serif'
    fontSize: "18px"
    fontWeight: 620
    lineHeight: 1.55
  caption:
    fontFamily: '"Golos Text", "Segoe UI", sans-serif'
    fontSize: "14px"
    fontWeight: 400
    lineHeight: 1.55
rounded:
  square: "0px"
spacing:
  gutter-min: "20px"
  gutter-max: "88px"
  container-max: "1540px"
  section-narrow: "56px"
  split-gap: "25px"
  touch-min: "44px"
components:
  button-primary:
    backgroundColor: "{colors.milk-paper}"
    textColor: "{colors.warm-ink}"
    typography: "{typography.action}"
    rounded: "{rounded.square}"
    padding: "0 20px"
    height: "62px"
    width: "271px"
  button-primary-focus:
    backgroundColor: "{colors.paper-focus}"
  wordmark:
    textColor: "{colors.cream-ink}"
    typography: "{typography.wordmark}"
  navigation:
    textColor: "{colors.cream-ink}"
    typography: "{typography.body}"
    height: "{spacing.touch-min}"
  mobile-menu:
    backgroundColor: "{colors.graphite}"
    textColor: "{colors.cream-ink}"
    typography: "{typography.body}"
    rounded: "{rounded.square}"
    padding: "12px 20px"
  disclosure:
    backgroundColor: "{colors.charcoal}"
    textColor: "{colors.cream-ink}"
    rounded: "{rounded.square}"
    padding: "14px 0"
    height: "72px"
  disclosure-open:
    textColor: "{colors.primary}"
  gallery:
    backgroundColor: "{colors.gallery-paper}"
    textColor: "{colors.warm-ink}"
    rounded: "{rounded.square}"
---

# KSTUDIO · Фактура

## Overview

**Creative North Star: "Фактура"**

Крупные планы волос показывают оттенок, блеск и рисунок прядей. Графитовые плоскости и тёмное дерево переносят на сайт материалы лофта. Крупные заголовки и свободные поля дают фотографии место.

**Key Characteristics:**

- Тёплые нейтрали и бронзовые штрихи.
- Прямые кромки, общий край контента, крупные фотокадры.
- Короткие движения в ответ на действие и однократное проявление фотографии.

## Colors

- **Бронза** (`primary`) выделяет тонкие декоративные линии, фокус на тёмном фоне и открытый вопрос.
- **Графит** (`graphite`) служит фоном страницы, **угольный серый** (`charcoal`) выделяет соседнюю секцию. Основной текст светлый (`cream-ink`), пояснения приглушённые (`muted-ink`).
- **Молочная бумага** (`milk-paper`) выделяет основную кнопку, **кремовая бумага** (`gallery-paper`) обрамляет фотографии. На обеих поверхностях используют тёмный текст (`warm-ink`). `paper-focus` осветляет кнопку в фокусе.
- `rule` разделяет блоки на тёмной плоскости, `photo-rule` отделяет шапку от фотографии.

## Typography

Commissioner задаёт рисунок крупных заголовков и словесного знака. Golos Text используется в абзацах, меню, кнопках и подписях. Обе гарнитуры хранятся локально, системный запасной шрифт — Segoe UI.

- Крупный заголовок масштабируется от 56 до 100 px (`6.18vw`), на узком экране — от 34 до 61 px (`11.28vw`, межстрочный интервал `0.875`). Разрывы строк следуют смыслу фразы.
- Заголовки разделов масштабируются от 42 до 88 px (`5.45vw`). Пояснения к разделам держатся в пределах `40ch` и масштабируются от 16 до 20 px (`1.36vw`).

## Layout

Выравнивайте шапку, текст, фото и подвал по краю общего контейнера. Ширина контейнера ограничена `container-max`, боковое поле растёт с шириной экрана (`clamp(20px, 4.445vw, 88px)`). Фон секции может доходить до краёв экрана. Для парных кадров используйте неравные колонки (`1.42fr / 1fr`) с промежутком от 12 до 34 px (`2.15vw`).

До 760 px включительно сетки складываются в одну колонку, кнопка записи занимает всю ширину, секции растут по содержимому. На широком экране секции главной занимают от одного экрана, их вертикальный отступ меняется от 58 до 100 px (`8vh`).

## Elevation & Depth

Плоскости опираются на смену тона, тонкие линии и контраст масштаба. Поверх фотографии используйте локальное затемнение под текстом, сохраняя видимой фактуру за пределами этой зоны.

## Shapes

Прямые углы у кнопок, меню и рамок. Линии толщиной 1 px отделяют секции и строки. Древесина появляется узкой фактурной вставкой, связанной с краем сетки.

## Components

- **Кнопка записи.** Молочный прямоугольник с текстом слева и диагональной стрелкой 16 px справа. Размеры в токенах задают минимум на широком экране. На узком экране высота от 56 px, текст 16 px. При наведении курсором кнопка поднимается на 1 px, при нажатии смещается на 1 px вниз и слегка сжимается. Для клавиатуры предусмотрено осветление и видимое кольцо фокуса.
- **Навигация.** Словесный знак слева, ссылки по центру, внешний переход справа. При наведении и фокусе появляется подчёркивание. На телефоне ссылки открываются на графитовой панели с разделителями, триггер занимает 44 × 44 px. Escape закрывает меню и возвращает фокус на триггер.
- **Раскрывающийся ответ.** Нативные `details` и `summary`, строки с тонкими границами. При открытии заголовок становится бронзовым, знак «плюс» поворачивается на 45°, под строкой появляется пояснение.
- **Фотокадр.** Фото заполняет прямоугольную рамку, точка кадрирования подбирается под сюжет. Главный кадр серии может один раз проявиться из монохромного отпечатка с полосой света. Системная настройка уменьшенного движения оставляет фото и элементы управления видимыми сразу.

## Do's and Don'ts

### Do

- Сохраняйте детали прядей и естественный цвет в кадрах с оттенками волос.
- Поддерживайте видимый клавиатурный фокус и область нажатия от `touch-min`.
- Указывайте, где показаны референсы. Для каждой фотографии храните сведения об источнике и лицензии.

### Don't

- Избегайте скруглённых плашек и падающих теней на плоскостях.
- Исключайте зацикленное движение и движение фотографии за указателем.

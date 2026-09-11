<?php
$contentView = $contentView ?? 'layouts/main';
$contentData = $contentData ?? [];
$contentData = array_merge($contentData, \App\Libraries\PanelNavigation::data($contentData));

$html = implode('', [
    view('layouts/panel_header', $contentData),
    view('layouts/panel_sidebar', $contentData),
    view($contentView, $contentData),
    view('layouts/panel_footer', $contentData),
]);

$assetBase = rtrim(base_url('assets'), '/');

$html = preg_replace(
    [
        '#((?:src|href)=["\'])(?:\./)?vendor/#',
        '#((?:src|href)=["\'])(?:\./)?css/#',
        '#((?:src|href)=["\'])(?:\./)?js/#',
        '#((?:src|href)=["\'])(?:\./)?images/#',
    ],
    [
        '$1' . $assetBase . '/vendor/',
        '$1' . $assetBase . '/css/',
        '$1' . $assetBase . '/js/',
        '$1' . $assetBase . '/images/',
    ],
    $html
);

echo $html;

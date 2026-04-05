<?php
$contentView = $contentView ?? 'layouts/main';
$contentData = $contentData ?? [];

$html = implode('', [
    view('layouts/header'),
    view('layouts/sidebar'),
    view($contentView, $contentData),
    view('layouts/footer'),
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

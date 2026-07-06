<?php
$pages = $pages ?? [];
$currentSlug = $currentPage['slug'] ?? '';
?>
<div class="business-page-menu mb-4">
    <div class="d-flex flex-wrap gap-2">
        <?php foreach ($pages as $page): ?>
            <?php
            $isActive = (string) ($page['slug'] ?? '') === (string) $currentSlug;
            $menuLabel = trim((string) ($page['menu_label'] ?? $page['title'] ?? ''));
            ?>
            <a class="btn <?= $isActive ? 'btn-primary' : 'btn-light border' ?>" href="<?= base_url('businesses/' . $business['slug'] . '/' . ($page['slug'] ?? '')) ?>">
                <?= esc($menuLabel !== '' ? $menuLabel : $page['title']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

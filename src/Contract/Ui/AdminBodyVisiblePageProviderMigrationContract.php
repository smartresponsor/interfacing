<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Canonical contract for visible Interfacing pages.
 *
 * Visible pages are not allowed to render bespoke admin tables, forms,
 * Bootstrap-like layout, or inline CSS as their primary UI. They must enter the
 * Interfacing ecosystem shell and mount the canonical provider-owned admin body
 * surface: Ant Design ProComponents as primary provider and PrimeReact as the
 * secondary rich-facade provider.
 */
final class AdminBodyVisiblePageProviderMigrationContract
{
    public const PROVIDER_PAGE_TEMPLATE = 'interfacing/admin/body/provider_page.html.twig';
    public const MOUNT_TEMPLATE = 'interfacing/admin/body/mount.html.twig';

    /** @var list<string> */
    public const VISIBLE_PAGE_GLOBS = [
        'template/component/*.twig',
        'template/interfacing/billing/*.twig',
        'template/interfacing/category/*.twig',
        'template/interfacing/doctor*.twig',
        'template/interfacing/doctor/*.twig',
        'template/interfacing/layout/*.twig',
        'template/interfacing/live/screen.html.twig',
        'template/interfacing/order/*.twig',
        'template/interfacing/page/*.twig',
        'template/interfacing/screen/*.twig',
        'template/interfacing/screen/message/*.twig',
        'template/interfacing/widget/data-grid/data-grid.html.twig',
        'template/interfacing/widget/form/form.html.twig',
        'template/interfacing/widget/metric/metric.html.twig',
        'template/interfacing/widget/wizard/wizard.html.twig',
    ];

    /** @var list<string> */
    public const CRUD_MODE_TEMPLATES = [
        'template/interfacing/crud/mode/collection.html.twig',
        'template/interfacing/crud/mode/detail.html.twig',
        'template/interfacing/crud/mode/destructive.html.twig',
        'template/interfacing/crud/mode/form.html.twig',
    ];

    /** @var list<string> */
    public const FORBIDDEN_VISIBLE_PAGE_PATTERNS = [
        '<style',
        '<table',
        '<form',
        'btn btn-',
        'container-fluid',
        'class="row"',
        "class='row'",
    ];
}

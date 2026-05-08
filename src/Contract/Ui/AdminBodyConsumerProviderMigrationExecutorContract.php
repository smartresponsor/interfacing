<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Contract\Ui;

/**
 * Defines the Interfacing-owned migration surface for sibling consumer
 * repositories that still render visible admin/workbench pages through
 * handmade Twig tables, forms, inline CSS, Bootstrap-like classes, or local
 * component shells.
 *
 * The executor is an audit and explicit repair tool only. Bridge owns
 * route/resource adoption; Interfacing renders provider-owned UI. Direct
 * consumer template rewrite is not the primary migration path and requires an
 * explicit force flag.
 */
final class AdminBodyConsumerProviderMigrationExecutorContract
{
    public const TOOL = 'tools/interfacing/admin-body-consumer-provider-migration-executor.php';
    public const TOOL_WRAPPER = 'tools/interfacing/admin-body-consumer-provider-migration-executor.ps1';
    public const DOCUMENTATION = 'docs/interfacing/interfacing-consumer-provider-migration-executor.md';

    public const PROVIDER_PAGE_TEMPLATE = 'interfacing/admin/body/provider_page.html.twig';
    public const PRIMARY_PROVIDER = 'antd-pro';
    public const SECONDARY_PROVIDER = 'primereact';

    public const DEFAULT_CONSUMERS = [
        'Cataloging',
        'Cruding',
        'Vendoring',
    ];

    public const DEFAULT_CONSUMER_ROOTS = [
        '../Cataloging',
        '../Cruding',
        '../Vendoring',
    ];

    public const MIGRATION_MODE_PROVIDER_PAGE = 'provider-page';
    public const FORCE_DIRECT_TEMPLATE_REWRITE_FLAG = '--force-direct-template-rewrite';
    public const MIGRATION_MODE_MACRO_REVIEW = 'macro-review';

    public const FORBIDDEN_PRIMARY_UI_MARKERS = [
        '<table',
        '<form',
        '<style',
        'btn btn-',
        'container-fluid',
        'class="row"',
        "class='row'",
    ];

    /**
     * These are the currently known visible consumer templates surfaced by the
     * provider adoption report for the ecosystem UI milestone.
     */
    public const KNOWN_VISIBLE_TEMPLATE_TARGETS = [
        'Cataloging' => [
            'templates/category/admin/audit.html.twig',
            'templates/category/admin/batch_edit.html.twig',
            'templates/category/admin/dlq.html.twig',
            'templates/category/admin/list.html.twig',
            'templates/category/admin/mobile.html.twig',
            'templates/category/admin/ops.html.twig',
            'templates/category/admin/perms.html.twig',
            'templates/category/admin/_status.html.twig',
            'templates/category/form.html.twig',
            'templates/category/list.html.twig',
            'templates/category/merchant/list.html.twig',
            'templates/category/tree.html.twig',
        ],
        'Cruding' => [
            'templates/crud/edit.html.twig',
            'templates/crud/index.html.twig',
            'templates/crud/new.html.twig',
            'templates/crud/show.html.twig',
            'templates/relation/list.html.twig',
        ],
        'Vendoring' => [
            'templates/ops/vendor_transactions/index.html.twig',
            'templates/vendor/local_dev/home.html.twig',
            'templates/_macros/crud.html.twig',
        ],
    ];
}

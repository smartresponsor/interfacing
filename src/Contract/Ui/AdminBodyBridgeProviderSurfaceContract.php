<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Interfacing\Contract\Ui;

/**
 * Canonical bridge-facing UI surface for Smart Responsor component pages.
 *
 * Bridge/interface code is the integration owner for visible component routes
 * such as catalog, CRUD, vendor, order, payment, shipping, and related
 * e-commerce workbench pages. Consumer components expose resource metadata;
 * the bridge maps that metadata to this Interfacing provider surface; and
 * Interfacing renders the admin body through canonical providers.
 *
 * This contract intentionally forbids direct consumer template rewrites as the
 * primary migration path. Interfacing owns shell, provider mount, schema, and
 * renderer bundle. Bridge owns route/resource adoption.
 */
final class AdminBodyBridgeProviderSurfaceContract
{
    public const TEMPLATE = 'interfacing/bridge/provider_surface.html.twig';
    public const CONTROLLER = 'App\\Interfacing\\Presentation\\Controller\\Interfacing\\BridgeProviderSurfaceController::show';
    public const ROUTE_NAME = 'interfacing_bridge_provider_surface';
    public const ROUTE_PREFIX = '/interfacing/bridge/provider';
    public const BRIDGING_ROUTE_CONFIG = 'config/component/routes.yaml';
    public const BRIDGING_VISIBLE_ROUTE_CONTROLLER = 'App\\Bridging\\Controller\\Interfacing\\BridgeVisibleProviderSurfaceController::show';

    public const PRIMARY_PROVIDER = 'antd-pro';
    public const SECONDARY_PROVIDER = 'primereact';

    public const INTEGRATION_OWNER = 'bridge';
    public const RENDERING_OWNER = 'interfacing';
    public const BUSINESS_OWNER = 'consumer-component';
    public const VISIBLE_ROUTE_ADOPTION_OWNER = 'bridging';

    public const REQUIRED_BRIDGE_CONTEXT_KEYS = [
        'component',
        'resource',
        'operation',
        'surface',
        'title',
    ];

    public const CANONICAL_COMPONENTS = [
        'app',
        'hosthub',
        'cataloging',
        'cruding',
        'vendoring',
        'ordering',
        'paying',
        'shipping',
        'taxating',
        'currencing',
        'messaging',
        'locating',
        'indexing',
        'tagging',
        'paging',
        'objecting',
    ];

    public const CANONICAL_ECOMMERCE_SURFACES = [
        'catalog',
        'category',
        'product',
        'vendor',
        'vendoring',
        'crud',
        'order',
        'payment',
        'refund',
        'shipping',
        'tax',
        'currency',
        'message',
        'location',
        'search',
        'checkout',
        'customer-account',
    ];

    public const FORBIDDEN_BRIDGE_OUTPUT_MARKERS = [
        '<table',
        '<form',
        '<style',
        'btn btn-',
        'container-fluid',
        'class="row"',
        "class='row'",
    ];
}

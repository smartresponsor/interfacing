<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Strict provider-required rendering contract for central admin body surfaces.
 *
 * The admin body is rendered by canonical frontend providers. Twig publishes
 * shell/mount/schema/script wiring only and must not render a parallel CRUD UI.
 */
final readonly class AdminBodyStrictProviderRenderingContract
{
    public const CONTRACT_NAME = 'admin-body-strict-provider-rendering';
    public const CONTRACT_VERSION = '1.0';
    public const CONTRACT_DOC = 'docs/interfacing/interfacing-admin-body-strict-provider-rendering.md';

    public const RENDERING_MODE = 'canonical-provider-required';
    public const PRIMARY_PROVIDER = AdminBodyUiProviderCanonContract::PRIMARY_PROVIDER;
    public const SECONDARY_PROVIDER = AdminBodyUiProviderCanonContract::SECONDARY_PROVIDER;
    public const PROVIDER_BUNDLE = 'interfacing/admin-body/canonical-providers.js';

    public const FORBIDDEN_INLINE_STYLE = '<style';
    public const FORBIDDEN_TWIG_TABLE_BLOCK = 'admin_body_table_fallback';
    public const FORBIDDEN_TWIG_CARD_BLOCK = 'admin_body_cards_fallback';
    public const FORBIDDEN_TWIG_FORM_BLOCK = 'admin_body_form_fallback';
    public const FORBIDDEN_BOOTSTRAP_CLASS = 'btn btn-';

    /** @return list<string> */
    public static function requiredFiles(): array
    {
        return [
            self::CONTRACT_DOC,
            '.interfacing/workspace/vite.config.ts',
            '.interfacing/workspace/tsconfig.json',
            '.interfacing/workspace/src/admin-body/main.tsx',
            '.interfacing/workspace/src/admin-body/AntDesignProAdminBodyProvider.tsx',
            '.interfacing/workspace/src/admin-body/PrimeReactAdminBodyProvider.tsx',
            'template/interfacing/admin/body/mount.html.twig',
            'template/interfacing/admin/body/schema.html.twig',
        ];
    }
}

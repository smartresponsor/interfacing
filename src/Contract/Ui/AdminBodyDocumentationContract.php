<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Canonical documentation entrypoints for the admin body contract.
 *
 * This contract keeps the docs surface indexable for guards and consumers.
 * It does not define rendering behavior; rendering remains owned by the
 * admin body schema, runtime, and provider contracts.
 */
final readonly class AdminBodyDocumentationContract
{
    public const CONTRACT_INDEX = 'docs/interfacing/interfacing-admin-body-contract-index.md';
    public const CONSUMER_GUIDE = 'docs/interfacing/interfacing-admin-body-consumer-guide.md';
    public const SCHEMA_MANIFEST_DOC = 'docs/interfacing/interfacing-admin-body-schema-manifest-contract.md';
    public const RUNTIME_SMOKE_DOC = 'docs/interfacing/interfacing-admin-body-runtime-smoke-harness.md';

    public const CANONICAL_BASE_MODEL = 'single-ecosystem-shell-central-admin-body-slot';
    public const PRIMARY_PROVIDER = AdminBodyMountContract::PROVIDER_ANTD_PRO;
    public const SECONDARY_PROVIDER = AdminBodyMountContract::SECONDARY_PROVIDER_PRIMEREACT;

    /** @return list<string> */
    public static function requiredDocs(): array
    {
        return [
            self::CONTRACT_INDEX,
            self::CONSUMER_GUIDE,
            self::SCHEMA_MANIFEST_DOC,
            self::RUNTIME_SMOKE_DOC,
        ];
    }
}

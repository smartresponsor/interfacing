<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Multi-consumer adoption runner contract for visible provider-rendered pages.
 *
 * Interfacing owns the provider canon, but consumer repositories own their visible
 * pages. This runner is the bridge: it invokes the consumer adoption audit against
 * sibling repositories without pretending that Interfacing can migrate them from
 * inside this package.
 */
final readonly class AdminBodyConsumerProviderAdoptionRunnerContract
{
    public const CONTRACT_NAME = 'admin-body-consumer-provider-adoption-runner';
    public const CONTRACT_VERSION = '1.0';

    public const RUNNER_ENTRYPOINT = 'tools/interfacing/admin-body-consumer-provider-adoption-runner.php';
    public const RUNNER_WRAPPER = 'tools/interfacing/admin-body-consumer-provider-adoption-runner.ps1';
    public const RUNNER_DOC = 'docs/interfacing/interfacing-visible-page-provider-adoption-runner.md';

    public const AUDIT_ENTRYPOINT = AdminBodyConsumerProviderAdoptionContract::AUDIT_ENTRYPOINT;

    /** @var list<string> */
    public const DEFAULT_SIBLING_CONSUMER_ROOTS = [
        '../App',
        '../HostHub',
        '../Cruding',
        '../Vendoring',
    ];

    public const DEFAULT_REPORT_PATH = 'var/interfacing-visible-page-provider-adoption-runner.md';

    /** @return list<string> */
    public static function requiredFiles(): array
    {
        return [
            self::RUNNER_ENTRYPOINT,
            self::RUNNER_WRAPPER,
            self::RUNNER_DOC,
            self::AUDIT_ENTRYPOINT,
            AdminBodyConsumerProviderAdoptionContract::CONTRACT_DOC,
            AdminBodyUiProviderCanonContract::CONTRACT_DOC,
        ];
    }

    /** @return list<string> */
    public static function commandPlan(): array
    {
        return [
            'php tools/interfacing/admin-body-consumer-provider-adoption-runner.php --consumer-root=../App --consumer-root=../Cruding --consumer-root=../Vendoring --format=markdown --output=var/interfacing-visible-page-provider-adoption-runner.md',
            'php tools/interfacing/admin-body-consumer-provider-adoption-runner.php --consumer-root=../Cruding --strict',
        ];
    }
}

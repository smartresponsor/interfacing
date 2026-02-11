<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Security;

/**
 *
 */

/**
 *
 */
interface PermissionNamerInterface
{
    /**
     * @param string $screenId
     * @return string
     */
    public function screen(string $screenId): string;

    /**
     * @param string $screenId
     * @param string $actionId
     * @return string
     */
    public function action(string $screenId, string $actionId): string;

    /**
     * @param string $raw
     * @return string
     */
    public function normalizeId(string $raw): string;
}

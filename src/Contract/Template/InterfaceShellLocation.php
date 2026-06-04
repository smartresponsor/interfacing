<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Template;

/**
 * Canonical shell location keys for neutral surface payloads.
 */
final class InterfaceShellLocation
{
    public const string TOP_BAR = 'top_bar';
    public const string LEFT_NAVIGATION = 'left_navigation';
    public const string BODY_HEADER = 'body_header';
    public const string BODY_TOOLBAR = 'body_toolbar';
    public const string BODY_CONTENT = 'body_content';
    public const string RIGHT_CONTEXT = 'right_context';
    public const string BOTTOM_BAR = 'bottom_bar';

    private function __construct()
    {
    }
}

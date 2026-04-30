<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\Contract\View\ShellFooterGroup;
use App\Interfacing\Contract\View\ShellFooterLink;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellFooterProviderInterface;

final class ShellFooterProvider implements ShellFooterProviderInterface
{
    public function provide(): array
    {
        return [
            new ShellFooterGroup('help', 'Help', [
                new ShellFooterLink('help.faq', 'FAQ', '#faq'),
                new ShellFooterLink('help.support', 'Support', '#support'),
                new ShellFooterLink('help.docs', 'Docs', '#docs'),
            ]),
            new ShellFooterGroup('policy', 'Policy', [
                new ShellFooterLink('policy.privacy', 'Privacy', '#privacy'),
                new ShellFooterLink('policy.terms', 'Terms', '#terms'),
                new ShellFooterLink('policy.security', 'Security', '#security'),
            ]),
            new ShellFooterGroup('platform', 'Platform', [
                new ShellFooterLink('platform.status', 'Status', '#status'),
                new ShellFooterLink('platform.about', 'About', '#about'),
                new ShellFooterLink('platform.contact', 'Contact', '#contact'),
            ]),
        ];
    }
}

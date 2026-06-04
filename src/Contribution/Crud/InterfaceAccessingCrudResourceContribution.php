<?php

declare(strict_types=1);

namespace App\Interfacing\Contribution\Crud;

use App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceDescriptorContributionInterface;

final class InterfaceAccessingCrudResourceContribution extends InterfaceAbstractCrudResourceContribution implements InterfaceCrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('accessing.account', 'Accessing', 'Account', 'account', 'Canonical CRUD grammar for account-oriented records once Accessing publishes generic CRUD resources.'),
            $this->canonicalResource('accessing.operator-account', 'Accessing', 'Operator account', 'operator-account', 'Operator account CRUD path shown proactively for future host hookups.'),
            $this->canonicalResource('accessing.session', 'Accessing', 'Session', 'session', 'Useful for auditing which generic session resources have already been wired versus which still 404.'),
            $this->canonicalResource('accessing.security-event', 'Accessing', 'Security event', 'security-event', 'Canonical CRUD path only; custom Accessing security consoles stay in component-specific handoff screens.'),
        ];
    }
}

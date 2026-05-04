<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class AccessingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('accessing.account', 'Accessing', 'Account', 'account', 'Canonical CRUD grammar for account-oriented records once Accessing publishes generic CRUD resources.'),
            $this->canonicalResource('accessing.operator-account', 'Accessing', 'Operator account', 'operator-account', 'Operator account CRUD path shown proactively for future host hookups.'),
            $this->canonicalResource('accessing.session', 'Accessing', 'Session', 'session', 'Useful for auditing which generic session resources have already been wired versus which still 404.'),
            $this->canonicalResource('accessing.security-event', 'Accessing', 'Security event', 'security-event', 'Canonical CRUD path only; custom Accessing security consoles stay in component-specific bridges.'),
        ];
    }
}

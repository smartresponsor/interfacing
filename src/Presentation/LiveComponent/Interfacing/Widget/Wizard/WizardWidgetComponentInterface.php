<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Widget\Wizard;

use App\Interfacing\Contract\View\WizardProgress;
use App\Interfacing\Contract\View\WizardSpec;
use App\Interfacing\Contract\View\WizardStepSpec;

interface WizardWidgetComponentInterface
{
    public function spec(): WizardSpec;

    public function progress(): WizardProgress;

    public function step(): WizardStepSpec;

    public function fieldValue(string $id): mixed;

    public function fieldErrorFor(string $id): string;
}

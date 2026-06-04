<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\LiveComponent\Widget\Wizard;

use App\Interfacing\Contract\View\InterfaceWizardProgress;
use App\Interfacing\Contract\View\InterfaceWizardSpec;
use App\Interfacing\Contract\View\InterfaceWizardStepSpec;

interface InterfaceWizardWidgetComponentInterface
{
    public function spec(): InterfaceWizardSpec;

    public function progress(): InterfaceWizardProgress;

    public function step(): InterfaceWizardStepSpec;

    public function fieldValue(string $id): mixed;

    public function fieldErrorFor(string $id): string;
}

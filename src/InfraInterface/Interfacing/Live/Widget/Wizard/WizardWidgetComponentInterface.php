<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\InfraInterface\Interfacing\Live\Widget\Wizard;

use App\Domain\Interfacing\Model\Wizard\WizardProgress;
use App\Domain\Interfacing\Model\Wizard\WizardSpec;
use App\Domain\Interfacing\Model\Wizard\WizardStepSpec;

interface WizardWidgetComponentInterface
{
    public function spec(): WizardSpec;

    public function progress(): WizardProgress;

    public function step(): WizardStepSpec;

    public function fieldValue(string $id): mixed;

    public function fieldErrorFor(string $id): string;
}

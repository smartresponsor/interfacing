<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\InfraInterface\Interfacing\Live\Widget\Wizard;

use App\Domain\Interfacing\Model\Wizard\WizardProgress;
use App\Domain\Interfacing\Model\Wizard\WizardSpec;
use App\Domain\Interfacing\Model\Wizard\WizardStepSpec;

/**
 *
 */

/**
 *
 */
interface WizardWidgetComponentInterface
{
    /**
     * @return \App\Domain\Interfacing\Model\Wizard\WizardSpec
     */
    public function spec(): WizardSpec;

    /**
     * @return \App\Domain\Interfacing\Model\Wizard\WizardProgress
     */
    public function progress(): WizardProgress;

    /**
     * @return \App\Domain\Interfacing\Model\Wizard\WizardStepSpec
     */
    public function step(): WizardStepSpec;

    /**
     * @param string $id
     * @return mixed
     */
    public function fieldValue(string $id): mixed;

    /**
     * @param string $id
     * @return string
     */
    public function fieldErrorFor(string $id): string;
}

<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing;

/*
 * Local compatibility alias for older standalone console/bootstrap references.
 *
 * Canonical package kernel: App\Interfacing\InterfaceKernel.
 */
\class_alias(InterfaceKernel::class, __NAMESPACE__.'\\Kernel');

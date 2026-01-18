<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\HttpInterface\Interfacing\Health\Controller;

use Symfony\Component\HttpFoundation\Response;

interface InterfacingHealthControllerInterface
{
    public function health(): Response;
}

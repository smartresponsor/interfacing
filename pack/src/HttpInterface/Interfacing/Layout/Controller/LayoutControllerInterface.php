<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\HttpInterface\Interfacing\Layout\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface LayoutControllerInterface
{
    public function screen(Request $request, string $slug): Response;

    public function home(Request $request): Response;
}

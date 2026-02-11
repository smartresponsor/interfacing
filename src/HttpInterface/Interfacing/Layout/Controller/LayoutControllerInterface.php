<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Http\Interfacing\Layout\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */

/**
 *
 */
interface LayoutControllerInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request, string $slug = 'home'): Response;
}

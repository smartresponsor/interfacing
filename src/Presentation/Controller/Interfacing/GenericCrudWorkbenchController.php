<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\Kernel;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\GenericCrudWorkbenchViewBuilderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Generic CRUD workbench bridge for known Smart Responsor resources.
 *
 * This controller intentionally does not own business persistence. It renders
 * the ordinary Interfacing CRUD workbench page; the workbench template itself
 * enters the same ecosystem base shell as every other connected application.
 */
final readonly class GenericCrudWorkbenchController
{
    private const GENERIC_CRUD_TEMPLATE = 'interfacing/crud/generic.html.twig';

    public function __construct(
        private GenericCrudWorkbenchViewBuilderInterface $viewBuilder,
        private InterfacingRendererInterface $renderer,
        #[Autowire(service: 'profiler')]
        private ?Profiler $profiler,
        #[Autowire(service: 'cache.app.recorder_inner')]
        private CacheInterface $responseCache,
    ) {
    }

    public function show(Request $request): Response
    {
        if (null !== $this->profiler) {
            $this->profiler->disable();
        }

        $startedAt = hrtime(true);
        $interactive = in_array((string) $request->query->get('interactive', ''), ['1', 'true', 'yes'], true);
        $resourcePath = (string) $request->attributes->get('resourcePath', trim($request->getPathInfo(), '/'));
        $resourceLabel = $this->humanize($resourcePath);

        $context = [
            'adminProviderPageTitle' => $resourceLabel,
            'adminProviderResourceName' => '' !== $resourcePath ? $resourcePath : 'resource',
            'adminProviderResourceLabel' => $resourceLabel,
            'adminProviderOperation' => 'index',
            'adminProviderSurface' => 'admin',
            'screenId' => 'crud.generic',
            'disableProfiler' => true,
        ];

        if ($interactive) {
            $context += $this->viewBuilder->build($request);
        }

        $cacheKey = 'interfacing.generic-crud.html.v2.'.sha1($request->getRequestUri());

        $cacheHit = true;
        $html = $this->responseCache->get($cacheKey, function (ItemInterface $item) use ($context, &$cacheHit): string {
            $cacheHit = false;
            $item->expiresAfter(300);

            return $this->renderer->render(self::GENERIC_CRUD_TEMPLATE, $context)->getContent();
        });

        $response = new Response($html);
        $response->headers->set('X-Interfacing-Cache', $cacheHit ? 'hit' : 'miss');
        $response->headers->set('X-Interfacing-Controller-ms', number_format((hrtime(true) - $startedAt) / 1_000_000, 2, '.', ''));
        $response->headers->set('X-Interfacing-KernelBoot-ms', number_format(Kernel::lastBootMs() ?? 0.0, 2, '.', ''));

        return $response;
    }

    private function humanize(string $value): string
    {
        $value = trim(str_replace(['_', '-', '/'], ' ', $value));
        $value = preg_replace('/\s+/', ' ', $value) ?: $value;

        return '' === $value ? 'Crud Explorer' : ucwords($value);
    }
}

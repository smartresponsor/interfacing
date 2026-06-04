<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\BuilderInterface\View\InterfaceGenericCrudWorkbenchViewBuilderInterface;
use App\Interfacing\InterfaceKernel;
use App\Interfacing\ProviderInterface\Messaging\InterfaceMessagingShowcaseProviderInterface;
use App\Interfacing\Resolver\Crud\InterfaceCrudRouteContextResolver;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Scoped internal CRUD handoff for known Smart Responsor resources.
 *
 * This controller intentionally does not own business persistence. It renders
 * the ordinary Interfacing CRUD workbench page; the workbench template itself
 * enters the same ecosystem base shell as every other connected application.
 */
final readonly class InterfaceGenericCrudWorkbenchController
{
    private const GENERIC_CRUD_TEMPLATE = 'provider/handoff_surface.html.twig';

    public function __construct(
        private InterfaceGenericCrudWorkbenchViewBuilderInterface $viewBuilder,
        private InterfaceCrudRouteContextResolver $routeContextResolver,
        private InterfaceRendererInterface $renderer,
        private InterfaceMessagingShowcaseProviderInterface $messagingShowcaseProvider,
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
        $routeContext = $this->routeContextResolver->resolve($request, 'resource', 'index', 'admin');
        $resourcePath = '' !== $routeContext->resourcePath ? $routeContext->resourcePath : trim($request->getPathInfo(), '/');
        $messagingSection = $this->messagingSectionFromRequest($request, $resourcePath);
        if (null !== $messagingSection) {
            return $this->renderMessagingShowcase($request, $messagingSection);
        }

        $resourceLabel = $this->humanize($resourcePath);
        $operation = '' !== $routeContext->operation ? $routeContext->operation : 'index';
        $normalizedResourcePath = str_replace('_', '-', trim($resourcePath, '/')) ?: 'resource';
        $declaredOwner = $request->query->get('component');
        $component = is_string($declaredOwner) && '' !== $declaredOwner ? $declaredOwner : 'external';
        $surfaceKey = $this->surfaceKey($normalizedResourcePath);

        $context = [
            'handoffComponent' => $component,
            'handoffSurfaceKey' => $surfaceKey,
            'handoffResource' => $normalizedResourcePath,
            'handoffOperation' => $operation,
            'handoffSurface' => '' !== $routeContext->surface ? $routeContext->surface : 'admin',
            'handoffTitle' => $resourceLabel,
            'handoffCollectionLabel' => $resourceLabel,
            'screenId' => 'crud.generic',
            'disableProfiler' => true,
        ];

        if ($interactive) {
            $context += $this->viewBuilder->build($request);
        }

        $cacheKey = 'interfacing.generic-crud.html.v70.'.sha1($request->getRequestUri());

        $cacheHit = true;
        $html = $this->responseCache->get($cacheKey, function (ItemInterface $item) use ($context, &$cacheHit): string {
            $cacheHit = false;
            $item->expiresAfter(300);

            return $this->renderer->render(self::GENERIC_CRUD_TEMPLATE, $context)->getContent();
        });

        $response = new Response($html);
        $response->headers->set('X-Interfacing-Cache', $cacheHit ? 'hit' : 'miss');
        $response->headers->set('X-Interfacing-Controller-ms', number_format((hrtime(true) - $startedAt) / 1_000_000, 2, '.', ''));
        $response->headers->set('X-Interfacing-KernelBoot-ms', number_format(InterfaceKernel::lastBootMs() ?? 0.0, 2, '.', ''));

        return $response;
    }

    private function renderMessagingShowcase(Request $request, string $section): Response
    {
        $criteria = $request->query->all();
        $criteria['section'] = $section;

        return $this->renderer->render('@Interfacing/message/messaging_showcase.html.twig', [
            'screenId' => 'messaging.showcase',
            'title' => 'Messaging · Smart Responsor',
            'messagingShowcase' => $this->messagingShowcaseProvider->provide($criteria),
        ]);
    }

    private function messagingSectionFromRequest(Request $request, string $resourcePath): ?string
    {
        $path = trim($request->getPathInfo(), '/');
        $segments = array_values(array_filter(explode('/', $path), static fn (string $segment): bool => '' !== $segment));
        $allowedSections = ['inbox', 'compose', 'rooms', 'chats', 'search', 'digest'];

        if ('message' === trim($resourcePath, '/') || 'message' === ($segments[0] ?? null)) {
            $candidate = (string) ($segments[1] ?? $request->attributes->get('id', 'overview'));

            return in_array($candidate, $allowedSections, true) ? $candidate : 'overview';
        }

        return null;
    }

    private function surfaceKey(string $resourcePath): string
    {
        $first = strtolower(strtok(str_replace('_', '/', $resourcePath), '/') ?: $resourcePath);

        return match ($first) {
            'category', 'product', 'collection', 'attribute' => 'catalog',
            'payment-intent', 'payment-method', 'refund' => 'payment',
            'money', 'money-format' => 'currency',
            'exchange', 'exchange-rate' => 'exchange',
            'media', 'document' => 'attachment',
            'index-record' => 'search',
            'commission-plan' => 'commission',
            default => '' !== $first ? $first : 'surface',
        };
    }

    private function humanize(string $value): string
    {
        $value = trim(str_replace(['_', '-', '/'], ' ', $value));
        $value = preg_replace('/\s+/', ' ', $value) ?: $value;

        return '' === $value ? 'Crud Explorer' : ucwords($value);
    }
}

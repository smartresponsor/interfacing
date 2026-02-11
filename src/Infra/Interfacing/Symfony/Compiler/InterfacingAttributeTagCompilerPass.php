<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Infra\Interfacing\Symfony\Compiler;

    use ReflectionClass;
use App\Domain\Interfacing\Attribute\AsInterfacingAction;
use App\Domain\Interfacing\Attribute\AsInterfacingScreen;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

    /**
     *
     */

    /**
     *
     */
    final class InterfacingAttributeTagCompilerPass implements CompilerPassInterface
{
    public const TAG_SCREEN = 'interfacing.screen';
    public const TAG_ACTION = 'interfacing.action';

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @return void
     */
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->getDefinitions() as $serviceId => $definition) {
            $class = $definition->getClass();
            if (!is_string($class) || $class === '') {
                continue;
            }

            if (!class_exists($class)) {
                continue;
            }

            $ref = new ReflectionClass($class);

            foreach ($ref->getAttributes(AsInterfacingScreen::class) as $attr) {
                $meta = $attr->newInstance();
                $definition->addTag(self::TAG_SCREEN, [
                    'id' => $meta->id,
                    'title' => $meta->title,
                    'navGroup' => $meta->navGroup,
                    'navIcon' => $meta->navIcon,
                    'navOrder' => $meta->navOrder,
                    'isVisible' => $meta->isVisible,
                ]);
            }

            foreach ($ref->getAttributes(AsInterfacingAction::class) as $attr) {
                $meta = $attr->newInstance();
                $definition->addTag(self::TAG_ACTION, [
                    'screenId' => $meta->screenId,
                    'id' => $meta->id,
                    'title' => $meta->title,
                    'order' => $meta->order,
                ]);
            }
        }
    }
}


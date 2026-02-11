<?php
declare(strict_types=1);

namespace App\Infra\Interfacing\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 *
 */

/**
 *
 */
#[AsCommand(
    name: 'interfacing:screen:validate',
    description: 'Validate Interfacing screen configuration against Symfony routes.',
)]
final class InterfacingScreenValidateCommand extends Command
{
    /**
     * @param \Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface $parameters
     * @param \Symfony\Component\Routing\RouterInterface $router
     */
    public function __construct(
        private readonly ParameterBagInterface $parameters,
        private readonly RouterInterface $router,
    ) {
        parent::__construct();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $value = $this->parameters->get('interfacing.screens');

        if (!is_array($value)) {
            $output->writeln('<error>Parameter "interfacing.screens" is not configured as array.</error>');
            return Command::FAILURE;
        }

        $routes = $this->router->getRouteCollection();

        $errors = [];
        $checkedCount = 0;

        foreach ($value as $screen) {
            if (!is_array($screen)) {
                continue;
            }

            $id = isset($screen['id']) ? (string) $screen['id'] : '';
            $routeName = isset($screen['route']) ? (string) $screen['route'] : '';

            if ($id === '') {
                continue;
            }

            $checkedCount++;

            if ($routeName === '') {
                $errors[] = sprintf('Screen "%s" has no "route" configured.', $id);
                continue;
            }

            if ($routes->get($routeName) === null) {
                $errors[] = sprintf('Screen "%s" refers to unknown route "%s".', $id, $routeName);
            }
        }

        if ($errors !== []) {
            $output->writeln('<error>Interfacing screen configuration errors:</error>');
            foreach ($errors as $error) {
                $output->writeln(sprintf('  - %s', $error));
            }
            return Command::FAILURE;
        }

        $output->writeln(sprintf(
            '<info>OK</info> - %d Interfacing screens validated against Symfony routes.',
            $checkedCount,
        ));

        return Command::SUCCESS;
    }
}

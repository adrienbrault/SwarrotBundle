<?php

namespace Swarrot\SwarrotBundle;

use Swarrot\SwarrotBundle\DependencyInjection\CompilerPass\DecoratorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Console\Application;

class SwarrotBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        $container = $application->getKernel()->getContainer();

        $commands = $container->getParameter('swarrot.commands');
        foreach ($commands as $command) {
            $application->add($container->get($command));
        }
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DecoratorCompilerPass());
    }
}

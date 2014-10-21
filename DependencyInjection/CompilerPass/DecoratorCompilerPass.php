<?php

namespace Swarrot\SwarrotBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DecoratorCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $registryDefinition = $container->getDefinition('swarrot.decorator.decorator_registry');

        foreach ($container->findTaggedServiceIds('swarrot.decorator') as $id => $tags) {
            foreach ($tags as $tag) {
                $priority = isset($tag['priority']) ? $tag['priority'] : 0;
                if (!isset($tag['alias'])) {
                    throw new \InvalidArgumentException('swarrot.decorator tags must have an alias.');
                }
                $alias = $tag['alias'];

                $registryDefinition->addMethodCall(
                    'setDecorator',
                    [
                        $alias,
                        new Reference($id),
                        $priority,
                    ]
                );
            }
        }
    }
}

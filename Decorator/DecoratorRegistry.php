<?php

namespace Swarrot\SwarrotBundle\Decorator;

use Swarrot\Processor\ConfigurableInterface;
use Swarrot\Processor\Decorator\DecoratorInterface;
use Swarrot\Processor\Decorator\DecoratorStackBuilder;
use Swarrot\Processor\Decorator\DecoratorStackFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecoratorRegistry
{
    /**
     * @var DecoratorInterface[]
     */
    private $decorators = [];

    /**
     * @var DecoratorStackFactory
     */
    private $decoratorStackFactory;

    public function __construct(DecoratorStackFactory $decoratorStackFactory)
    {
        $this->decoratorStackFactory = $decoratorStackFactory;
    }

    public function setDecorator($name, DecoratorInterface $decorator, $priority = 0)
    {
        $this->decorators[$name] = [
            $decorator,
            $priority,
        ];
    }

    public function createBuilder($blackList)
    {
        $builder = new DecoratorStackBuilder($this->decoratorStackFactory);
        foreach ($this->decorators as $name => $decorator) {
            if (in_array($name, $blackList)) {
                continue;
            }

            $builder->addDecorator($decorator[0], $decorator[1]);
        }

        return $builder;
    }

    public function has($name)
    {
        return array_key_exists($name, $this->decorators);
    }

    public function getNames()
    {
        return array_keys($this->decorators);
    }
}

<?php


namespace Lobster\Events;


use Psr\Container\ContainerInterface;


/**
 * Class LazyListener
 * @package Lobster\Events
 */
class LazyListener {

    /**
     * @var string|null
     */
    private $method;

    /**
     * @var string
     */
    private $service;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     * @param string $service
     * @param string|null $method
     * @return LazyListener
     */
    public static function create(ContainerInterface $container, string $service, string $method = null) : self {
        return new static($container, $service, $method);
    }

    /**
     * LazyListener constructor.
     * @param ContainerInterface $container
     * @param string $service
     * @param string $method
     */
    public function __construct(ContainerInterface $container, string $service, string $method = null) {
        $this->method = $method;
        $this->service = $service;
        $this->container = $container;
    }

    /**
     * @param object $event
     */
    public function __invoke(object $event) : void {

        $listener = $this->container->get($this->service);

        if($this->method !== null){
            $listener = [$listener, $this->method];
        }

        $listener($event);
    }
}
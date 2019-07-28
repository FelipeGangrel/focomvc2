<?php

namespace Foco\Controller;

use Psr\Container\ContainerInterface;

class Controller
{
    protected $container;
    protected $database;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->database = $container->database;
    }
}
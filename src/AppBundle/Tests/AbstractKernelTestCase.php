<?php


namespace AppBundle\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractKernelTestCase extends KernelTestCase
{

    /**
     * @var ContainerInterface
     */
    protected $container;
    protected $router;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }

    public function getRouter()
    {
        if (is_null($this->router)) {
            return $this->router = $this->container->get('router');
        }
        return $this->router;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEnityManager(): EntityManagerInterface
    {
        return $this->container->get('doctrine')->getManager();
    }

}
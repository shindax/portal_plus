<?php


namespace Sibintek\InformerBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class InformerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {

    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

}
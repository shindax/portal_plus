<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 07.04.2020
 * Time: 15:27
 */

namespace Sibintek\ConsentPersData;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sibintek\ConsentPersData\DependencyInjection\ConsentPersDataExtension;

class ConsentPersDataBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {

    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new ConsentPersDataExtension();
        }

        return $this->extension;
    }

}
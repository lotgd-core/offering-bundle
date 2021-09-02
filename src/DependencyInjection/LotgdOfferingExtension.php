<?php

/**
 * This file is part of "LoTGD Bundle Offerring".
 *
 * @see https://github.com/lotgd-core/BUNDLE-bundle
 *
 * @license https://github.com/lotgd-core/BUNDLE-bundle/blob/master/LICENSE.txt
 * @author IDMarinas
 *
 * @since 0.1.0
 */

namespace Lotgd\Bundle\OfferingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class LotgdOfferingExtension extends Extension
{
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));

        $loader->load('services.php');
    }
}

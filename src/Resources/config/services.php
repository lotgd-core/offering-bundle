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

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lotgd\Bundle\OfferingBundle\Controller\OfferingController;
use Lotgd\Bundle\OfferingBundle\EventSubscriber\OfferingSubscriber;
use Lotgd\Bundle\OfferingBundle\OccurrenceSubscriber\OfferingSubscriber as OccurrenceSubscriberOfferingSubscriber;
use Lotgd\Core\Http\Response;
use Lotgd\Core\Lib\Settings;
use Lotgd\Core\Navigation\Navigation;

return static function (ContainerConfigurator $container)
{
    $container->services()
        //-- Controller
        ->set(OfferingController::class)
            ->args([
                new ReferenceConfigurator(Navigation::class),
                new ReferenceConfigurator(Response::class),
                new ReferenceConfigurator(Settings::class)
            ])
            ->call('setContainer', [
                new ReferenceConfigurator('service_container'),
            ])
            ->tag('controller.service_arguments')

        //-- Event Subscribers
        ->set(OfferingSubscriber::class)
            ->tag('kernel.event_subscriber')

        //-- Occurrence Subscribers
        ->set(OccurrenceSubscriberOfferingSubscriber::class)
            ->args([
                new ReferenceConfigurator('lotgd.core.log'),
                new ReferenceConfigurator(Response::class),
                new ReferenceConfigurator('twig'),
                new ReferenceConfigurator(Navigation::class),
            ])
            ->tag('lotgd_core.occurrence_subscriber')
    ;
};

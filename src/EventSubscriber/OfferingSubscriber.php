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

namespace Lotgd\Bundle\OfferingBundle\EventSubscriber;

use Lotgd\Core\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OfferingSubscriber implements EventSubscriberInterface
{
    public function newday()
    {
        set_module_pref('seen', 0, 'bundle_offering');
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::PAGE_NEWDAY => 'newday',
        ];
    }
}

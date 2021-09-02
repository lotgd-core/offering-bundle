<?php

/**
 * This file is part of "LoTGD Bundle Offerring".
 *
 * @see https://github.com/lotgd-core/offerring-bundle
 *
 * @license https://github.com/lotgd-core/offerring-bundle/blob/master/LICENSE.txt
 * @author IDMarinas
 *
 * @since 0.1.0
 */

namespace Lotgd\Bundle\OfferingBundle\Pattern;

use Lotgd\Bundle\OfferingBundle\Controller\OfferingController;

trait ModuleUrlTrait
{
    public function getModuleUrl(string $method, string $query = '')
    {
        return "runmodule.php?method={$method}&controller=".urlencode(OfferingController::class).$query;
    }
}

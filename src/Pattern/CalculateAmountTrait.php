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

trait CalculateAmountTrait
{
    public function calculateAmount(): int
    {
        global $session;

        return round(max(1, $session['user']['dragonkills'] * 10) * $session['user']['level'] * (max(1, 5000 - $session['user']['maxhitpoints'])) / 20000);
    }
}

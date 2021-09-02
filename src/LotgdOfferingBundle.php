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

namespace Lotgd\Bundle\OfferingBundle;

use Lotgd\Bundle\Contract\LotgdBundleInterface;
use Lotgd\Bundle\Contract\LotgdBundleTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class LotgdOfferingBundle extends Bundle implements LotgdBundleInterface
{
    use LotgdBundleTrait;

    public const TRANSLATION_DOMAIN = 'bundle_offering';

    /**
     * {@inheritDoc}
     */
    public function getLotgdName(): string
    {
        return 'Offerring';
    }

    /**
     * {@inheritDoc}
     */
    public function getLotgdVersion(): string
    {
        return '0.1.0';
    }

    /**
     * {@inheritDoc}
     */
    public function getLotgdIcon(): ?string
    {
        return 'gem';
    }

    /**
     * {@inheritDoc}
     */
    public function getLotgdDescription(): string
    {
        return 'Special event that you can find soul gem in Graveyard.';
    }

    /**
     * {@inheritDoc}
     */
    public function getLotgdDownload(): ?string
    {
        return 'https://github.com/lotgd-core/offerring-bundle';
    }
}

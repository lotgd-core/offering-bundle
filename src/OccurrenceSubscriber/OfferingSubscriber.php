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

namespace Lotgd\Bundle\OfferingBundle\OccurrenceSubscriber;

use Lotgd\Bundle\OfferingBundle\LotgdOfferingBundle;
use Lotgd\Bundle\OfferingBundle\Pattern\CalculateAmountTrait;
use Lotgd\Bundle\OfferingBundle\Pattern\ModuleUrlTrait;
use Lotgd\Core\Http\Request;
use Lotgd\Core\Http\Response;
use Lotgd\Core\Lib\Settings;
use Lotgd\Core\Log;
use Lotgd\Core\Navigation\Navigation;
use Lotgd\CoreBundle\OccurrenceBundle\OccurrenceSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Twig\Environment;

class OfferingSubscriber implements OccurrenceSubscriberInterface
{
    use ModuleUrlTrait;
    use CalculateAmountTrait;

    public const TRANSLATION_DOMAIN = LotgdOfferingBundle::TRANSLATION_DOMAIN;

    private $log;
    private $response;
    private $twig;
    private $navigation;

    public function __construct(
        Log $log,
        Response $response,
        Environment $twig,
        Navigation $navigation
    ) {
        $this->log      = $log;
        $this->response = $response;
        $this->twig     = $twig;
        $this->navigation = $navigation;
    }

    public function village(GenericEvent $event)
    {
        $seen = get_module_pref('seen', 'bundle_offering');

        if (5 <= $seen)
        {
            return;
        }

        $amt = $this->calculateAmount();

        ++$seen;
        set_module_pref('seen', $seen, 'bundle_offering');

        $query = sprintf('&translation_domain=%s&translation_domain_navigation=%s&navigation_method=%s',
            $event->getArgument('translation_domain'),
            $event->getArgument('translation_domain_navigation'),
            $event->hasArgument('navigation_method') ? $event->getArgument('navigation_method') : '',
        );

        $this->navigation->setTextDomain(self::TRANSLATION_DOMAIN);

        $this->navigation->addNav('navigation.nav.default.pay', $this->getModuleUrl('pay', $query), ['params' => ['amount' => $amt]]);
        $this->navigation->addNav('navigation.nav.default.nope', $this->getModuleUrl('nope', $query));

        $this->navigation->setTextDomain();

        $this->response->pageAddContent($this->twig->render('@LotgdOffering/activation.html.twig', [
            'translation_domain' => self::TRANSLATION_DOMAIN,
            'seen'               => $seen,
            'amount'             => $amt,
        ]));

        $event->stopPropagation();
    }

    public static function getSubscribedOccurrences()
    {
        return [
            'village' => ['village', 1000, OccurrenceSubscriberInterface::PRIORITY_ANSWER],
        ];
    }
}

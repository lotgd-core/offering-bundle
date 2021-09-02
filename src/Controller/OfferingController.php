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

namespace Lotgd\Bundle\OfferingBundle\Controller;

use Lotgd\Bundle\OfferingBundle\LotgdOfferingBundle;
use Lotgd\Bundle\OfferingBundle\Pattern\CalculateAmountTrait;
use Lotgd\Bundle\OfferingBundle\Pattern\ModuleUrlTrait;
use Lotgd\Core\Http\Request;
use Lotgd\Core\Http\Response as HttpResponse;
use Lotgd\Core\Lib\Settings;
use Lotgd\Core\Navigation\Navigation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OfferingController extends AbstractController
{
    use ModuleUrlTrait;
    use CalculateAmountTrait;

    public const TRANSLATION_DOMAIN = LotgdOfferingBundle::TRANSLATION_DOMAIN;

    private $navigation;
    private $response;
    private $settings;

    public function __construct(Navigation $navigation, HttpResponse $response, Settings $settings)
    {
        $this->navigation = $navigation;
        $this->response   = $response;
        $this->settings   = $settings;
    }

    public function nope(Request $request): Response
    {
        $this->response->pageTitle('title.nope', [], self::TRANSLATION_DOMAIN);

        $nav = $request->query->get('navigation_method', '');

        if (method_exists($this->navigation, $nav))
        {
            $this->navigation->{$nav}($request->query->get('translation_domain_navigation', ''));
        }

        return $this->render('@LotgdOffering/nope.html.twig', $this->addParameters([]));
    }

    public function pay(Request $request): Response
    {
        global $session;

        $amt = $this->calculateAmount();

        $params = [
            'amount'         => $amt,
            'death_overlord' => $this->settings->getSetting('deathoverlord', '`$Ramius`0'),
        ];

        $nav = $request->query->get('navigation_method', '');

        if (method_exists($this->navigation, $nav))
        {
            $this->navigation->{$nav}($request->query->get('translation_domain_navigation', ''));
        }

        if ($session['user']['gold'] < $amt)
        {
            $this->response->pageTitle('title.nope', [], self::TRANSLATION_DOMAIN);

            return $this->render('@LotgdOffering/no_gold.html.twig', $this->addParameters($params));
        }

        $this->response->pageTitle('title.pay', [], self::TRANSLATION_DOMAIN);

        $session['user']['deathpower'] += 15;

        if ($session['user']['dragonkills'] > 30)
        {
            $session['user']['deathpower'] -= 5;
        }

        $session['user']['gold'] -= $amt;

        return $this->render('@LotgdOffering/pay.html.twig', $this->addParameters($params));
    }

    private function addParameters(array $params): array
    {
        $params['translation_domain'] = self::TRANSLATION_DOMAIN;

        return $params;
    }
}

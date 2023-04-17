<?php

namespace Aqbank\Apiv2\Aqpago\Request\Pix;

use Aqbank\Apiv2\Aqpago\Request\AbstractRequest;
use Aqbank\Apiv2\Aqpago\ChargePix;
use Aqbank\Apiv2\AqpagoEnvironment;
use Aqbank\Apiv2\SellerAqpago;
use Psr\Log\LoggerInterface;

/**
 * Class QueryChargePixRequest
 *
 * @package Aqbank\Apiv2
 */
class QueryChargePixRequest extends AbstractRequest
{

    private $environment;

	/**
	 * QueryChargePixRequest constructor.
	 *
	 * @param SellerAqpago $seller
	 * @param AqpagoEnvironment $environment
	 * @param LoggerInterface|null $logger
	 */
    public function __construct(SellerAqpago $seller, AqpagoEnvironment $environment, LoggerInterface $logger = null)
    {
        parent::__construct($seller, $environment, $logger);

        $this->environment = $environment;
    }

    /**
     * @param $orderId
     *
     * @return null
     * @throws \Aqbank\Apiv2\Aqpago\Request\AqpagoRequestException
     * @throws \RuntimeException
     */
    public function execute($action)
    {
        $url = $this->environment->getApiUrl() . '/invoice-pix' . $action;

        return $this->sendRequest('GET', $url);
    }

    /**
     * @param $json
     *
     * @return ChargePix
     */
    protected function unserialize($json)
    {
        return ChargePix::fromJson($json);
    }
}

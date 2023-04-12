<?php

namespace Aqbank\Apiv2\Aqpago\Request\Pix;

use Aqbank\Apiv2\Aqpago\Request\AbstractRequest;

use Aqbank\Apiv2\Aqpago\ChargePix;
use Aqbank\Apiv2\AqpagoEnvironment;
use Aqbank\Apiv2\SellerAqpago;
use Psr\Log\LoggerInterface;

/**
 * Class CreateChargePixRequest
 *
 * @package Aqbank\Apiv2
 */
class CreateChargePixRequest extends AbstractRequest
{

    private $environment;

	/**
	 * CreateChargePixRequest construct.
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
     * @param $order
     *
     * @return null
     * @throws \Aqbank\Apiv2\Ecommerce\Request\AqpagoRequestException
     * @throws \RuntimeException
     */
    public function execute($orderPix)
    {
        $url = $this->environment->getApiUrl() . '/invoice-pix';

        return $this->sendRequest('POST', $url, $orderPix);
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

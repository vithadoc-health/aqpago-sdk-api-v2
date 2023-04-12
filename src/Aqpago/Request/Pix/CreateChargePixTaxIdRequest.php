<?php

namespace Aqbank\Apiv2\Aqpago\Request\Pix;

use Aqbank\Apiv2\Aqpago\Request\AbstractRequest;

use Aqbank\Apiv2\Aqpago\ChargePixTaxId;
use Aqbank\Apiv2\AqpagoEnvironment;
use Aqbank\Apiv2\SellerAqpago;
use Psr\Log\LoggerInterface;

/**
 * Class CreateChargePixTaxIdRequest
 *
 * @package Aqbank\Apiv2
 */
class CreateChargePixTaxIdRequest extends AbstractRequest
{

    private $environment;

	/**
	 * CreateChargePixTaxIdRequest construct.
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
        $url = $this->environment->getApiUrl() . '/invoice-pix/ex';

        return $this->sendRequest('POST', $url, $orderPix);
    }

    /**
     * @param $json
     *
     * @return ChargePixTaxId
     */
    protected function unserialize($json)
    {
        return ChargePixTaxId::fromJson($json);
    }
}

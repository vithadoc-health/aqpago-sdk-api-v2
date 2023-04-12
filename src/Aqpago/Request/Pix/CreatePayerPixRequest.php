<?php

namespace Aqbank\Apiv2\Aqpago\Request\Pix;

use Aqbank\Apiv2\Aqpago\Request\AbstractRequest;

use Aqbank\Apiv2\Aqpago\PayerPix;
use Aqbank\Apiv2\AqpagoEnvironment;
use Aqbank\Apiv2\SellerAqpago;
use Psr\Log\LoggerInterface;

/**
 * Class CreatePayerPixRequest
 *
 * @package Aqbank\Apiv2
 */
class CreatePayerPixRequest extends AbstractRequest
{

    private $environment;

	/**
	 * CreatePayerPixRequest construct.
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
     * @param $payerPix
     *
     * @return null
     * @throws \Aqbank\Apiv2\Ecommerce\Request\AqpagoRequestException
     * @throws \RuntimeException
     */
    public function execute($payerPix)
    {
        $url = $this->environment->getApiUrl() . '/payer-service';

        return $this->sendRequest('POST', $url, $payerPix);
    }

    /**
     * @param $json
     *
     * @return PayerPix
     */
    protected function unserialize($json)
    {
        return PayerPix::fromJson($json);
    }
}

<?php

require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\ChargePix;
use Aqbank\Apiv2\Aqpago\Aqpago;

try {
	
    $chargePix = new ChargePix();

	$chargePix->setInvoiceName('Pedido de teste')
        ->setAmount(100)
        ->setValidate(date('Y-m-d', strtotime(date('Y-m-d') . ' +30 days')))
        ->setDescripition('Compra de teste')
        ->setPayerId('XXXXXXXXX-XXXX-XXXX-XXXXX-XXXXXXXXXXXX');

    // Configure o ambiente

    // Ambiente de homologação
    //$environment = AqpagoEnvironment::sandbox();

    // Ambiente de produção
    $environment = AqpagoEnvironment::production();
	
    $seller_doc 	= '0000000000';
    $seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);
	
    $response = (new Aqpago($sellerAqpago, $environment))->createOrderPix($chargePix);
	
} catch(Exception $e) {
    echo "<pre>";
    print_r( $e->getMessage() . '|' . $e->getFile() . ' ' . $e->getLine() );
    echo "</pre>";
    exit();
}

echo "<h2>Request: </h2>";
echo "<pre>";
echo json_encode(array_filter($chargePix->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

echo "<br>";
echo "<h2>Response: </h2>";
echo "<pre>";
echo json_encode(array_filter($response->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

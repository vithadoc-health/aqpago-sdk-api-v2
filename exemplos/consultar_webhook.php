<?php

require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Webhook;
use Aqbank\Apiv2\Aqpago\Aqpago;


try {

    // Configure o ambiente
    // Ambiente de homologação
    $environment = AqpagoEnvironment::sandbox();

    // Ambiente de produção
    //$environment = AqpagoEnvironment::production();

    $seller_doc 	= '0000000000';
    $seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);
    
    //consultar 
	$Webhooks = (new Aqpago($sellerAqpago, $environment))->getWebhooks();

} catch(Exception $e){
    echo "<pre>";
    print_r( $e->getMessage() . '|' . $e->getFile() . ' ' . $e->getLine() );
    echo "</pre>";
    exit();
}

echo "<br>";
echo "<h2>Response: </h2>";
echo "<pre>";
echo json_encode(array_filter($Webhooks->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";


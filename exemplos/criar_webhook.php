<?php

require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Webhook;
use Aqbank\Apiv2\Aqpago\Aqpago;

$urlWebhook  = 'https://xxxxxxxxxxxxx.com.br/webhook'; // Url que recebe o webhook
$description = 'Minha loja'; // uma breve descrição
$events      = [
    "transation.success",
    "transaction.succeeded",
    "transaction.reversed",
    "transaction.failed",
    "transaction.canceled",
    "transaction.disputed",
    "transaction.charged_back",
    "transaction.pre_authorized"
];

try {
	$webhook = new Webhook();
	$webhook->setEvent($events)
			->setUrl($urlWebhook)
			->setDescription($description)
			->setMethod('POST');

    // Configure o ambiente
    // Ambiente de homologação
    $environment = AqpagoEnvironment::sandbox();

    // Ambiente de produção
    //$environment = AqpagoEnvironment::production();

    $seller_doc 	= '0000000000';
    $seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);
    
    $aqpago = (new Aqpago($sellerAqpago, $environment))->createWebhook($webhook);

} catch(Exception $e){
    echo "<pre>";
    print_r( $e->getMessage() . '|' . $e->getFile() . ' ' . $e->getLine() );
    echo "</pre>";
    exit();
}


echo "<h2>Request: </h2>";
echo "<pre>";
echo json_encode(array_filter($webhook->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

echo "<br>";
echo "<h2>Response: </h2>";
echo "<pre>";
echo json_encode(array_filter($aqpago->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";


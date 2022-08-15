<?php

require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Order;
use Aqbank\Apiv2\Aqpago\Aqpago;

// Ambiente de homologação
//$environment = AqpagoEnvironment::sandbox();

// Ambiente de produção
$environment = AqpagoEnvironment::production();


/**
 * aqpago_session_id
 * 
 * see how to get the session in getSessionId.php
 */
$aqpago_session_id = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

$order = new Order($aqpago_session_id);


try {
	
	$order->setReferenceId( 'reference_id')
		->setAmount('100.00')
		->setType('ticket') // credit, multi_credit, ticket, multi_ticket
		->setDescription('Fone de ouvido');

        $customer = $order->customer();

        $customer->setName('Name')
                    ->setLastName('last name')
                    ->setEmail('exemple@exemple.com.br')
                    ->setTaxDocument('00000000000');
                    
        $customer->address()
                        ->setPostCode('00000000')
                        ->setStreet('Endereço')
                        ->setNumber('Numero')
                        ->setComplement('Complemento')
                        ->setDistrict('Bairro')
                        ->setCity('Cidade')
                        ->setState('Estado');
    
        $customer->phones()
                        ->setArea('11')
                        ->setNumber('912341234');
    
        // Frete opcional
        $order->shipping('0.00', 'Frete grátis');

        $order->items()
                ->setName('Fone de ouvido')
                ->setQty(1)
                ->setUnitAmount(100.00);

	    $order->ticket('100.00')
		    ->setBodyInstructions('Linha de instruções');

    // Configure o ambiente

    // Ambiente de homologação
    $environment = AqpagoEnvironment::sandbox();

    // Ambiente de produção
    //$environment = AqpagoEnvironment::production();

    $seller_doc 	= '0000000000';
    $seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);

    $aqpago = (new Aqpago($sellerAqpago, $environment))->createOrder($order);

} catch(Exception $e){
    echo "<pre>";
    print_r( $e->getMessage() . '|' . $e->getFile() . ' ' . $e->getLine() );
    echo "</pre>";
    exit();
}


echo "<h2>Request: </h2>";
echo "<pre>";
echo json_encode(array_filter($order->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

echo "<br>";
echo "<h2>Response: </h2>";
echo "<pre>";
echo json_encode(array_filter($aqpago->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";


<?php

require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\PayerPix;
use Aqbank\Apiv2\Aqpago\Aqpago;

try {
    $payerPix = new PayerPix();

    $payerPix->setName('Fulano') // Nome do pagador
            ->setLastName('de tal') // Sobrenome do pagador
            ->setEmail('exemplo@exemplo.com.br') // E-mail do pagador 
            ->setTapayerId('00000000000') // CPF ou CNPJ do pagador
            ->setPhone('+5511900000000') // +55 + ddd + número
            ->setBusinesName('') // Nome empresarial
            ->address()
                ->setZipcode('00000000') // Cep do pagador
                ->setStreet('Rua de teste') // Endereço do pagador
                ->setNumber('123') // Número do endereço de pagador
                ->setDistrict('bairro') // Bairro do pagador
                ->setCity('cidade') // Cidade do pagador
                ->setState('SP'); // Estado do pagador com dois digitos (UF)


    // Configure o ambiente

    // Ambiente de homologação
    //$environment = AqpagoEnvironment::sandbox();

    // Ambiente de produção
    $environment = AqpagoEnvironment::production();
	
    $seller_doc 	= '0000000000';
    $seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);
	
    $response = (new Aqpago($sellerAqpago, $environment))->createPayerPix($payerPix);
	
} catch(Exception $e) {
    echo "<pre>";
    print_r( $e->getMessage() . '|' . $e->getFile() . ' ' . $e->getLine() );
    echo "</pre>";
    exit();
}

echo "<h2>Request: </h2>";
echo "<pre>";
echo json_encode(array_filter($payerPix->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

echo "<br>";
echo "<h2>Response: </h2>";
echo "<pre>";
echo json_encode(array_filter($response->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

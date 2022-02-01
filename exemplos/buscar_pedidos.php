<?php

require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Order;
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

    /** Busca por ORDER ID **/
    $searchOrderId = (new Aqpago($sellerAqpago, $environment))->getOrder('XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');

    /**  Busca geral, retorna todos os pedidos **/
    $allOrders = (new Aqpago($sellerAqpago, $environment))->getSearchOrders();

    /*** Busca com filtros, filtrar resultados **/
	$filters = [
			'reference_id'  => null, // reference id
			'status'        => null, // order status
			'type'          => null, // type
			'amount'        => null, // amount
			'initial_date'  => null, // init date
			'final_date'    => null, // final date
			'limit'         => null, // limit per page
			'page'          => null, // page number
			'sort'          => null // asc or desc		
	];

    $filterOrders = (new Aqpago($sellerAqpago, $environment))->getSearchOrders($filters);

} catch(Exception $e){
    echo "<pre>";
    print_r( $e->getMessage() . '|' . $e->getFile() . ' ' . $e->getLine() );
    echo "</pre>";
    exit();
}


echo "<br>";
echo "<h2>Response order ID: </h2>";
echo "<pre>";
echo json_encode(array_filter($searchOrderId->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

echo "<br>";
echo "<h2>Response all orders: </h2>";
echo "<pre>";
echo json_encode(array_filter($allOrders->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";


echo "<br>";
echo "<h2>Response filter orders: </h2>";
echo "<pre>";
echo json_encode(array_filter($filterOrders->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";


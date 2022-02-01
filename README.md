[API AQPago]: https://apideveloper.aqpago.com.br

# SDK para integrar com a AQPago 

### Descrição
SDK em PHP para integração com meio de pagamento AQPAgo. Você pode oferecer os seguintes meios de pagamentos da AQPago:

- Pagamento com cartão de crédito.
- Pagamento múltiplo com dois cartões.
- Pagamento múltiplo com cartão e boleto.
- Pagamento com boleto.

https://aqpago.com.br

## Instalação via composer

 - `composer require aqbank/aqpago-sdk-api-v2` 

## Documentação da API
- [API AQPago]

### Dados de Autenticação e ambiente
```sh
<?php
require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Aqpago;
use Aqbank\Apiv2\Aqpago\Order;

$seller_doc 	= '0000000000';
$seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
$sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);

// Ambiente de homologação
$environment = AqpagoEnvironment::sandbox();
// Ambiente de produção
$environment = AqpagoEnvironment::production();
```

### Criar novo pedido com cartão
```sh
<?php
require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Aqpago;
use Aqbank\Apiv2\Aqpago\Order;

$seller_doc 	= '0000000000';
$seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
$sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);

// Ambiente de homologação
$environment = AqpagoEnvironment::sandbox();

$order = new Order();

try {
	$order->setReferenceId( 'reference_id')
		->setAmount('100.00') 
		->setType('credit') // credit, multi_credit, multi_ticket, ticket
		->setDescription('Descrição da venda');
	/* setAmount deve ser igual ao total da soma dos itens + frete, o frete não é obrigatório. */
	
    $customer = $order->customer();
    $customer->setName('Name')
        ->setEmail('exemple@exemple.com.br')
        ->setTaxDocument('00000000000');
    
    $customer->address()
        ->setPostCode('00000000')
        ->setStreet('Endereço')
        ->setNumber('Numero')
        ->setComplement('Complemento')
        ->setDistrict('Bairro')
        ->setCity('Cidade')
        ->setState('UF');
    
    $customer->phones()
        ->setArea('11')
        ->setNumber('912341234');
    
    // Frete opcional
    $order->shipping('0.00', 'Frete grátis');

    $order->items()
        ->setName('Meu item')
        ->setQty(1)
        ->setUnitAmount(100.00);
    // O valor de Unit Amount * Qty será o total do item
    
    /** 
    //para enviar mais itens no objeto repetir até que todos os itens sejam declarados
    // lembre-se que setAmount deve ser igual a soma dos itens mais o frete
    $order->items()
        ->setName('Segundo item')
        ->setQty(1)
        ->setUnitAmount(100.00);
    **/
    
    // creditCard(''valor', 'parcelas')
    $order->creditCard('100.00', 1)
        ->setCardNumber('0000000000000000')
        ->setHolderName('Fulano de tal')
        ->setExpirationMonth('02')
        ->setExpirationYear('2023')
        ->setSecurityCode('123')
        ->setCpf('00000000000');
        
    $aqpago = (new Aqpago($sellerAqpago, $environment))->createOrder($order);

} catch(Exception $e){
    echo $e->getMessage();
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

```

### Pagamento com Boleto 
```sh
<?php
require '../vendor/autoload.php';
...
$order->setReferenceId( 'reference_id')
	->setAmount('100.00')
	->setType('ticket') // Pagamento com boleto
	->setDescription('Descrição da venda');
...
// Pagamento por Boleto
$order->ticket('100.00')
    ->setBodyInstructions('Linha de instruções');
    
...

```

### Pagamento com 2 Cartões de Crédito
```sh
<?php
require '../vendor/autoload.php';
...
$order->setReferenceId( 'reference_id')
	->setAmount('100.00')
	->setType('multi_credit') // 2 cartões de Crédito
	->setDescription('Descrição da venda');
...

// 1 primeiro cartão
$order->creditCard('50.00', 1)
                ->setCardNumber('0000000000000000')
                ->setHolderName('Fulano de tal')
                ->setExpirationMonth('02')
                ->setExpirationYear('2023')
                ->setSecurityCode('123')
                ->setCpf('00000000000');

// 2 segundo cartão
$order->creditCard('50.00', 1)
                ->setInstallments(1)
                ->setCardNumber('0000000000000000')
                ->setHolderName('Fulano de tal')
                ->setExpirationMonth('02')
                ->setExpirationYear('2023')
                ->setSecurityCode('123')
                ->setCpf('00000000000');
                        
...

$aqpago = (new Aqpago($sellerAqpago, $environment))->createOrder($order);

...

```

### Pagamento com Cartão e Boleto 
```sh
<?php
require '../vendor/autoload.php';
...

$order->setReferenceId( 'reference_id')
	->setAmount('100.00')
	->setType('multi_ticket') // cartão e boleto
	->setDescription('Descrição da venda');
...

// Meio Cartão de crédito
$order->creditCard('50.00', 1)
    ->setCardNumber('0000000000000000')
    ->setHolderName('Fulano de tal')
    ->setExpirationMonth('02')
    ->setExpirationYear('2023')
    ->setSecurityCode('123')
    ->setCpf('00000000000');

// Meio Boleto
$order->ticket('50.00')
    ->setBodyInstructions('Linha de instruções');
		    
...	
		
```

### Cadastrar url para receber Webhook
```sh
<?php
require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Webhook;
use Aqbank\Apiv2\Aqpago\Aqpago;

$urlWebhook  = 'https://xxxxxxxxxxxxx.com.br/webhook'; 
// Url que api enviara o webhook
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
    echo $e->getMessage();
    exit();
}

echo "<br>";
echo "<h2>Response: </h2>";
echo "<pre>";
echo json_encode(array_filter($aqpago->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

```


### Consultar Pedidos
```sh
<?php
require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Aqpago;
use Aqbank\Apiv2\Aqpago\Order;

try {
    // Ambiente de homologação
    $environment = AqpagoEnvironment::sandbox();

    $seller_doc 	= '0000000000';
    $seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);

    /** Pesquisa por ORDER ID **/
    $searchOrderId = (new Aqpago($sellerAqpago, $environment))->getOrder('XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');

    /**  Pesquisa geral, retorna todos os pedidos **/
    $allOrders = (new Aqpago($sellerAqpago, $environment))->getSearchOrders();

    /*** Pesquisa com filtros **/
	$filters = [
			'reference_id'  => null, // reference id
			'status'        => null, // order status
			'type'          => null, // type
			'amount'        => null, // amount
			'initial_date'  => null, // start date
			'final_date'    => null, // end date
			'limit'         => null, // limit per page
			'page'          => null, // page number
			'sort'          => null // asc or desc		
	];

    $filterOrders = (new Aqpago($sellerAqpago, $environment))->getSearchOrders($filters);

} catch(Exception $e){
    echo $e->getMessage();
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

```

### Cancelar Pedido
```sh
<?php
require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Aqpago;
use Aqbank\Apiv2\Aqpago\Order;

try {
    // Ambiente de homologação
    $environment = AqpagoEnvironment::sandbox();

    $seller_doc 	= '0000000000';
    $seller_token 	= 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
    $sellerAqpago   = new SellerAqpago($seller_doc, $seller_token);

	$order = new Order();
	$order->setOrderId('XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');

    $response = (new Aqpago($sellerAqpago, $environment))->cancelOrder($order);
    /** Os pedidos só podem ser cancelados pela API no mesmo dia. **/

} catch(Exception $e){
    echo $e->getMessage();
    exit();
}

echo "<br>";
echo "<h2>Response cancel order: </h2>";
echo "<pre>";
echo json_encode(array_filter($response->jsonSerialize()), JSON_PRETTY_PRINT);
echo "</pre>";

```
<?php

require '../vendor/autoload.php';

use Aqbank\Apiv2\SellerAqpago;
use Aqbank\Apiv2\Aqpago\Request\AqpagoEnvironment;
use Aqbank\Apiv2\Aqpago\Aqpago;


try {
    $sellerAqpago   = new Aqbank\Apiv2\SellerAqpago(
        '00000000000000', // document registered with aqpago 
        'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' // token registered in the app
    );    
    
    // Ambiente de produção
    $environment = AqpagoEnvironment::production();

    // Ambiente de homologação
    // $environment = AqpagoEnvironment::sandbox();

    $public_token = (new Aqpago($sellerAqpago, $environment))->getPublicToken();

} catch (Exception $e) {
    $error = $e->getMessage();
    $error = json_decode($error, true);

    echo "<h1>";
        print_r($error['error']);
    echo "</h1>";
    exit();
}
?>
<html>
    <head>
        <title>Load Session ID</title>
    </head>
    <body>
        <script>
            window.addEventListener("load", function(){
                AQPAGOSECTION.setPublicToken('<?php echo $public_token ?>');
            });

            function showSessionId() {

                if (AQPAGOSECTION.getSessionID() != null) {
                    alert( 'APago SessionId: ' + AQPAGOSECTION.getSessionID() )
                } else {
                    /**
                     * waiting to generate session id
                     */
                    setTimeout(() => {
                        return showSessionId();
                    }, 500);
                }
            }
        </script>
        <script defer="defer" src="https://cdn.aqbank.com.br/js/aqpago.min.js"></script>

        <h1>Get a session id at your checkout when loading the page.</h1>
        <button onClick="return showSessionId();">Alert my Session ID AQPago</button>
    </body>
</html>
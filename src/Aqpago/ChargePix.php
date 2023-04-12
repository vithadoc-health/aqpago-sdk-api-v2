<?php

namespace Aqbank\Apiv2\Aqpago;

use Aqbank\Apiv2\Aqpago\Request\Exceptions\AqpagoError;
use Aqbank\Apiv2\Aqpago\Request\Exceptions\AqpagoRequestException;

/**
 * Class ChargePix
 *
 * @package Aqbank\Apiv2
 */
class ChargePix implements AqpagoSerializable
{
    private $id;
    private $payer;
    private $payer_id;
    private $invoice_name;
    private $amount;
    private $validate;
    private $descripition;
    private $penalty = 0;
    private $method = 'pix';
    private $type = 'unique';

    private $resource;
    private $taxpayer_id;
    private $reconciliation_id;
    private $original_amount;
    private $status;
    private $transaction;
    private $brcode;
    private $barcode;
    private $digitable_line;
    private $url;
    private $expiration_date;
    private $expiration;
    
    /**
     * @param $json
     *
     * @return ChargePix
     */
    public static function fromJson($json)
    {
        $object = json_decode($json);

        $order = new ChargePix();
        $order->populate($object);

        return $order;
    }

    /**
     * @param \stdClass $data
     */
    public function populate(\stdClass $data)
    {
        /** search filter **/
        if(isset($data->data)){
            $this->total_rows   = isset($data->total_rows) ? $data->total_rows : null;
            $this->total_pages  = isset($data->total_pages) ? $data->total_pages : null;
            $this->page         = isset($data->page) ? $data->page : null;
            
            if(count($data->data)) {
                foreach($data->data as $k => $order){
                    $order = (is_object($order)) ? json_encode($order) : $order;
                    $this->data[$k] = ChargePix::fromJson($order);
                }
            }
            
        } else {
            if (isset($data->body)) $data = $data->body;

            $data                       = (isset($data->order)) ? $data->order : $data;
            
            $this->id                   = isset($data->id) ? $data->id : null;
            $this->payer                = isset($data->payer) ? $data->payer : null;
            $this->payer_id             = isset($data->payer_id) ? $data->payer_id : null;
            $this->invoice_name         = isset($data->invoice_name) ? $data->invoice_name : null;
            $this->amount               = isset($data->amount) ? $data->amount : null;
            $this->validate             = isset($data->validate) ? $data->validate : null;
            $this->descripition         = isset($data->descripition) ? $data->descripition : null;
            $this->resource             = isset($data->resource) ? $data->resource : null;
            $this->taxpayer_id          = isset($data->taxpayer_id) ? $data->taxpayer_id : null;
            $this->reconciliation_id    = isset($data->reconciliation_id) ? $data->reconciliation_id : null;
            $this->original_amount      = isset($data->original_amount) ? $data->original_amount : null;
            $this->status               = isset($data->status) ? $data->status : null;
            $this->brcode               = isset($data->brcode) ? $data->brcode : null;
            $this->barcode              = isset($data->barcode) ? $data->barcode : null;
            $this->digitable_line       = isset($data->digitable_line) ? $data->digitable_line : null;
            $this->url                  = isset($data->url) ? $data->url : null;
            $this->expiration_date      = isset($data->expiration_date) ? $data->expiration_date : null;
            $this->expiration           = isset($data->expiration) ? $data->expiration : null;
            
            $this->success          = isset($data->success) ? $data->success : null;
            $this->error            = isset($data->error) ? $data->error : null;
            $this->message          = isset($data->message) ? $data->message : null;
            
            if (isset($data->transaction)) {
                $this->transaction = new Transaction();
                $this->transaction->populate($data->transaction);
            }
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array_filter(
            get_object_vars($this)
        );
    }

    /**
     * 
     *
     * @return PayerPix
     */
    public function payer()
    {
        $payer = new PayerPix();

        $this->setPayer($payer);

        return $payer;
    }

    /**
     * @param $orderId
     *
     * @return $this
     */
    public function setId($orderId)
    {
        $this->id = $orderId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->orderId;
    }

    /**
     * Remove payer object this json
     *
     * @return $this
     */
    public function unsetPayer()
    {
        unset($this->payer);
        return $this;
    }

    /**
     * @param $payer
     *
     * @return $this
     */
    public function setPayer($payer)
    {
        $this->payer = $payer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param $payer_id
     *
     * @return $this
     */
    public function setPayerId($payer_id)
    {
        $this->payer_id = $payer_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayerId()
    {
        return $this->payer_id;
    }

    /**
     * @param $invoice_name
     *
     * @return $this
     */
    public function setInvoiceName($invoice_name)
    {
        $this->invoice_name = $invoice_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceName()
    {
        return $this->invoice_name;
    }

    /**
     * @param $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $validate
     *
     * @return $this
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * @param $descripition
     *
     * @return $this
     */
    public function setDescripition($descripition)
    {
        $this->descripition = $descripition;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getDescripition()
    {
        return $this->descripition;
    }

    /**
     * @param $penalty
     *
     * @return $this
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPenalty()
    {
        return $this->penalty;
    }
}

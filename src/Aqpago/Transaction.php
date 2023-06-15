<?php

namespace Aqbank\Apiv2\Aqpago;

/**
 * Class Transaction
 *
 * @package Aqbank\Apiv2\Aqpago
 */
class Transaction implements \JsonSerializable
{
    private $id;

    private $resource;

    private $end_to_end_id;

    private $amount;

    private $created_at;

    private $updated_at;

    /**
     * @param $json
     *
     * @return Transaction
     */
    public static function fromJson($json)
    {
        $transaction = new Transaction();
        $transaction->populate(json_decode($json));

        return $transaction;
    }
    
    /**
     * @param \stdClass $data
     */
    public function populate(\stdClass $data)
    {
        $this->id               = isset($data->id) ? $data->id : null;
        $this->resource         = isset($data->resource) ? $data->resource : null;
        $this->end_to_end_id    = isset($data->end_to_end_id) ? $data->end_to_end_id : null;
        $this->amount           = isset($data->amount) ? $data->amount : null;
        $this->created_at       = isset($data->created_at) ? $data->created_at : null;
        $this->updated_at       = isset($data->updated_at) ? $data->updated_at : null;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return array_filter(
            get_object_vars($this)
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param $resource
     *
     * @return $this
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndToEndId()
    {
        return $this->end_to_end_id;
    }

    /**
     * @param $end_to_end_id
     *
     * @return $this
     */
    public function setEndToEndId($end_to_end_id)
    {
        $this->end_to_end_id = $end_to_end_id;

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
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param $created_at
     *
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param $updated_at
     *
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}

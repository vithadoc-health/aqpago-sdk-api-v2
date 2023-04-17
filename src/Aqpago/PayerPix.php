<?php

namespace Aqbank\Apiv2\Aqpago;

/**
 * Class PayerPix
 *
 * @package Aqbank\Apiv2\Aqpago
 */
class PayerPix implements \JsonSerializable
{
    private $id;

    private $name;

    private $lastname;

    private $tapayer_id;

    private $phone;

    private $busines_name;

    private $email;

    private $address;

    /**
     * @param $json
     *
     * @return PayerPix
     */
    public static function fromJson($json)
    {
        $payerPix = new PayerPix();
        $payerPix->populate(json_decode($json));

        return $payerPix;
    }
    
    /**
     * @param \stdClass $data
     */
    public function populate(\stdClass $data)
    {
        if (isset($data->body)) $data = $data->body;

        $this->id           = isset($data->id) ? $data->id : null;
        $this->name         = isset($data->name) ? $data->name : null;
        $this->lastname     = isset($data->lastname) ? $data->lastname : null;
        $this->tapayer_id   = isset($data->tapayer_id) ? $data->tapayer_id : null;
        $this->phone        = isset($data->phone) ? $data->phone : null;
        $this->busines_name = isset($data->busines_name) ? $data->busines_name : null;
        $this->email        = isset($data->email) ? $data->email : null;

        if (isset($data->address)) {
            $this->address = new AddressPix();
            $this->address->populate($data->address);
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize():mixed
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param $lastname
     *
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTapayerId()
    {
        return $this->tapayer_id;
    }

    /**
     * @param $tapayer_id
     *
     * @return $this
     */
    public function setTapayerId($tapayer_id)
    {
        $this->tapayer_id = $tapayer_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBusinesName()
    {
        return $this->busines_name;
    }

    /**
     * @param $busines_name
     *
     * @return $this
     */
    public function setBusinesName($busines_name)
    {
        $this->busines_name = $busines_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param $name
     *
     * @return AddressPix
     */
    public function address()
    {
        $addressPix = new AddressPix();

        $this->setAddress($addressPix);

        return $addressPix;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param AddressPix $address
     *
     * @return $this
     */
    public function setAddress(AddressPix $address)
    {
        $this->address = $address;

        return $this;
    }
}

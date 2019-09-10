<?php

/**
 * ShipEngine API Wrapper
 *
 * This file is subject to the terms and conditions defined in
 * file 'LICENSE.txt', which is found in the root folder of
 * this source code package.
 *
 * @author    John Hall
 */
namespace jsamhall\ShipEngine\Labels;

use jsamhall\ShipEngine;

class Shipment extends ShipEngine\Shipment\AbstractShipment
{

    /**
     * Optional carrierId
     *
     * @var ShipEngine\Carriers\CarrierId|null
     */
    protected $carrierId = null;

    /**
     * The service code to request a Label for
     *
     * @var ShipEngine\Carriers\ServiceCode
     */
    protected $serviceCode;

    /**
     * @var ShipEngine\Carriers\DeliveryConfirmation|null
     */
    protected $deliveryConfirmation = null;

    /**
     * @var ShipEngine\Carriers\AdvancedOption[]
     */
    protected $advancedOptions = [];

    /**
     * Optional labelMessage1
     *
     * @var string - Additional message to appear on shipping label
     */
    protected $labelMessage1 = "";

    /**
     * Optional labelMessage2
     *
     * @var string - Additional message to appear on shipping label
     */
    protected $labelMessage2 = "";

    /**
     * Optional labelMessage3
     *
     * @var string - Additional message to appear on shipping label
     */
    protected $labelMessage3 = "";


    public function __construct(
        ShipEngine\Carriers\ServiceCode $service,
        ShipEngine\Address\Address $shipTo,
        ShipEngine\Address\Address $shipFrom,
        array $packages = []
    ) {
        parent::__construct($shipTo, $shipFrom, $packages);

        $this->serviceCode = $service;
    }

    /**
     * Specify a specific carrierId for which this Shipment applies
     * Only necessary when multiple Accounts for the same Carrier have been established
     *
     * @param ShipEngine\Carriers\CarrierId $carrierId
     * @return $this
     */
    public function specifyCarrierId(ShipEngine\Carriers\CarrierId $carrierId)
    {
        $this->carrierId = $carrierId;

        return $this;
    }

    /**
     * Add an Advanced Option to the Label Shipment
     *
     * @link https://docs.shipengine.com/docs/specify-advanced-options
     *
     * @param ShipEngine\Carriers\AdvancedOption $advancedOption
     * @return static $this
     */
    public function addAdvancedOption(ShipEngine\Carriers\AdvancedOption $advancedOption)
    {
        $this->advancedOptions[] = $advancedOption;

        return $this;
    }

    /**
     * Add Delivery Confirmation to the Label Shipment
     *
     * @link https://docs.shipengine.com/docs/request-delivery-confirmation
     *
     * @param ShipEngine\Carriers\DeliveryConfirmation $deliveryConfirmation
     * @return static $this
     */
    public function setDeliveryConfirmation(ShipEngine\Carriers\DeliveryConfirmation $deliveryConfirmation)
    {
        $this->deliveryConfirmation = $deliveryConfirmation;

        return $this;
    }

    public function setLabelMessage1($message)
    {
        $this->labelMessage1 = $message;
    }

    public function setLabelMessage2($message)
    {
        $this->labelMessage2 = $message;
    }

    public function setLabelMessage3($message)
    {
        $this->labelMessage3 = $message;
    }

    /**
     * Prepare the Shipment Data for transport as an array
     *
     * @return array
     */
    public function toArray()
    {
        $data = array_merge(parent::toArray(), [
            'service_code'     => $this->serviceCode->__toString()
        ]);

        if (! is_null($this->deliveryConfirmation)) {
            $data['confirmation'] = $this->deliveryConfirmation->__toString();
        }

        if (! is_null($this->carrierId)) {
            $data['carrier_id'] = $this->carrierId->__toString();
        }

        if(count($this->advancedOptions)){
            $data['advanced_options'] = array_map(function($option){
                /** @var ShipEngine\Carriers\AdvancedOption $option */
                return [$option->getCode() => $option->getValue()];
            }, $this->advancedOptions);
        }

        if(!empty($this->labelMessage1) || !empty($this->labelMessage2) || !empty($this->labelMessage3))
        {
            if(!isset($data['label_messages']))
            {
                $data['label_messages'] = [];
            }

            $messageKeys = [1, 2, 3];
            foreach($messageKeys as $key)
            {
                $labelKey = "labelMessage" . $key;
                if(!empty($this->{$labelKey}))
                {
                    $requestKey = "reference" . $key;
                    $data['label_messages'][$requestKey] = $this->{$labelKey};
                }
            }
        }

        return $data;
    }
}

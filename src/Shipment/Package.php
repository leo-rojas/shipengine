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

namespace jsamhall\ShipEngine\Shipment;


class Package
{
    const UNIT_OUNCE = 'ounce';
    const UNIT_POUND = 'pound';

    /**
     * The package weight
     *
     * @var float
     */
    protected $weightAmount;

    /**
     * The unit of measurement for the package weight
     *
     * @var string
     */
    protected $weightUnit = self::UNIT_OUNCE;


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


    /**
     * Package constructor.
     *
     * @param float  $weightAmount
     * @param string $weightUnit
     */
    public function __construct($weightAmount, $weightUnit = self::UNIT_OUNCE)
    {
        $this->weightAmount = $weightAmount;
        $this->weightUnit = $weightUnit;
    }

    /**
     * @return float
     */
    public function getWeightAmount()
    {
        return $this->weightAmount;
    }

    /**
     * @return string
     */
    public function getWeightUnit()
    {
        return $this->weightUnit;
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

    public function toArray()
    {
        $data = [
            'weight' => [
                'value' => $this->weightAmount,
                'unit' => $this->weightUnit
            ]
        ];

        $labelMessages = [];
        $labelMessageKeys = [1,2,3];
        foreach($labelMessageKeys as $key)
        {
            $labelMessageKey = "labelMessage" . $key;
            if(!empty($this->{$labelMessageKey}))
            {
                $requestKey = "reference" . $key;
                $labelMessages[$requestKey] = $this->{$labelMessageKey};
            }
        }

        if(!empty($labelMessages))
        {
            $data['label_messages'] = $labelMessages;
        }

        return $data;
    }
}

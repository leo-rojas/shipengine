<?php
namespace jsamhall\ShipEngine\Labels;

class Request
{

	/**
	 * Label shipment
	 *
	 * @var Shipment
	 */
	protected $shipment;

	/**
	 * Whether or not the request should return a test label
	 *
	 * @var bool
	 */
	protected $isTestLabel;

	/**
	 * Label format (pdf, png)
	 *
	 * @var string
	 */
	protected $labelFormat;


	public function __construct(Shipment $shipment, $isTestLabel = false)
	{
		$this->shipment    = $shipment;
		$this->isTestLabel = $isTestLabel;
	}

	/**
	 * @return Shipment
	 */
	public function getShipment()
	{
		return $this->shipment;
	}

	/**
	 * @param Shipment $shipment
	 * @return void
	 */
	public function setShipment(Shipment $shipment)
	{
		$this->shipment = $shipment;
	}

	/**
	 * @return bool
	 */
	public function isTestLabel()
	{
		return $this->isTestLabel;
	}

	/**
	 * @param bool $isTestLabel
	 * @return void
	 */
	public function setTestLabel($isTestLabel)
	{
		$this->isTestLabel = $isTestLabel;
	}

	/**
	 * @return string
	 */
	public function getLabelFormat()
	{
		return $this->labelFormat;
	}

	/**
	 * @param string $labelFormat
	 * @return void
	 */
	public function setLabelFormat($labelFormat)
	{
		$this->labelFormat = $labelFormat;
	}

	/**
	 * Prepare the Label data for transport as an array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$data = [
			'shipment' => $this->shipment->toArray(),
			'test_label' => $this->isTestLabel,
		];

		if($this->labelFormat)
		{
			$data['label_format'] = $this->labelFormat;
		}

		return $data;
	}
}

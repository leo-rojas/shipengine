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


	/**
	 * @return Shipment
	 */
	public function getShipment()
	{
		return $this->shipment;
	}

	/**
	 * @return bool
	 */
	public function isTestLabel()
	{
		return $this->isTestLabel;
	}

	/**
	 * @return string
	 */
	public function getLabelFormat()
	{
		return $this->labelFormat;
	}

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

<?php
namespace jsamhall\ShipEngine\Labels;

class Label
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
	protected $isTestLabel = false;

	/**
	 * Label format (pdf, png, zpl)
	 *
	 * @var string
	 */
	protected $labelFormat;

	/**
	 * Label download type
	 *
	 * @var string
	 */
	protected $labelDownloadType;


	public function __construct(array $labelData)
	{
		$map = [
			'shipment'            => 'shipment',
			'test_label'          => 'isTestLabel',
			'label_format'        => 'labelFormat',
			'label_download_type' => 'labelDownloadType'
		];

		foreach($map as $key => $property)
		{
			if(!isset($labelData[$key]))
			{
				continue;
			}


			$this->{$property} = $labelData[$key];
		}
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
	 * @return string
	 */
	public function getLabelDownloadType()
	{
		return $this->labelDownloadType;
	}

	/**
	 * @param string $labelDownloadType
	 * @return void
	 */
	public function setLabelDownloadType($labelDownloadType)
	{
		$this->labelDownloadType = $labelDownloadType;
	}

	/**
	 * Prepare the Label data for transport as an array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$data = [
			'shipment'   => $this->shipment->toArray(),
			'test_label' => $this->isTestLabel,
		];

		$map = [
			'label_format'        => 'labelFormat',
			'label_download_type' => 'labelDownloadType'
		];

		foreach($map as $key => $property)
		{
			if(empty($this->{$property}))
			{
				continue;
			}

			$data[$key] = $this->{$property};
		}

		return $data;
	}
}

<?php
namespace jsamhall\ShipEngine\Labels;

class Label
{

	const LABEL_FORMAT_PDF = "pdf";
	const LABEL_FORMAT_PNG = "png";
	const LABEL_FORMAT_ZPL = "zpl";

	const DOWNLOAD_TYPE_URL    = "url";
	const DOWNLOAD_TYPE_INLINE = "inline";

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
			'shipment'            => 'setShipment',
			'test_label'          => 'setTestLabel',
			'label_format'        => 'setLabelFormat',
			'label_download_type' => 'setLabelDownloadType'
		];

		foreach($map as $key => $setter)
		{
			if(!isset($labelData[$key]))
			{
				continue;
			}


			$this->$setter($labelData[$key]);
		}
	}

	public function getAllowedFormatTypes()
	{
		return [static::LABEL_FORMAT_PDF, static::LABEL_FORMAT_PNG, static::LABEL_FORMAT_ZPL];
	}

	public function getAllowedDownloadTypes()
	{
		return [static::DOWNLOAD_TYPE_URL, static::DOWNLOAD_TYPE_INLINE];
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
		if(!in_array($labelFormat, $this->getAllowedFormatTypes()))
		{
			throw new \Exception($labelFormat . " not allowed as a format type.  Allowable types: " . implode(", ", $this->getAllowedFormatTypes()));
		}

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
		if(!in_array($labelDownloadType, $this->getAllowedDownloadTypes()))
		{
			throw new \Exception($labelDownloadType . " not allowed as a download type.  Allowable types: " . implode(", ", $this->getAllowedDownloadTypes()));
		}

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

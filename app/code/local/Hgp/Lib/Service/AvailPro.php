<?php
/**
 * Hotels Grand Paris
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * A remplir par Brice POTE.
 *
 * @category   HGP
 * @package    Library
 * @copyright  Copyright (c) 2009 Brice POTE
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @company    HotelsGrandParis 2009
 */

/**
 * Params
 *
 * @category   Tools
 * @package    Library
 * @author     Brice POTE
 */
class Hgp_Lib_Service_AvailPro
{
	/**
	 * Username
	 *
	 * @var string
	 */
	static protected $_strUsername = 'Vianney';

	/**
	 * Password
	 *
	 * @var string
	 */
	static protected $_strPassword = 'parisinn';
	
	/**
	 * MagentoLogin
	 *
	 * @var string
	 */
	static protected $_strMagentoLogin = 'wsavailpro';
	
	/**
	 * MagentoAPIKey
	 *
	 * @var string
	 */
	static protected $_strMagentoApiKey = '1b6efe11cdde4194ab45f1aac5f070cf';
	
	/**
	 * MagentoUrlSoap
	 *
	 * @var string
	 */
	static protected $_strMagentoUrlSoap = 'http://www.hotelsgrandparis.com/api/?wsdl';

	/**
	 * Service url
	 *
	 * @var string
	 */
	static protected $_strServiceUrl = 'http://ws.availpro.com/BookingEngine/Availabilities/2009A/AvailabilityService.asmx?WSDL';

	/**
	 * Default currency code
	 *
	 * @var string
	 */
	static protected $_strCurrency = 'EUR';

	/**
	 * Current service instance
	 *
	 * @var Hgp_Lib_Service_AvailPro
	 */
	static protected $_instance;
	
	/**
	 * Default RoomType instance
	 *
	 * @var Hgp_Lib_Service_AvailPro
	 */
	static protected $_strRoomType;
	
	/**
	 * Soap client
	 *
	 * @var SoapClient
	 */
	static protected $_soap;

	/**
	 * Constructor
	 * Init instance
	 */
	public function __construct()
	{
		$arrSoapConfig = array(
			//'location'	=> self::$_strServiceUrl,
			//'uri'		=> self::$_strServiceUrl,
			'soap_version'	=> SOAP_1_2
		);

		self::$_soap = new SoapClient(self::$_strServiceUrl, $arrSoapConfig);

		self::$_instance = $this;
	}

	/**
	 * Returns instance
	 *
	 * @return Hgp_Lib_Service_AvailPro
	*/
	static public function getInstance()
	{
		if (!self::$_instance instanceof self) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Process request
	 * 
	 * @var string $aServiceName
	 * @var array $aParams
	 * @return stdClass
	 */
	protected function _call($aServiceName, $aParams)
	{
		try {
			$arrParams = array(array_merge(
				array(
					'login'		=> (string) self::$_strUsername,
					'password'	=> (string) self::$_strPassword
				),
				(array) $aParams
			));

			return call_user_func_array(array(self::$_soap, (string) $aServiceName), $arrParams);
		} catch (SoapFault $e) {
			echo $e->getMessage();
			// TODO: log exception
			return new stdClass();
		}		
	}

	/**
	 * Returns single hotel min/max prices
	 *
	 * @var int $aHotelId
	 * @return stdClass
	 */
	public function getSingleHotelPricingRanges($aHotelId, $beginDate = null, $_intNbDays = 30, $_strTypeRoom = 'Single', $_strTypePrice = 'LowestMeanPrice', $_intOccupancy = 0)
	{
		static $beginDate;
		$arrReturn = array();

		if (!isset($beginDate) || is_null($beginDate)) {
			$beginDate = Zend_Date::now('en_US');
		}
		$endDate = clone($beginDate);
		$endDate->add($_intNbDays, Zend_Date::DAY);

		$arrRequestParams = array(
			'beginDate'	=> $beginDate->toString('yyyy-MM-dd'),
			'endDate'	=> $endDate->toString('yyyy-MM-dd'),
			'RoomType'	=> $_strTypeRoom,
			'occupancy'	=> $_intOccupancy,
			'currency'	=> self::$_strCurrency,
			'hotelId'	=> (int) $aHotelId,
			'rateFilter'	=> $_strTypePrice
		);
		
		$response = $this->_call('GetSingleHotelPricingRanges', $arrRequestParams);
		
		if (isset($response->GetSingleHotelPricingRangesResult->failure)) {
			// TODO: log error
			$arrReturn = array( 'min' => null, 'max' => null );
		} else {
			if (isset($response->GetSingleHotelPricingRangesResult->pricingRangeResponse->hotel) && !empty($response->GetSingleHotelPricingRangesResult->pricingRangeResponse->hotel)){
				
				$rates = @$response->GetSingleHotelPricingRangesResult->pricingRangeResponse->hotel->rate;
				
				$rooms = (is_array($rates)) ? $rates[0] : $rates->room;
				if (isset($rooms->room)) {
					$rooms = $rooms->room;
				}
				$ranges = (is_array($rooms)) ? $rooms[0] : $rooms;
	
				$arrReturn = array(
					'min'	=> (isset($ranges->minimumPrice)) ? $ranges->minimumPrice : $ranges->price,
					'max'	=> (isset($ranges->maximumPrice)) ? $ranges->maximumPrice : $ranges->price
				);
			}
		}

		return (object) $arrReturn;
	}
	
	/**
	 * Returns All SOAP Response
	 * 
	 * Attention il s'agit d'un brouillon, à ne plus utiliser !!!
	 *
	 * @var int $aHotelId
	 * @return stdClass
	 */
	public function getAllAvailproRates($_intNbDays = 30, $_strTypeRoom = 'Single', $_strTypePrice = 'LowestMeanPrice')
	{
		static $beginDate;
		$arrReturn = array();

		if (!isset($beginDate)) {
			
			$beginDate = Zend_Date::now('en_US');
		}
		$endDate = clone($beginDate);
		$endDate->add($_intNbDays, Zend_Date::DAY);

		$arrRequestParams = array(
			'beginDate'	=> $beginDate->toString('yyyy-MM-dd'),
			'endDate'	=> $endDate->toString('yyyy-MM-dd'),
			'currency'	=> self::$_strCurrency,
			'roomType'	=> $_strTypeRoom,
			'rateFilter'=> $_strTypePrice
		);

		$response = $this->_call('GetPricingRanges', $arrRequestParams);
		
		if (isset($response->GetPricingRangesResult->failure)) {
			// TODO: log error
			$arrReturn = array();
		} else {
			if (isset($response->GetPricingRangesResult->pricingRangeResponse->hotel) && count($response->GetPricingRangesResult->pricingRangeResponse->hotel)) {

				foreach ($response->GetPricingRangesResult->pricingRangeResponse->hotel as $hotel) {
    				
					if ($_strTypePrice == 'None'){
						
						$rates = (is_array($hotel->rate)) ? $hotel->rate[0] : $hotel->rate;
	    				$rooms = (is_array($rates)) ? $rates[0] : $rates->room;
	                    $room = (is_array($rooms)) ? $rooms[0] : $rooms;
	                    
	                    $arrReturn[$hotel->id] = array(
	                        'min'   => isset($room->minimumPrice) ? $room->minimumPrice : 0,
	                        'max'   => isset($room->maximumPrice) ? $room->maximumPrice : 0,
	                    );
					}
					
					elseif ($_strTypePrice == 'LowestMinimumPrice'){
						
						$rates = (is_array($hotel->rate)) ? $hotel->rate[0] : $hotel->rate;
	    				$rooms = (is_array($rates)) ? $rates[0] : $rates->room;
	                    $room = (is_array($rooms)) ? $rooms[0] : $rooms;
	                    
	                    $arrReturn[$hotel->id] = array(
	                        'min'   => isset($room->minimumPrice) ? $room->minimumPrice : 0,
	                        'max'   => isset($room->maximumPrice) ? $room->maximumPrice : 0,
	                    );
					}
					
					elseif ($_strTypePrice == 'LowestMeanPrice'){
						
						$rates = (is_array($hotel->rate)) ? $hotel->rate[0] : $hotel->rate;
	    				$rooms = (is_array($rates)) ? $rates[0] : $rates->room;
	                    $room = (is_array($rooms)) ? $rooms[0] : $rooms;
	                    
	                    $arrReturn[$hotel->id] = array(
	                        'min'   => isset($room->minimumPrice) ? $room->minimumPrice : 0,
	                        'max'   => isset($room->maximumPrice) ? $room->maximumPrice : 0,
	                    );
					}					
										
					else return array();
                }
			}
		}
		return $arrReturn;
	}
}
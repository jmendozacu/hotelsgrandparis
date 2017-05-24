<?php
class Hgp_Meteo_Model_GoogleWeatherCache {
	/** City code input **/
	private $city_code = '';
	
	/** City label get on the google webservice **/
	private $city = '';
	
	private $lang = '';
	
	/** Domain of the google website **/
	private $domain = 'www.google.com';
	
	/** Prefix of the img link **/
	private $prefix_images = '';
	
	/** Array with current weather **/
	private $current_conditions = array();
	
	/** Array with forecast weather **/
	private $forecast_conditions = array();
	
	/** If the city was found **/
	private $is_found = true;

	/** The HTML response send by the service **/
	private $response;
	
	/**
	* Class constructor
	* @param $city_code is the label of the city
	* @param $lang the lang of the return weather labels
	* @return ...
	*/
	 
	function __construct ($city_code, $lang='fr', $prefix_img = null) {
		$this->city_code = $city_code;
		$this->lang = $lang;
		
		$this->prefix_images = ($prefix_img == null) ? 'http://'.$this->domain : $prefix_img;		
		//$this->prefix_images = '';		
		$this->url = 'http://'.$this->domain.'/ig/api?weather='.urlencode($this->city_code).'&hl='.$this->lang;
		//Zend_Debug::dump($this->url);exit;
		
		$getContentCode = $this->getContent($this->url);
		//Zend_Debug::dump($getContentCode);exit;
				
		if($getContentCode == 200) {
		
			$content = utf8_encode($this->response);
			$probleme = (preg_match("/Error\ 403\ /i", $content)) ? 'pasOK':'OK';
			//Zend_Debug::dump($content);exit;
			if('pasOK' == $probleme){
				$xml = false;
			}else{
				$xml = simplexml_load_string($content);
			}
			//Zend_Debug::dump($xml);exit;
			if(!isset($xml->weather->problem_cause) && (false != $xml)) {
				
				$xml = simplexml_load_string($content);

				$this->city = (string)$xml->weather->forecast_information->city->attributes()->data;

				$this->current_conditions['condition'] = (string)$xml->weather->current_conditions->condition->attributes()->data;
				$this->current_conditions['temp_f'] = (string)$xml->weather->current_conditions->temp_f->attributes()->data;
				$this->current_conditions['temp_c'] = (string)$xml->weather->current_conditions->temp_c->attributes()->data;
				$this->current_conditions['humidity'] = (string)$xml->weather->current_conditions->humidity->attributes()->data;
				if ($prefix_img == null){if ($prefix_img != null) $path_img = str_replace('/ig/images/weather/', '');
					
					$this->current_conditions['icon'] = (string)$xml->weather->current_conditions->icon->attributes()->data;
				} else {
					
					$this->current_conditions['icon'] = str_replace('/ig/images/weather/', 'big/', $this->prefix_images.(string)$xml->weather->current_conditions->icon->attributes()->data);
				}
				$this->current_conditions['wind_condition'] = (string)$xml->weather->current_conditions->wind_condition->attributes()->data;
				$this->current_conditions['forecast_date'] = (string)$xml->weather->forecast_information->forecast_date->attributes()->data;
								
				foreach($xml->weather->forecast_conditions as $this->forecast_conditions_value) {
					$this->forecast_conditions_temp = array();
					$this->forecast_conditions_temp['day_of_week'] = (string)$this->forecast_conditions_value->day_of_week->attributes()->data;
					$this->forecast_conditions_temp['low'] = (string)$this->forecast_conditions_value->low->attributes()->data;
					$this->forecast_conditions_temp['high'] = (string)$this->forecast_conditions_value->high->attributes()->data;
					if ($prefix_img == null){if ($prefix_img != null) $path_img = str_replace('/ig/images/weather/', '');
						
						$this->forecast_conditions_temp['icon'] = $this->prefix_images.(string)$this->forecast_conditions_value->icon->attributes()->data;
					} else {
						
						$this->forecast_conditions_temp['icon'] = str_replace('/ig/images/weather/', 'small/', $this->prefix_images.(string)$this->forecast_conditions_value->icon->attributes()->data);
					}
					$this->forecast_conditions_temp['condition'] = (string)$this->forecast_conditions_value->condition->attributes()->data;
					$this->forecast_conditions []= $this->forecast_conditions_temp;
				}
			} else {
				//exit('in');
				$this->is_found = false;
				//Zend_Debug::dump($this);exit;
			}
			
		} else {
			//trigger_error('Google results parse problem : http error '.$getContentCode,E_USER_WARNING);
			$this->is_found = false;
		}
	}
	
	/**
           * Get URL content using cURL.
          * 
          * @param string $url the url 
          * 
          * @return string the html code
          */
		  
	public function getContent($url)
    {
    	// has cache ?
    	$cacheId = 'weather_'.urlencode($this->city_code).'_hl_'.$this->lang;
    	
		// Cache location
    	//$ds = '/';
		$_cacheMeteo =  Mage::getBaseDir('cache') . '/meteo/';	
    	
    	$frontendOptions = array( 'automatic_serialization' => true );
		$backendOptions = array( 'cacheDir' => $_cacheMeteo );
		
		$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
		//$cache->remove($cacheId);
		$cacheValue = $cache->load($cacheId);
		
		if ($cacheValue) {
			$this->response = $cacheValue;
			return 200;
		}

		if (!extension_loaded('curl')) {
            throw new Exception('curl extension is not available');
        }
		
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url);
        $this->response = curl_exec($curl);
		$infos = curl_getinfo($curl);
        curl_close ($curl);
        
        // set cache
        $cache->setLifetime(7200); // 2 hours
        $cache->save($this->response, $cacheId);
        
        
        return $infos['http_code'];
    }
	
	/**
	 * Get the city
	 */
	 
	public function getCity() {
		return $this->city;
	}
	
	/**
	 * Get the city code
	 */
	 
	public function getCityCode() {
		return $this->city_code;
	}
	
	/**
	 * Get the current weather
	 */
	 
	public function getCurrent() {
		return $this->current_conditions;
	}
	
	/**
	 * Get the forecast weather
	 */
	 
	function getForecast() {
		return $this->forecast_conditions;
	}
	
	/**
	 * If teh city was found
	 */
	 
	function isFound() {
		return $this->is_found;
	}
	
}
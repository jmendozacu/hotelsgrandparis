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



final class Hgp_Lib_Tools 
{
	
	public static function loadConfig($section) 
	{
		$config = new Zend_Config_Ini ( 'app/code/local/Hgp/Lib/Hgpconfig.ini', $section );
		if ($config)
			return $config;
		else
			return false;
	}
	
	public static function GetCategoryName($idCategory) 
	{
		$_category = Mage::getModel ( 'catalog/category' )->load ( $idCategory );
		$strCategoryName = $_category->getName ();
		return $strCategoryName;
	}
	
//	public static function GetHtmlPrice($_price, $langue = 'fr') 
//	{
//		if ($langue == 'fr') {
//			$nombre_format = number_format ( $_price, 2, ',', ' ' );
//		} elseif ($langue == 'en') {
//			$nombre_format = number_format ( $_price, 2, '.', '' );
//		}
//		return $nombre_format;
//	}

	/**
	 * Permet de retourner le prix en fonction de la langue
	 * 
	 * @param Float $_price
	 * @param String $langue
	 * 
	 * return Strin $currency
	 */	
	public static function GetHtmlPrice($_price, $langue = 'fr') 
	{
		$locale = ('en' == $langue) ? 'en_US' : 'fr_FR';
		$currency = new Zend_Currency($locale);
		return $currency->toCurrency($_price, array( 'symbol' => '&euro;' ));
	}
	
	public static function GetCurrentDate($storeId) 
	{
		date_default_timezone_set('Europe/Paris');
		$country = ($storeId == 2) ? 'fr_FR' : 'en_US';
		return (string) Zend_Date::now($country);
	}
	
	/**
	 * Limite l'affichage d'une chaine de caracteres
	 * puis compl par ...
	 *
	 * @param String
	 * @return String
	 */
	public static function limiteAffichage($champ, $tailleMax) 
	{	
		if (strlen($champ) >= $tailleMax) {
			$champ = substr($champ, 0, $tailleMax);
			$espace = strrpos($champ, " ");
			$champ = substr($champ, 0, $espace)."...";
			return $champ;
		}
		return $champ;
	}

       /**
	 * continue l'affichage d'une chaine de caracteres
	 * sur plusieurs lignes
	 *
	 * @param String
	 * @return String
	 */
	public static function continueAffichage($champ, $tailleMax) 
	{	
		$newText = $champ;
		if (strlen($champ) >= $tailleMax) {			
			$newText = wordwrap($champ, $tailleMax, "\n", 0);
			return $newText;
		}
		return $newText;
	}
	
	/**
	 * En fonction du nombre d'etoiles de l'?tablissement
	 * On renvoit le nombre d'etoiles en image
	 *
	 * @param String
	 * @return String
	 */
	public static function drawStars($nb_etoiles, $big = false) 
	{
		// $nb_etoiles = 5;
		$_nomImg = (!$big) ? 'star.gif' : 'star_big.gif';
		$ds = '/';
		$_baseUrl = Mage::getBaseUrl ( 'media' ) . $ds;
		//$html = '<div class="stars_fh">';
		$html = '&nbsp;';
		for($i = 0; $i < ($nb_etoiles); $i ++) {
			$html .= "<img alt='" . $nb_etoiles . "' src='" . $_baseUrl . $_nomImg . "' class='stars' />" . "\n";
		}
		//$html .= '<div class="clear"></div>';
		//$html .= '</div>';
		return $html;
	}
	
	/**
	 * En fonction du nombre d'etoiles de l'?tablissement
	 * On renvoit le nombre d'etoiles en image
	 *
	 * @param String
	 * @return String
	 */
	public static function drawStarsHome($nb_etoiles, $gif = false) 
	{
		//$nb_etoiles = 5;
		$_nomImg = ($gif) ? $nb_etoiles.'.gif' : $nb_etoiles.'.png';
		$ds = '/';
		$_baseUrl = Mage::getBaseUrl ( 'media' ) . $ds;
		$html = '&nbsp;';
		$html .= "<img alt='" . $_nomImg . "' src='" . $_baseUrl . $_nomImg . "' class='stars_home' />";
		return $html;
	}
	
	/**
	 * En fonction du nombre d'etoiles de l'?tablissement
	 * On renvoit le nombre d'etoiles en image
	 *
	 * @param String
	 * @return String
	 */
	public static function drawStarsHomeChrome($nb_etoiles) 
	{
		//$nb_etoiles = 5;
		$_nomImg = $nb_etoiles.'_b.png';
		$ds = '/';
		$_baseUrl = Mage::getBaseUrl ( 'media' ) . $ds;
		$html = '&nbsp;';
		$html .= "<img alt='" . $_nomImg . "' src='" . $_baseUrl . $_nomImg . "' class='stars_home' />";
		return $html;
	}
	
	/**
	 * En fonction du nombre d'etoiles de l'?tablissement
	 * On renvoit le nombre d'etoiles en image
	 *
	 * @param String
	 * @return String
	 */
	public static function drawStarsHomeTxt($nb_etoiles) 
	{
		//$nb_etoiles = 5;
		$html = '';
		$nb_etoiles = (is_numeric($nb_etoiles)) ? $nb_etoiles:0;
		
		for($i = 0; $i < ((int) $nb_etoiles); $i ++) {
			$html .= "*";
		}
		return $html;
	}
	
	/**
	 * Retourner un parametre du fichier de config HGP
	 * On renvoit la valeur du parametre
	 *
	 * @param String
	 * @return String
	 */
	public static function getParamConfig($key, $param) 
	{
		
		$_hgpConfig = self::loadConfig ( $key );
		
		if ($_hgpConfig) {
			
			return $_hgpConfig->$param;
		}
		return 0;
	}
	
	/**
	 * Retourner un Array de l'attribut demande avec son code, son label, sa valeur
	 * Attention, ne fonctionne que sur la fiche produit
	 * On passe le code attribut, tel que renseign? dans le Backend et on retourne un Array
	 *
	 * @param String 
	 * @return String
	 */
	public static function getProductAttribute($codeAttribut) 
	{
		$attributes = new Mage_Catalog_Block_Product_View_Attributes ();
		$data = $attributes->getAdditionalData ();
		if (array_key_exists ( $codeAttribut, $data ))
			return $data [$codeAttribut];
		return false;
	}
	
	/**
	 * A remplir
	 *
	 * @param String 
	 * @return String
	 */
	public static function getProductAttributeValue($codeAttribut) 
	{
		$data = self::getProductAttribute ($codeAttribut);	
		if ($data) {
			return $data ['value'];
		}
		return false;
	}
	
	/**
	 * A remplir
	 *
	 * @param String 
	 * @return String
	 */
	public static function getProductAttributeLabel($_product, $codeAttribut) 
	{
		$attributeLabel = $_product->getResource()->getAttribute($codeAttribut)->getFrontendLabel();
        $translationArray = Mage::app()->getTranslator()->getResource()->getTranslationArray();    
        if (isset($translationArray["Mage_Catalog::".$attributeLabel]) && !empty($translationArray["Mage_Catalog::".$attributeLabel])) return $translationArray["Mage_Catalog::".$attributeLabel]; 
        return $attributeLabel;
	}
	
	/**
	 * A remplir
	 *
	 * @param String 
	 * @return String
	 */
	public static function getProductAttributeLabelValue($_product, $codeAttribut) 
	{
		$attributeLabelValue = $_product->getResource()->getAttribute($codeAttribut)->getFrontend()->getValue($_product);

		return $attributeLabelValue;       					
	}
	
	/**
	 * Retourner le nombre de d'etoile d'un hotel issu d'une liste
	 * Attention, ne fonctionne que dans les collections de produits
	 * On passe l'objet Product
	 *
	 * @param Model_Catalog_Product $_product 
	 * @return Integer
	 */
	public static function getNbStarsFromProductCollection($_product) 
	{
		$_nb_tmp_etoiles = $_product->getResource()->getAttribute('nb_etoile')->getFrontend()->getValue($_product);
		$_nb_etoile = ($_nb_tmp_etoiles) ? (int) $_nb_tmp_etoiles : 0;
		return $_nb_etoile;
	}
	
	public static function getAffiliationFromProductCollection($_product) 
	{
		$_response = false;
		$_response = $_product->getResource()->getAttribute('affiliation')->getFrontend()->getValue($_product);
		return $_response;
	}
	
	/**
	 * A remplir
	 *
	 * @param Model_Catalog_Product $_product 
	 * @param String $_attribute
	 * 
	 * @return $attributeValue String
	 */
	public static function getAttributeFromProductCollection($_product, $_attribute) 
	{
		$attributeValue = $_product->getResource()->getAttribute($_attribute)->getFrontend()->getValue($_product);
		return $attributeValue;
	}
	
	/**
	 * Un IdCategorie est transmis et on renvoit l'url
	 * d'une autre categorie parametree dans le fichier de config Hgpconfig.ini
	 * 
	 * La config a cet aspect : category.accueil.$_IdCategoryAccueil.Target = TargetCategoryId
	 * On renvoit l'url de la category : $_urlTargetCategory
	 *
	 * @param Integer $_IdCategoryAccueil 
	 * @return Sttring $_urlTargetCategory
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	public static function getUrlAccueilCategory($_IdCategoryAccueil) 
	{		
		
		$_urlTargetCategory = $_targetCategory = null;
		
		$_TargetCategory = self::getParamConfig('accueil', 'category')->accueil->$_IdCategoryAccueil->Target;

		if ($_TargetCategory){
			
			//$_urlTargetCategory = Mage::getModel('catalog/category')->load($_TargetCategory)->getUrl();
			$_urlTargetCategory = $_TargetCategory;
		
			return $_urlTargetCategory;
		
		} else {
			
				trigger_error('Probleme dans la config des category Accueil ');
			return false;
		}
	}
	
	public static function getCategoryByName($categoryName)
	{
		// Recherche de la categorie sur le nom
		$categoryCollection = Mage::getModel('catalog/category')
				            ->getCollection()
			        		->addFieldToFilter('name', $categoryName)
			        		->getLastItem()
		                    ->getId();
	    
		// On retrouve la categorie en question   		
		$category = Mage::getModel('catalog/category')->load($categoryCollection);
		                    
		if ($category){ 
			
			return $category; 
		}          
		return false;		            
	}
	
	/**
	 * A remplir
	 */
	public static function getProductBreadcrumbs() 
	{		
		$crumbs = array();
		$_product = Mage::registry('current_product');
		
		if ($_product){
			
			// Home
			$crumbs['home'] = array(
				//'label'=>Mage::helper('catalog')->__('Home'),
				'label'=>Mage::helper('catalog')->__('Paris'),
	            'title'=>Mage::helper('catalog')->__('Go to Home Page'),
	            'link'=>Mage::getBaseUrl(),
				'first' => 1,
				'last' => null,
				'readonly' => null
			);
			
			// Quartier
			$_productQuartier = self::getProductAttributeValue('quartier_fiche_hotel');
			$category = ($_productQuartier) ? self::getCategoryByName($_productQuartier): null;
			
			if ($category){
				$crumbs['category'.$category->getId()] = array(
					'label' => $category->getName(),
		            'title'=> $category->getName(),
		            'link'=> $category->getUrl(),
		            //'link'=> self::getUrlQuartier($category->getId()),
					'first' => null,
					'last' => null,
					'readonly' => null
				);
			}
			
			// Produit
			$crumbs['product'] = array(
				'label' => $_product->getName(),
	            'title' => $_product->getName(),
	            'link' => null,
				'first' => null,
				'last' => 1,
				'readonly' => null
			);
		}
		
		return $crumbs;
	}
	
	private static function getUrlQuartier($iDQuartier)
	{
		$url = Mage::getBaseUrl().'hotel.html?';
		$return = 'cat='.$iDQuartier;
		return $url.$return;			
	}
	
	/**
	 * On reecrit l'url en remplacant "en" par "/"
	 * 
	 *
	 * @param Integer $currentUrl 
	 * @return String $newUrl | $currentUrl
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	
	public static function hgpUrl($params = '')
	{
		
		$currentUrl = Mage::getUrl($params);
		
		$pattern = '#\/en\/#';
		$replace = '/';
        if ($newUrl = preg_replace($pattern, $replace, $currentUrl)) return $newUrl;
        
        return $currentUrl;
	}
	
	/**
	 * On reecrit l'url en remplacant "en" par "/"
	 * 
	 *
	 * @param Integer $currentUrl 
	 * @return String $newUrl | $currentUrl
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	public static function hgpUrlProduit($productUrl)
	{
			
		$pattern = '#\/en\/#';
		$replace = '/';
        if ($newUrl = preg_replace($pattern, $replace, $productUrl)) return $newUrl;
        
        return $productUrl;
	}
	
	/**
	 * Recuperation du code langue de la boutique
	 * 
	 *
	 * @param Integer $key 
	 * @return String en | fr
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	public static function getStoreLanguage($key)
	{
			
		$_arrLang = array(1 => 'en', 2 => 'fr');
	
		if (array_key_exists($key,$_arrLang)){
			return $_arrLang[$key];
		}
        return $_arrLang[1];
	}
	
		/**
	 * Permet de m�langer un tableau
	 * 
	 *
	 * @param Array $tableau 
	 * @return Array 
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	public static function melangeTableau(array $tableau) 
	{
		
		$result = $tableau;
		srand ((float) microtime() * 10000000000);
		
		if (shuffle($tableau)) {
			
			$result = $tableau;
		}
		
		return $result;
	}
	
	/**
	 * Permet de tirer au hasard des �l�ments d'un tableau
	 * 
	 *
	 * @param Array $tableau 
	 * @return Array | false
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	public static function tireAuHasard(array $tableau) 
	{
		
		if (! empty ($tableau)) {
			
			$randKey = array_rand ($tableau);
			return $tableau [$randKey];
		} else return false;
	}
	
		/**
	 * Recuperation du code du boukingEngine en fonction de la langue
	 * 
	 *
	 * @param Integer $storeId 
	 * @return Array $bookingEngine
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	public static function getBookingEngine($storeId)
	{
			
		$_arrBookingEngine = array(
			1 => array('BookingCode' => '2GS6','BookingLangage' => 'EN'), 
			2 => array('BookingCode' => '233E','BookingLangage' => 'FR')
		);
	
		if (array_key_exists($storeId,$_arrBookingEngine)){
			return $_arrBookingEngine[$storeId];
		}
        return $_arrBookingEngine[$storeId];
	}
	
	public static function getBrowserInfo() 
	{
			$user_agent = getenv ( "HTTP_USER_AGENT" );
			
			if ((strpos ( $user_agent, "Nav" ) !== FALSE) || (strpos ( $user_agent, "Gold" ) !== FALSE) || (strpos ( $user_agent, "X11" ) !== FALSE) || (strpos ( $user_agent, "Mozilla" ) !== FALSE) || (strpos ( $user_agent, "Netscape" ) !== FALSE) and (! strpos ( $user_agent, "MSIE" ) !== FALSE) and (! strpos ( $user_agent, "Konqueror" ) !== FALSE) and (! strpos ( $user_agent, "Firefox" ) !== FALSE) and (! strpos ( $user_agent, "Safari" ) !== FALSE))
				$browser = "Netscape";
			elseif (strpos ( $user_agent, "Opera" ) !== FALSE)
				$browser = "Opera";
			elseif ((strpos ( $user_agent, "MSIE" ) > 0) && (strpos ( $user_agent, "8.0" ) > 0))
				$browser = "MSIE8.0";
			elseif ((strpos ( $user_agent, "MSIE" ) > 0) && (strpos ( $user_agent, "7.0" ) > 0))
				$browser = "MSIE7.0";
			elseif ((strpos ( $user_agent, "MSIE" ) > 0) && (strpos ( $user_agent, "6.0" ) > 0))
				$browser = "MSIE6.0";
			elseif ((strpos ( $user_agent, "MSIE" ) > 0) && (strpos ( $user_agent, "5.5" ) > 0))
				$browser = "MSIE5.5";
			elseif ((strpos ( $user_agent, "MSIE" ) > 0) && (strpos ( $user_agent, "5.01" ) > 0))
				$browser = "MSIE5.01";
			elseif (strpos ( $user_agent, "Lynx" ) !== FALSE)
				$browser = "Lynx";
			elseif (strpos ( $user_agent, "WebTV" ) !== FALSE)
				$browser = "WebTV";
			elseif (strpos ( $user_agent, "Konqueror" ) !== FALSE)
				$browser = "Konqueror";
			elseif ((strpos ( $user_agent, "Safari" ) !== FALSE) && (stripos ( $user_agent, "Chrome" ) === FALSE))
				$browser = "Safari";
			elseif (strpos ( $user_agent, "Firefox" ) !== FALSE)
				$browser = "Firefox";
			elseif (stripos ( $user_agent, "Chrome" ) !== FALSE)
				$browser = "Chrome";
			elseif ((stripos ( $user_agent, "bot" ) !== FALSE) || (strpos ( $user_agent, "Google" ) !== FALSE) || (strpos ( $user_agent, "Slurp" ) !== FALSE) || (strpos ( $user_agent, "Scooter" ) !== FALSE) || (stripos ( $user_agent, "Spider" ) !== FALSE) || (stripos ( $user_agent, "Infoseek" ) !== FALSE))
				$browser = "Bot";
			else
				$browser = "Autre";

			return $browser;
		}
		
		/**
		 * 
		 * Permet d'extraire une collection de nb_item aleatoirement
		 * @param array $_collection
		 * @param int $nb_items
		 */
		public static function getShortCollectionByRand(array $_collection, $nb_items = 0)
		{
						 
			$results = array();
			//exit('nb_itemps = ' .$nb_items);
			$arrDatas = $_collection;
			
			if ($arrDatas) $results = self::melangeTableau($arrDatas);
			
			if (($results) && ($nb_items > 0)){
			 
				/**
				 * On prend tout le tableau
				 * mais on ne retourne que le nombre d'items
				 * necessaire
				 */
				for($i = 0; $i < $nb_items; $i++){		        
					$result[] = $results[$i];
				}
			} else {		    
				$result = $arrDatas;
			}	
			//print_r($result);exit;					
			return $result;
			
		}
		
	/**
	 * On reecrit l'url en remplacant "en" par "/"
	 * 
	 *
	 * @param Integer $currentUrl 
	 * @return String $newUrl | $currentUrl
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	
	public static function hgpShortUrl($url, $params='', $suffixe='')
	{	
		$newUrl = '';
		$pattern = (trim($params) != '') ? '#'.$params.'#' : '#'.Mage::getBaseUrl().'#' ;
		$replace = '';
		
		$newUrl = preg_replace($pattern, $replace, $url);
		
		if(trim($suffixe!='')){
			$pattern = '#\.'.$suffixe.'#';
			$newUrl = preg_replace($pattern, $replace, $newUrl);
		}
		
        if (trim($newUrl)!='') return $newUrl;
        
        return $url;
	}
	
	/**
	 * On reecrit l'url en remplacant "en" par "/"
	 * 
	 *
	 * @param Integer $currentUrl 
	 * @return String $newUrl | $currentUrl
	 * 
	 * Author : Brice POTE Hotels Grand Paris
	 */
	
	public static function getAlternateLangUrl($storeId=1, $monUrl)
	{	
		$arrLang = array(1 => 'en', 2 => 'fr');
		$html = "";
		$count = count($arrLang);
		$cleanUrl =  substr($monUrl, 1, (strlen($monUrl) - 1));
		
		if((int)$storeId > 1){
			$cleanUrl = substr($monUrl, 4, (strlen($monUrl) - 4));
		}
		
		//$urlMageBase = "http://www.hotelsgrandparis.com/";
		$urlMageBase = "http://preprod2.hotelsgrandparis.com/";
		//Nettoyage complet de l'url
		$cleanUrl = preg_replace("#\?__.*#", "", $cleanUrl);
		
		for($i=1;$i<=$count;$i++){
			if($i != $storeId){
				$urlMageBase = (1 == $i) ? $urlMageBase : $urlMageBase . $arrLang[$i] . '/';
				$html .=  '<link rel="alternate" hreflang="' . $arrLang[$i] . '" href="' . $urlMageBase . $cleanUrl . '" />' . "\n";
			}
		}
        return $html . "\n";
	}
	
	public static function redirige($url, $delai = null)
	{
	    if ((!$delai) || ($delai == null)) {
	        $delai = 0;
	    }
	
	    die('<meta http-equiv="refresh" content=' . $delai . ';URL=' . $url . '>');
	}
	
	/**
	 * Recuperation du code langue pour Fastbooking
	 *
	 *
	 * @param Integer $storeId
	 * @return String en | fr
	 *
	 * Author : Brice POTE Hotels Grand Paris
	 */
	public static function getFBLanguage($key)
	{
			
		$_arrLang = array(1 => 'uk', 2 => 'france', 3 => 'italy', 4 => 'germany', 5 => 'spain');
			
		if (array_key_exists($key,$_arrLang)){
			return $_arrLang[$key];
		}
		return $_arrLang[1];
	}
	
	/**
	 * Recuperation du code langue pour Fastbooking
	 *
	 *
	 * @param Integer $storeId
	 * @return String en | fr
	 *
	 * Author : Brice POTE Hotels Grand Paris
	 */
	public static function dump($variable, $exit=true)
	{
			
		echo '<font color="red" weight="bold" size="14px">';
		Zend_Debug::dump($variable);
		echo '</font>';
		if($exit) exit;
	}
	
}

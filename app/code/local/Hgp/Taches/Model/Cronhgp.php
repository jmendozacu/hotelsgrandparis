<?php

class Hgp_Taches_Model_Cronhgp extends Mage_Core_Model_Abstract 
{
	static protected $intCategory     = 6;
	static protected $intAttribSet    = 26;
	static protected $intPdtStatus    = 1;
	static protected $intNullPrice    = 0;
	static protected $intStore        = 0;	
		
	static protected $strMageWSLogin  = 'wsavailpro';
	static protected $strMageWSPasswd = '1b6efe11cdde4194ab45f1aac5f070cf';
	static protected $strMageWSUrl    = 'api/soap/?wsdl';
	static protected $strLogFile      = 'app/code/local/Hgp/Lib/Logs/AvailproPrices.log';
	
	const CRON_STRING_PATH            = 'taches/settings/setting_cron'; 
	const NB_JOURS                    = 'taches/availpro/availpro_nb_jrs';
	const TYPE_ROOM                   = 'taches/availpro/availpro_type_room';
	const TYPE_PRICE                  = 'taches/availpro/availpro_type_price';
	const TEST_PRICE                  = 'taches/settings/availpro_test_price';
	const TEST_MODE                   = 'taches/settings/test_mode';
	const OCCUPANCY                   = 'taches/availpro/chambre_libre';
	
	
	public function _construct() 
	{
		parent::_construct();
		$this->_init ('taches/cronhgp');
	}
	
	/**
	 * Returns single true/false
	 * Attention il s'agit d'un brouillon, à ne plus utiliser !!!
	 *
	 * @var array $arrProductionCollection
	 * @return bool TRUE|FALSE
	 */
	public function majPricesByAvailproByListSoap()
	{
				
		//Url de la connexion
		$client  = new SoapClient(Mage::getBaseUrl() . self::$strMageWSUrl);
		
		//Login
		$session = $client->login(self::$strMageWSLogin, self::$strMageWSPasswd);
		
		//Retour
		$_arrRetour = array();
		$ligne = $html = '';
		
		if($session){
			
			// Liste Produits			
			$_arrParams              = array('set' => self::$intAttribSet, 'status' => self::$intPdtStatus);			
			$arrProductionCollection = $client->call($session,'catalog_product.list', $_arrParams);
			
			if(!$arrProductionCollection){
				
				Mage::throwException('Aucun produit a traiter !!');
				return $_arrRetour;
			}
			
			// Trace dans les logs    	
//	   		$flux = @fopen(self::$strLogFile, 'w', false);
//	   		if (!$flux){
//	   			
//	   			Mage::throwException('Impossible d\'ouvrir le flux !!');
//	   			return $_arrRetour;
//	   		}
	   		
			// Reponse du SOAP Availpro
//			$_soapResponseList = Hgp_Lib_Service_AvailPro::getInstance()->getAllAvailproRates(Mage::getStoreConfig(self::NB_JOURS), Mage::getStoreConfig(self::TYPE_ROOM), Mage::getStoreConfig(self::TYPE_PRICE));            
//			if(!$_soapResponseList){
//	   			
//				Mage::throwException('La reponse SOAP est vide !!');
//	   			return $_arrRetour;
//	   		}
	   		
			// Data to update
			$count = count($arrProductionCollection);
			$compteurTraite = $compteurNonTraite = 0;

			if ($count){
				$html .= '<table width="600" border=0 cellpadding=0 cellspacing=0 style="">'; 
					$html .= '<caption style="width:600px;text-align:center;font-size:14px;font-family:Arial;font-weight:bold;color:#666;border:0;background:#FFF;">Liste des &eacute;tablissements trait&eacute;s</caption>';
					$html .= '<tr><th style="width:400px;text-align:center;font-size:12px;font-family:Arial;font-weight:bold;color:#FFF;border:1px solid #666;background:#666;">Hotel</th><th style="width:100px;text-align:center;font-size:12px;font-family:Arial;font-weight:bold;color:#FFF;border:1px solid #666;background:#666;">Ancien prix</th><th style="width:100px;text-align:center;font-size:12px;font-family:Arial;font-weight:bold;color:#FFF;border:1px solid #666;background:#666;">Nouveau prix</th></tr> ';
				for($i=0; $i< $count; $i++) {
		    		
					if(!isset($arrProductionCollection[$i]['product_id']) || empty($arrProductionCollection[$i]['product_id'])){
						
						Mage::throwException('Aucun ID produit !!');
						return $_arrRetour;
					}
					
					$product = Mage::getModel('catalog/product')
	                				->setStore(self::$intStore)
	                				->load((int) $arrProductionCollection[$i]['product_id']);
					
	                if ($product){   			
		    			
						// Information product
		    			$product_id  = $product->getId();	    			
		    			$_oldPrice   = $product->getPrice();
		    			$_hotelName  = $product->getName();
		    			$_availProId = $product->getData('availpro_id');	
	
		    			if(!Mage::getStoreConfig(self::TEST_MODE)){
		    			  
		    				//Si on a le prix nouveau Availpro sinon on met $intNullPrice
	                        $_tmpPrice = Hgp_Lib_Service_AvailPro::getInstance()->getSingleHotelPricingRanges($_availProId, $beginDate, Mage::getStoreConfig(self::NB_JOURS), $_availRoomType, Mage::getStoreConfig(self::TYPE_PRICE));
	                       
	                        $intPrice = ($_tmpPrice->min) ? $_tmpPrice->min : number_format(self::$intNullPrice, 4, '.', '');
		    			} else {
		                   
		    				//Tests
		                   $intPrice =  Mage::getStoreConfig(self::TEST_PRICE);
		    			}
	                    
	                    $_newPrice = number_format($intPrice, 4, '.', '');			
	                    $_oldPrice = number_format($_oldPrice, 4, '.', '');			
		    				    			
		    			// Arguments pour le SOAP Traitement
		    			$_arrProductData = array($product_id, array('price' => $_newPrice));
		    					    									
						if ((int)$_oldPrice > (int)$_newPrice){
							
							$_strDelta = 'moins';
						}
						elseif ((int)$_oldPrice < (int)$_newPrice){
							
							$_strDelta = 'plus';
						}
						else $_strDelta = 'egal';

		    			//On fait une mise a jour que si necessaire
		    			//if ($_newPrice != $_oldPrice){
		    			if (true){
			    			
		    				//Call
							$boolean = $client->call($session, 'catalog_product.update', $_arrProductData);
							$html .= '<tr>'; 
							if ($boolean){
					    		
								$compteurTraite++;
				    			//$ligne = 'Hotel => ' . $_hotelName . ' --> OK Ancien prix = ' . $_oldPrice. ' Nouveaux prix = ' . $_newPrice . "\n";			    		
				    			$html .= '<td style="text-align:left;padding-left:10px;font-size:11px;font-family:Arial;font-weight:normal;color:#666;border:1px solid #BEBCB7;background:#F8F7F5;">' . $_hotelName . '</td><td style="text-align:center;font-size:10px;font-family:Arial;font-weight:normal;color:#666;border:1px solid #BEBCB7;background:#FFF;">' . $_availRoomType . '</td><td style="text-align:center;font-size:10px;font-family:Arial;font-weight:normal;color:#666;border:1px solid #BEBCB7;background:#FFF;">' . number_format($_oldPrice, 2, '.', ''). '</td><td style="text-align:center;font-size:10px;font-family:Arial;font-weight:normal;color:#666;border:1px solid #BEBCB7;background:#FFF;">' . number_format($_newPrice, 2, '.', '') . '</td><td style="text-align:center;font-size:14px;font-family:Arial;font-weight:bold;color:#666;border:1px solid #BEBCB7;background:#FFF;color: '. $_arrDelta[$_strDelta]['couleur'] .'">' .$_arrDelta[$_strDelta]['symbole'] . '</td>';			    		
				    		} else {
				    			
				    			$compteurNonTraite++;
				    			//$ligne = 'Hotel => ' .$_hotelName . ' --> MAJ prix impossible Availpro ID => ' . $_availProId .  "\n";
				    			$html .= '<td>' . $_hotelName . '</td><td colspan="3"> MAJ prix impossible Availpro ID => ' . $_availProId .'</td>';
				    		}
				    		$html .= '</tr>';
				    		//fwrite($flux, $ligne);			    		
		    			} else {
		    				
		    				$compteurTraite++;
		    			}
		    		}
				}
				$html .= '</table><br /><br />';
			}
			//Logout
			$client->endSession($session);
			
			//Fermeture du ficher   	
	   		//$flux = @fclose(self::$strLogFile);
	   		
	   		// Gestion des dates
	   		date_default_timezone_set('Europe/Paris');	   									
			$date_debut = Zend_Date::now('fr_FR');
			$tmp_date = clone($date_debut);
			$tmp_date->add(Mage::getStoreConfig(self::NB_JOURS), Zend_Date::DAY);
			$tmp_date->get(Zend_Date::W3C);
	   		
	   		$_arrRetour['traite'] = $compteurTraite;
	   		$_arrRetour['non_traite'] = $compteurNonTraite;
	   		$_arrRetour['type_price'] = Mage::getStoreConfig(self::TYPE_PRICE);
	   		$_arrRetour['type_room']  = Mage::getStoreConfig(self::TYPE_ROOM);
	   		$_arrRetour['test_mode']  = Mage::getStoreConfig(self::TEST_MODE);
	   		$_arrRetour['date_debut'] = $date_debut;	   		
	   		$_arrRetour['date_fin']   = $tmp_date;
	   		$_arrRetour['nb_jours']   = Mage::getStoreConfig(self::NB_JOURS);
	   		$_arrRetour['occupancy']  = Mage::getStoreConfig(self::OCCUPANCY);
	   		$_arrRetour['detail']     = $html;
	   		
			return $_arrRetour;
		} else {
			
			return $_arrRetour;
		}
	}
	
	/**
	 * Returns single true/false
	 *
	 * @var array $arrProductionCollection
	 * @return bool TRUE|FALSE
	 */
	public function majPricesByAvailproByHotelSoap()
	{
				
		//Url de la connexion
		$client  = new SoapClient(Mage::getBaseUrl() . self::$strMageWSUrl);
		
		//Login
		$session = $client->login(self::$strMageWSLogin, self::$strMageWSPasswd);
		
		//Retour
		$_arrRetour = array();
		$ligne = $html = '';
		
		if($session){
			
			// Liste Produits			
			$_arrParams              = array('set' => self::$intAttribSet, 'status' => self::$intPdtStatus);			
			$arrProductionCollection = $client->call($session,'catalog_product.list', $_arrParams);
			
			if(!$arrProductionCollection){
				
				Mage::throwException('Aucun produit a traiter !!');
				return $_arrRetour;
			}

			// Data to update
			$count = count($arrProductionCollection);
			$compteurTraite = $compteurNonTraite = 0;
			
			// Delta
			$_arrDelta = array(
				'plus'  => array('couleur' => 'green', 'symbole' => '+'),
				'moins' => array('couleur' => 'red', 'symbole' => '-'),
				'egal'  => array('couleur' => 'grey', 'symbole' => '='),
				);

			if ($count){
					
					$html .= '<table width="600" border=0 cellpadding=0 cellspacing=0 style="">'; 
					$html .= '<caption style="width:600px;text-align:center;font-size:14px;font-family:Arial;font-weight:bold;color:#666;border:0;background:#FFF;">Liste des &eacute;tablissements trait&eacute;s</caption>';
					$html .= '<tr><th style="width:300px;text-align:center;font-size:12px;font-family:Arial;font-weight:bold;color:#FFF;border:1px solid #666;background:#666;">Hotel</th><th style="width:100px;text-align:center;font-size:12px;font-family:Arial;font-weight:bold;color:#FFF;border:1px solid #666;background:#666;">Room Type</th><th style="width:100px;text-align:center;font-size:12px;font-family:Arial;font-weight:bold;color:#FFF;border:1px solid #666;background:#666;">Ancien prix</th><th colspan="2" style="width:100px;text-align:center;font-size:12px;font-family:Arial;font-weight:bold;color:#FFF;border:1px solid #666;background:#666;">Nouveau prix</th></tr> ';
				for($i=0; $i< $count; $i++) {
		    		
					if(!isset($arrProductionCollection[$i]['product_id']) || empty($arrProductionCollection[$i]['product_id'])){
						
						Mage::throwException('Aucun ID produit !!');
						return $_arrRetour;
					}
					
					$product = Mage::getModel('catalog/product')
	                				->setStore(self::$intStore)
	                				->load((int) $arrProductionCollection[$i]['product_id']);
					
	                if ($product){   			
	                	/* Attention reste a  faire : augmenter la securisation si l'attribut "room_type_base" n'existe pas !!!*/
						// Information product
		    			$product_id     = $product->getId();	    			
		    			$_oldPrice      = $product->getPrice();
		    			$_hotelName     = $product->getName();
		    			$_availProId    = $product->getData('availpro_id');		    			
		    			$_availRoomType = Hgp_Lib_Tools::getProductAttributeLabelValue($product, 'room_type_base');	    			
		    			$_availRoomType = ($_availRoomType == 'No') ? Mage::getStoreConfig(self::TYPE_ROOM) : $_availRoomType;
		    			
		    			//Date de debut pour le traitement
		    			$beginDate   = Zend_Date::now('en_US');
		    			
		    			//Date pour le rapport
		    			date_default_timezone_set('Europe/Paris');	   									
						$date_debut = Zend_Date::now('fr_FR');
		    			
		    			if(!Mage::getStoreConfig(self::TEST_MODE)){
		    			  
		    				//Si on a le prix nouveau Availpro sinon on met $intNullPrice
	                        $_tmpPrice = Hgp_Lib_Service_AvailPro::getInstance()->getSingleHotelPricingRanges($_availProId, $beginDate, Mage::getStoreConfig(self::NB_JOURS), $_availRoomType, Mage::getStoreConfig(self::TYPE_PRICE), Mage::getStoreConfig(self::OCCUPANCY));
	                       
	                        $intPrice = ($_tmpPrice->min) ? $_tmpPrice->min : number_format(self::$intNullPrice, 4, '.', '');
		    			} else {
		                   
		    				//Tests
		                    $intPrice =  Mage::getStoreConfig(self::TEST_PRICE);
		    			}
	                    
	                    $_newPrice = number_format($intPrice, 4, '.', '');			
	                    $_oldPrice = number_format($_oldPrice, 4, '.', '');			
		    				    			
		    			// Arguments pour le SOAP Traitement
		    			$_arrProductData = array($product_id, array('price' => $_newPrice));
		    					    									
						if ((int)$_oldPrice > (int)$_newPrice){
							
							$_strDelta = 'moins';
						}
						elseif ((int)$_oldPrice < (int)$_newPrice){
							
							$_strDelta = 'plus';
						}
						else $_strDelta = 'egal';

		    			//On fait une mise a jour que si necessaire
		    			//if ($_newPrice != $_oldPrice){
		    			if (true){
			    			
		    				//Call
							$boolean = $client->call($session, 'catalog_product.update', $_arrProductData);
							$html .= '<tr>'; 
							if ($boolean){
					    		
								$compteurTraite++;		    		
				    			$html .= '<td style="text-align:left;padding-left:10px;font-size:11px;font-family:Arial;font-weight:normal;color:#666;border:1px solid #BEBCB7;background:#F8F7F5;">' . $_hotelName . '</td><td style="text-align:center;font-size:10px;font-family:Arial;font-weight:normal;color:#666;border:1px solid #BEBCB7;background:#FFF;">' . $_availRoomType . '</td><td style="text-align:center;font-size:10px;font-family:Arial;font-weight:normal;color:#666;border:1px solid #BEBCB7;background:#FFF;">' . number_format($_oldPrice, 2, '.', ''). '</td><td style="text-align:center;font-size:10px;font-family:Arial;font-weight:normal;color:#666;border:1px solid #BEBCB7;background:#FFF;">' . number_format($_newPrice, 2, '.', '') . '</td><td style="text-align:center;font-size:14px;font-family:Arial;font-weight:bold;color:#666;border:1px solid #BEBCB7;background:#FFF;color: '. $_arrDelta[$_strDelta]['couleur'] .'">' .$_arrDelta[$_strDelta]['symbole'] . '</td>';			    		
				    		} else {
				    			
				    			$compteurNonTraite++;
				    			$html .= '<td>' . $_hotelName . '</td><td colspan="3"> MAJ prix impossible Availpro ID => ' . $_availProId .'</td>';
				    		}
				    		$html .= '</tr>';			    		
		    			} else {
		    				
		    				$compteurTraite++;
		    			}
		    		}
				}
				$html .= '</table><br /><br />';
			}
			//Logout
			$client->endSession($session);
	   		
	   		// Gestion des dates a la fin traitement	   		
			$tmp_date = clone($date_debut);
			$tmp_date->add(Mage::getStoreConfig(self::NB_JOURS), Zend_Date::DAY);
			$tmp_date->get(Zend_Date::W3C);
	   		
	   		$_arrRetour['traite'] = $compteurTraite;
	   		$_arrRetour['non_traite'] = $compteurNonTraite;
	   		$_arrRetour['type_price'] = Mage::getStoreConfig(self::TYPE_PRICE);
	   		$_arrRetour['type_room']  = Mage::getStoreConfig(self::TYPE_ROOM);
	   		$_arrRetour['test_mode']  = Mage::getStoreConfig(self::TEST_MODE);
	   		$_arrRetour['date_debut'] = $date_debut;	   		
	   		$_arrRetour['date_fin']   = $tmp_date;
	   		$_arrRetour['nb_jours']   = Mage::getStoreConfig(self::NB_JOURS);
	   		$_arrRetour['occupancy']  = Mage::getStoreConfig(self::OCCUPANCY);
	   		$_arrRetour['detail']     = $html;
	   		
			return $_arrRetour;
		} else {
			
			return $_arrRetour;
		}
	}
}
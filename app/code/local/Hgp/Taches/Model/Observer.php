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
class Hgp_Taches_Model_Observer 
{
	
    const XML_PATH_EMAIL_TEMPLATE   = 'taches/email/email_template';
	const XML_PATH_EMAIL_SENDER     = 'taches/email/sender_email_identity';
	const CRON_STRING_PATH          = 'taches/settings/setting_cron'; 
	//const CRON_STRING_PATH          = 'crontab/jobs/taches/run/schedule/cron_expr'; 
	const CRON_EMAIL_RECIPIENT      = 'taches/email/email_recipient'; 

	static protected $intStore      = 0;
	
	/**
	 * Mise a jour des prix
	 * via le SOAP de Availpro
	 * 
	 * @param String $schedule
	 */
    public function dailyMinMeanPricesUpdate($schedule) 
	{
 		
		if(!Mage::getStoreConfig(self::CRON_STRING_PATH)) {
            return;
        }
        
		// Debut du traitement
		$arrResponse = Mage::getModel('taches/cronhgp')->majPricesByAvailproByHotelSoap(Mage::getStoreConfig(self::CRON_STRING_PATH));
		
		if ($arrResponse){
			
            $model = Mage::getModel('admin/user');
			
			$arrDestinataire = explode(',', Mage::getStoreConfig(self::CRON_EMAIL_RECIPIENT));            
			foreach($arrDestinataire as $_user){
			
				$_user = $model->loadByUsername(trim($_user));

				if ($_user){
					$mailTemplate = Mage::getModel('core/email_template');
		
					$mailTemplate->setDesignConfig(array('area' => 'frontend'))
								 ->sendTransactional(
										Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
										Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
										$_user->getEmail(),
										$_user->getName(),
										array(
											'name' => $_user->getName(), 
											'lastname' => $_user->getName(), 
											'OK' => $arrResponse['traite'], 
											'PasOK' => $arrResponse['non_traite'],
											'typeprice' => $arrResponse['type_price'],
											'typeroom' => $arrResponse['type_room'],
											'modetest' => ($arrResponse['test_mode']) ? 'Oui':'Non',
											'datedebut' => ($arrResponse['date_debut']) ? $arrResponse['date_debut']:'Non connue',
											'datefin' => ($arrResponse['date_fin']) ? $arrResponse['date_fin']:'Non connue', 
											'nbjours' => ($arrResponse['nb_jours']) ? $arrResponse['nb_jours']:'Non connue', 
											'occupancy' => ($arrResponse['occupancy']) ? 'Oui':'Non', 
											'detail' => $arrResponse['detail']
										)
						          );
				}
			}
				//}
				
			// Rafraichissement du cache
//			if ($boolean) {
//	            Mage::app()->reinitStores();
//	            Mage::getModel('catalog/url')->refreshRewrites(self::$intStore);
//	            Mage::getResourceModel('catalog/category')->refreshProductIndex(
//	                array(),
//	                array(),
//	                array(self::$intStore)
//	            );
//	            if (Mage::helper('catalog/category_flat')->isEnabled(true)) {
//	                Mage::getResourceModel('catalog/category_flat')->synchronize(null, array(self::$intStore));
//	            }
//	        }				          
		}

    }
}
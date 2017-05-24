<?php
class Hgp_Linksexchange_IndexController extends Mage_Core_Controller_Front_Action
{
        const XML_PATH_EMAIL_SENDER     = 'linksexchange/email_rapport/sender_email_identity';
        const XML_PATH_EMAIL_TEMPLATE   = 'linksexchange/email_internaute/email_template';
        const XML_PATH_EMAIL_RAPPORT_SENDER     = 'linksexchange/email_rapport/sender_email_identity';
        const XML_PATH_EMAIL_RAPPORT_TEMPLATE   = 'linksexchange/email_rapport/email_template';
        const XML_PATH_EMAIL_RAPPORT_RECIPIENT  = 'linksexchange/email_rapport/email_recipient';
        
        public function preDispatch() 
        {
            parent::preDispatch();
        
//             if( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
//                 $this->norouteAction();
//             }
        }
        
        public function indexAction() 
        {
            $this->loadLayout();
//             $this->getLayout()->getBlock('linksexchange')->setFormAction( Mage::getUrl('*/*/post') );
        
//             $this->_initLayoutMessages('customer/session');
//             $this->_initLayoutMessages('catalog/session');

			//exit('on rentre');
            $this->renderLayout();
        }
        
        public function postAction() 
        {
            $_data = $this->getRequest()->getPost();
            //Zend_Debug::dump($_data);exit;
            
            if ($_data) {
                //Securisation des DATAS
                $data = Mage::Helper('linksexchange')->escaptePostDatas($_data);

                $translate = Mage::getSingleton('core/translate');
                /* @var $translate Mage_Core_Model_Translate */
                $translate->setTranslateInline(false);
        
                try {
                    $postObject = new Varien_Object();
                    $postObject->setData($data);
                   
                    $error = false;
        
                    //if (!Zend_Validate::is($data['hgp_linksexchange_site_name'], 'NotEmpty')) $error = true;
                    //if (!Zend_Validate::is($data['hgp_linksexchange_site_description'], 'NotEmpty')) $error = true;
                    if (!Zend_Validate::is($data['hgp_linksexchange_site_url_link'], 'NotEmpty')) $error = true;
                    if (!Zend_Validate::is($data['hgp_linksexchange_ordre'], 'NotEmpty')) $error = true;
                    //if (!Zend_Validate::is($data['hgp_linksexchange_contact_tel'], 'NotEmpty')) $error = true;
                    //if (!Zend_Validate::is($data['hgp_linksexchange_site_page_cible'], 'NotEmpty')) $error = true;
                    //if (!Zend_Validate::is($data['hgp_linksexchange_contact_email'], 'EmailAddress')) $error = true;
                    
                    if ($error) throw new Exception();
        
                    $mailTemplate = Mage::getModel('core/email_template');
		
                	if (trim($data['hgp_linksexchange_contact_email']) != ''){
					
                	$mailTemplate = Mage::getModel('core/email_template');
		
					$mailTemplate->setDesignConfig(array('area' => 'frontend'))
								 ->sendTransactional(
										Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
										Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
										$data['hgp_linksexchange_contact_email'],
										null,
										array()
						          );
					}
        
                    if (!$mailTemplate->getSentSuccess()) {
                        throw new Exception();
                    }
        
                    $model = Mage::getModel('linksexchange/linksexchange')
                        ->setId(null)
                        ->setHgpLinksexchangeCategory(1)
                        ->setHgpLinksexchangeStoreId((int)Mage::app()->getStore()->getId())
                        ->setHgpLinksexchangeSiteName($data['hgp_linksexchange_site_name'])
                        ->setHgpLinksexchangeSiteDescription($data['hgp_linksexchange_site_description'])
                        ->setHgpLinksexchangeSiteUrlLabel($data['hgp_linksexchange_site_name'])
                        ->setHgpLinksexchangeSiteUrlLink(str_replace("http://", "", $data['hgp_linksexchange_site_url_link']))
                        ->setHgpLinksexchangeSiteUrlTitle($data['hgp_linksexchange_site_name'])
                        ->setHgpLinksexchangeContactEmail($data['hgp_linksexchange_contact_email'])
                        //->setHgpLinksexchangeContactEmail('brice.pote@free.fr')
                        ->setHgpLinksexchangeContactTel($data['hgp_linksexchange_contact_tel'])
                        //->setHgpLinksexchangeSitePageCible($data['hgp_linksexchange_site_page_cible'])
                        ->setHgpLinksexchangeSitePageCible(str_replace("http://", "", $data['hgp_linksexchange_site_page_cible']))
                        ->setHgpLinksexchangeOrdre(1)
                        ->setHgpLinksexchangeDateCreation(Mage::getSingleton('core/date')->gmtDate())
                        ->setHgpLinksexchangeDateModification(Mage::getSingleton('core/date')->gmtDate())
                        ->setHgpLinksexchangeUserModif('')
                        ->setHgpLinksexchangeActif(0);
                    
                    $model->save();
                    
                    //Envoi de la notification
                    $model = Mage::getModel('admin/user');
                    	
                    $arrDestinataire = explode(',', Mage::getStoreConfig(self::XML_PATH_EMAIL_RAPPORT_RECIPIENT));
                    //Zend_Debug::dump($arrDestinataire);exit;
                    
                    foreach($arrDestinataire as $_user){
                        	
                        $_user = $model->loadByUsername(trim($_user));
                    
                        if($_user){
                            
                            $date_creation = new Zend_Date();
                            
                            $mailTemplateRapport = Mage::getModel('core/email_template');
                    
                            $mailTemplateRapport->setDesignConfig(array('area' => 'frontend'))
                                                ->sendTransactional(
                                                    Mage::getStoreConfig(self::XML_PATH_EMAIL_RAPPORT_TEMPLATE),
                                                    Mage::getStoreConfig(self::XML_PATH_EMAIL_RAPPORT_SENDER),
                                                    $_user->getEmail(),
                                                    $_user->getName(),
                                                    array(
                                                        'PrenomUser' => $_user->getName(),
                                                        'Nomdusite' => $data['hgp_linksexchange_site_name'],
                                                        'Description' => $data['hgp_linksexchange_site_description'],
                                                        'URLdusite' => str_replace("http://", "", $data['hgp_linksexchange_site_url_link']),
                                                        'Telephone' => $data['hgp_linksexchange_contact_tel'],
                                                        'Email' => $data['hgp_linksexchange_contact_email'],
                                                        'Datedelademande' => Mage::helper('linksexchange')->getFrenchDate($date_creation)
                                                    )
                                                 );
                        
                            if(!$mailTemplateRapport->getSentSuccess()) {
                                throw new Exception();
                            }
                        }else{
                            throw new Exception('Aucun user trouvé !');
                        }
                    }
                    $translate->setTranslateInline(true);
                    //Mage::getSingleton('customer/session')->addSuccess(Mage::helper('linksexchange')->__('Your inquiry was submitted'));
        
                    //$this->_redirect('*/*/');
                    Hgp_Lib_Tools::redirige(Mage::getUrl() . 'des-adresses-authentiques.html?status=OK');
        
                    return;
                } catch (Exception $e) {
                    Zend_Debug::dump($e);exit;
                    $translate->setTranslateInline(true);
                    //Mage::getSingleton('customer/session')->addError(Mage::helper('linksexchange')->__('Unable to submit your request. Please, try again later'));
                    //$this->_redirect('*/*/');
                    Hgp_Lib_Tools::redirige(Mage::getUrl() . 'des-adresses-authentiques.html?status=NotOK');
                    return;
                }
        
            } else {
                Hgp_Lib_Tools::redirige(Mage::getUrl() . 'des-adresses-authentiques.html?status=NotOK');
            }
        }              
}
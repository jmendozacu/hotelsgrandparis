<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Contacts
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Contacts index controller
 *
 * @category   Mage
 * @package    Mage_Contacts
 * @author      Magento Core Team <core@magentocommerce.com>
 */

require_once 'Mage/Contacts/controllers/IndexController.php';

class Hgp_Contacts_IndexController extends Mage_Contacts_IndexController
{

    const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';

    public function preDispatch()
    {
        parent::preDispatch();

        if( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
            $this->norouteAction();
        }
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('contactForm')
            ->setFormAction( Mage::getUrl('*/*/post') );

        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
    }

    public function postAction()
    {
        $post = $this->getRequest()->getPost();
		
        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }
                if ($error) {
                    throw new Exception();
                }
                $mailTemplate = Mage::getModel('core/email_template');
                

            	/**
                 * On envoit le mail a l'hotel
                 * Aussi a HGP
                 * */      
                $_destinaire = trim($post['destinataire']);        
                if(isset($_destinaire) && !empty($_destinaire)){
	                $_arrEmailRecipient = array($_destinaire);
					$_nomDdestinaire = trim($post['nomDestinataire']);
					$_envoi_rapport = true;
                	//$_arrEmailRecipient = array('brice.pote@hotelsgrandparis.com', Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT));
            	}else{	                
            		$_arrEmailRecipient = array(Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT));
					$envoi_rapport = false;
            	}
                //Zend_debug::dump($_arrEmailRecipient);exit;
                $count = count($_arrEmailRecipient);
                
                for($i=0;$i<$count;$i++){

                	$mailTemplate->setDesignConfig(array('area' => 'frontend'))
	                    ->setReplyTo($post['email'])
	                    ->sendTransactional(
	                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
	                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
	                        $_arrEmailRecipient[$i],
	                        null,
	                        array('data' => $postObject)
	                    );
                }

                if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }
                
            	/**
                  * HGP est informe
                  * 
                  * */
                 if((trim($_destinaire) != '') && $_envoi_rapport){
	                 $to_email = 'equipe@hotelsgrandparis.com';
					 $to_name = 'Equipe HGP';
					 $subject = utf8_decode('Un mail de contact vient d\'être envoyé à l\'hôtel : ').trim(utf8_decode($_nomDdestinaire));
					 $Body = '<html><body>';
					 $Body .= '<p>Name : '.trim(utf8_decode($post['name'])).'</p>';
					 $Body .= '<p>E-mail : '.trim($post['email']).'</p>';
					 $Body .= '<p>Message : '.trim(utf8_decode($post['comment'])).'</p>';
					 $Body .= '<p>Hotel : '.trim(utf8_decode($_nomDdestinaire)).'</p>';
					 $Body .= '<p>Hotel Email : '.trim(utf8_decode($_destinaire)).'</p>';
					 $Body .= '</body></html>';
					 $sender_email = 'equipe@hotelsgrandparis.com';
					 $sender_name = 'Hotels Grand Paris';
					
					 $mail = new Zend_Mail(); //class for mail
					 $mail->setBodyHtml($Body); //for sending message containing html code
					 $mail->setFrom($sender_email, $sender_name);
					 $mail->addTo($to_email, $to_name);
					 //$mail->addCc($cc, $ccname);    //can set cc
					 //$mail->addBCc($bcc, $bccname);    //can set bcc
					 $mail->setSubject($subject);
					 $mail->send();
                 }

                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                $this->_redirect('*/');

                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later'));
                $this->_redirect('*/');
                return;
            }

        } else {
            $this->_redirect('*/');
        }
    }

}

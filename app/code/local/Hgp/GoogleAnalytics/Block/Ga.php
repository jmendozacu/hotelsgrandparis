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
 * @package    Mage_GoogleAnalytics
 * @copyright  Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * GoogleAnalitics Page Block
 *
 * @category   HGP
 * @package    Hgp_GoogleAnalytics
 * @author     Brice POTÉ <brice.pote@hotelsgrandparis.com>
 */
class Hgp_GoogleAnalytics_Block_Ga extends Mage_Core_Block_Text
{
    /**
     * Retrieve Quote Data HTML
     *
     * @return string
     */
    public function getQuoteOrdersHtml()
    {
        $quote = $this->getQuote();
        if (!$quote) {
            return '';
        }

        if ($quote instanceof Mage_Sales_Model_Quote) {
            $quoteId = $quote->getId();
        } else {
            $quoteId = $quote;
        }

        if (!$quoteId) {
            return '';
        }

        $orders = Mage::getResourceModel('sales/order_collection')
            ->addAttributeToFilter('quote_id', $quoteId)
            ->load();

        $html = '';
        foreach ($orders as $order) {
            $html .= $this->setOrder($order)->getOrderHtml();
        }

        return $html;
    }

    /**
     * Retrieve Order Data HTML
     *
     * @return string
     */
    public function getOrderHtml()
    {

        $order = $this->getOrder();
        if (!$order) {
            return '';
        }

        if (!$order instanceof Mage_Sales_Model_Order) {
            $order = Mage::getModel('sales/order')->load($order);
        }

        if (!$order) {
            return '';
        }

        $address = $order->getBillingAddress();

        $html  = '<script type="text/javascript">' . "\n";
        $html .= "//<![CDATA[\n";
        $html .= 'pageTracker._addTrans(';
        $html .= '"' . $order->getIncrementId() . '",';
        $html .= '"' . $order->getAffiliation() . '",';
        $html .= '"' . $order->getBaseGrandTotal() . '",';
        $html .= '"' . $order->getBaseTaxAmount() . '",';
        $html .= '"' . $order->getBaseShippingAmount() . '",';
        $html .= '"' . $this->jsQuoteEscape($address->getCity(), '"') . '",';
        $html .= '"' . $this->jsQuoteEscape($address->getRegion(), '"') . '",';
        $html .= '"' . $this->jsQuoteEscape($address->getCountry(), '"') . '"';
        $html .= ');' . "\n";

        foreach ($order->getAllItems() as $item) {
            if ($item->getParentItemId()) {
                continue;
            }

            $html .= 'pageTracker._addItem(';
            $html .= '"' . $order->getIncrementId() . '",';
            $html .= '"' . $this->jsQuoteEscape($item->getSku(), '"') . '",';
            $html .= '"' . $this->jsQuoteEscape($item->getName(), '"') . '",';
            $html .= '"' . $item->getCategory() . '",';
            $html .= '"' . $item->getBasePrice() . '",';
            $html .= '"' . $item->getQtyOrdered() . '"';
            $html .= ');' . "\n";
        }

        $html .= 'pageTracker._trackTrans();' . "\n";
        $html .= '//]]>';
        $html .= '</script>';

        return $html;
    }

    /**
     * Retrieve Google Account Identifier
     *
     * @return string
     */
    public function getAccount()
    {
        if (!$this->hasData('account')) {
            $this->setAccount(Mage::getStoreConfig('google/analytics/account'));
        }
        return $this->getData('account');
    }

    /**
     * Retrieve current page URL
     *
     * @return string
     */
    public function getPageName()
    {
        if (!$this->hasData('page_name')) {
            //$queryStr = '';
            //if ($this->getRequest() && $this->getRequest()->getQuery()) {
            //    $queryStr = '?' . http_build_query($this->getRequest()->getQuery());
            //}
            $this->setPageName(Mage::getSingleton('core/url')->escape($_SERVER['REQUEST_URI']));
        }
        return $this->getData('page_name');
    }
    
    /**
     * Prepare and return block's html output
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::getStoreConfigFlag('google/analytics/active')) {
            return '';
        }
		$domaine = 'hotelsgrandparis.com';
		if(isset($_SERVER['SERVER_NAME'])) $domaine = $_SERVER['SERVER_NAME'];
		
        $this->addText('
		<!-- BEGIN GOOGLE ANALYTICS CODE BP-->
		
		<script type="text/javascript">
		//<![CDATA[      
		  var _gaq = _gaq || [];
		  _gaq.push([\'_setAccount\', \'' . $this->getAccount() . '\']);
		  _gaq.push([\'_setDomainName\', \'' . $domaine .'\']);
		  _gaq.push([\'_setAllowLinker\', true]);
		  _gaq.push([\'_trackPageview\']);

		  (function() {
			var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
			ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
			var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		//]]>
		</script>

		<!-- END GOOGLE ANALYTICS CODE BP-->

        ');

        $this->addText($this->getQuoteOrdersHtml());

        if ($this->getGoogleCheckout()) {
            $protocol = Mage::app()->getStore()->isCurrentlySecure() ? 'https' : 'http';
            $this->addText('<script src="'.$protocol.'://checkout.google.com/files/digital/ga_post.js" type="text/javascript"></script>');
        }

        return parent::_toHtml();
    }
    

    /**
     * Prepare and return block's html output
     *
     * @return string
     */
    protected function _toHtmlOld()
    {
        if (!Mage::getStoreConfigFlag('google/analytics/active')) {
            return '';
        }

        $this->addText('
		<!-- BEGIN GOOGLE ANALYTICS CODE -->
		<script type="text/javascript">
		//<![CDATA[
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
		//]]>
		</script>
		<script type="text/javascript">
		//<![CDATA[
		try{		
			var pageTracker = _gat._getTracker("' . $this->getAccount() . '");
			pageTracker._setAllowLinker(true);
			pageTracker._setAllowHash(false);
			pageTracker._trackPageview("'.$this->getPageName().'");
		} catch(err) {}
		//]]>
		</script>
		<!-- END GOOGLE ANALYTICS CODE -->

        ');

        $this->addText($this->getQuoteOrdersHtml());

        if ($this->getGoogleCheckout()) {
            $protocol = Mage::app()->getStore()->isCurrentlySecure() ? 'https' : 'http';
            $this->addText('<script src="'.$protocol.'://checkout.google.com/files/digital/ga_post.js" type="text/javascript"></script>');
        }

        return parent::_toHtml();
    }
    
    /**
     * Prepare and return block's html output with Asynchrone Script
     * By Brice POTE
     *
     * @return string
     */
    protected function _toHtmlAsynchrone()
    {
        if (!Mage::getStoreConfigFlag('google/analytics/active')) {
            return '';
        }

        $this->addText('
		<!-- BEGIN GOOGLE ANALYTICS CODE -->
		<script type="text/javascript">
		//<![CDATA[

		var _gaq = _gaq || [];
			_gaq.push([\'_setAccount\',\'' . $this->getAccount() . '\']);
			_gaq.push([\'_setDomainName\',\'none\']);
			_gaq.push([\'_setAllowLinker\', true]);
			_gaq.push([\'_setAllowHash\', false]);
			_gaq.push([\'_trackPageview\',\''.$this->getPageName().'\']);
			
			(function() {
		        var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
			    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
			    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);					        
		    })();			 		   
		//]]>
		</script>
		<!-- END GOOGLE ANALYTICS CODE -->

        ');

        $this->addText($this->getQuoteOrdersHtml());

        if ($this->getGoogleCheckout()) {
            $protocol = Mage::app()->getStore()->isCurrentlySecure() ? 'https' : 'http';
            $this->addText('<script src="'.$protocol.'://checkout.google.com/files/digital/ga_post.js" type="text/javascript"></script>');
        }

        return parent::_toHtml();
    }
}

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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Renderer for URL key input
 * Allows to manage and overwrite URL Rewrites History save settings
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */

class Location_Attributes_Block_Admin_Catalog_Form_Renderer_Attribute_Merchant
    extends Mage_Adminhtml_Block_Catalog_Form_Renderer_Fieldset_Element
{
    protected $_storeCollection = null;
    public function getElementHtml()
    {

        try{
            if(is_null($this->_storeCollection)){
                $storeCollection = Mage::getModel('store/store')->getCollection();
                $storeCollection->addFieldToFilter(
                    'status',Location_City_Model_City::STATUS_ENABLE
                );
                $storeCollection->getSelect()->order('position ASC');

                $abc = "<select name='merchant_store'>";
                $abc .="<option value='-1'>-- Select --</option>";
                foreach($storeCollection as $storeInfo){
                    //Mage::log($storeInfo,null,'text.log',true);exit;
                    $abc .="<option value=".$storeInfo->getId().">".$storeInfo->getStoreName()."</option>";

                }
                $abc .= "</select>";
                $this->_storeCollection = $abc;
            }
        }catch(Exception $e){
            Mage::log($e,null,'merchant.log',true);
        }
        Mage::log($storeCollection->getSelect(),null,'text.log',true);
       return $this->_storeCollection;

    }

}

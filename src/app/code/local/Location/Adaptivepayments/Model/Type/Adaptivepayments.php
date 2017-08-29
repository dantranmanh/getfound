<?php
/**
 * Adaptive Payments Model
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Model_AdaptivePayments extends Mage_Core_Model_Abstract
{
    const ADAPTIVEPAYMENTS_TYPE_PAYPAL        = 1;

	static public $_adaptivepaymentsTypes = array();
    public function _construct()
    {
        parent::_construct();
        $this->_init('adaptivepayments/adaptivepayments');
        self::$_adaptivepaymentsTypes = self::$_adaptivepaymentsTypes + array(
            self::ADAPTIVEPAYMENTS_TYPE_PAYPAL        => 'adaptivepayments/type_paypal'
        );
    }

    public function getAdaptivePaymentsTypes() {
    	return self::$_adaptivepaymentsTypes;
    }

	public function getSelectType($data) {
		if(isset($data['redemtion_type']) and $data['redemtion_type'] != '') {
			return Mage::getModel(self::$_adaptivepaymentsTypes[$data['redemtion_type']]);
		}
    	return false;
    }

    public function validate($data) {
    	$isvalid = true;
    	if(isset($data['points']) and $data['points'] > 0) {
    		$customer = Mage::getModel('customer/customer')->load();
    		$available = Mage::helper('enterprise_reward/data')->getAdaptivePaymentsablePoints(Mage::getSingleton('customer/session')->getId());
    		if($available < (int)$data['points']) $isvalid = false;
    	}
    	return $isvalid;
    }

    public function adaptivepayments($data) {
    	try {
	    	$adaptivepaymentsType = Mage::getModel(self::$_adaptivepaymentsTypes[$data['type']]);
    		$data = $adaptivepaymentsType->process($data);
    		if($data['status']) {
    			$points = $data['points'];
    			Mage::getModel('enterprise_reward/reward')
                ->setCustomerId(Mage::getSingleton('customer/session')->getId())
                ->setWebsiteId(Mage::app()->getStore(Mage::app()->getStore()->getId())->getWebsiteId())
                ->loadTypeByCustomer('adaptivepaymentsable')
                ->setPointsDelta(-$points)
                ->setAction(Zeon_Reward_Model_Reward::REWARD_ACTION_ADAPTIVEPAYMENTS)
                ->updateRewardPoints();


	    		$tosave = array();
		    	$tosave['customer_id'] = Mage::getSingleton('customer/session')->getId();
		    	$tosave['points'] = $data['points'];
		    	$tosave['amount'] = (Mage::helper('adaptivepayments/data')->getAdaptivePaymentsRate() * $data['points']) / 100;
		    	$tosave['currency'] = Mage::app()->getStore()->getCurrentCurrencyCode();
		    	$tosave['type'] = $data['type'];
		    	$tosave['details'] = serialize($data['details']);
		    	$tosave['status'] = $data['adaptivepayments_status'];

		    	$this->setData($tosave);
		    	$this->setCreatedTime(now())
					 ->setUpdateTime(now());
		    	$this->save();
		    	return true;
    		} else {
    			if($data['message'] != '') {
    				Mage::getSingleton('core/session')->addError($data['message']);
    			} else {
    				Mage::getSingleton('core/session')->addError('Cannot process your request. Try again later');
    			}
    			return false;
    		}
    	}
    	catch (Exception $e) {
    		Mage::getSingleton('core/session')->addError($e->getMessage());
    		return false;
    	}
    }

}
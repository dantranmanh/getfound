<?php
/**
 * Adaptive Payments Block
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Block_Adaptivepayments extends Mage_Core_Block_Template
{
	protected function _prepareLayout()
    {
    	$adaptivepayments = Mage::getModel('adaptivepayments/adaptivepayments');
    	$type = $adaptivepayments->getSelectType($this->getRequest()->getPost());
    	if($type) {
    		$this->setChild('adaptivepayments_type', $this->getLayout()->createBlock($type->getBlockName(), 'adaptivepayments.type'));
    	}
		return parent::_prepareLayout();
    }

     public function getAdaptivePayments()
     {
        if (!$this->hasData('adaptivepayments')) {
            $this->setData('adaptivepayments', Mage::registry('adaptivepayments'));
        }
        return $this->getData('adaptivepayments');

    }

	public function getAdaptivePaymentsTypes()
    {
    	$typesArray = array();
    	$adaptivepayments = Mage::getModel('adaptivepayments/adaptivepayments');
    	$types = $adaptivepayments->getAdaptivePaymentsTypes();
    	foreach($types as $type_id => $type) {
    		$adaptivepaymentsType = Mage::getModel($type);
    		$typesArray[] = array('type_id' => $type_id, 'label' => $adaptivepaymentsType->getLabel());
    	}
    	return $typesArray;
    }

    public function getSelectType() {
    	$adaptivepayments = Mage::getModel('adaptivepayments/adaptivepayments');
    	$type = $adaptivepayments->getSelectType($this->getRequest()->getPost());
    	if($type) {
    		return $type;
    	}
    }

	public function getRedeenablePointsBalence()
	{
		return Mage::helper('enterprise_reward/data')->getAdaptivePaymentsablePoints(Mage::getSingleton('customer/session')->getId());
	}

	public function getSelectFormDetails() {
		$details = array();
		$details['points'] = $this->getRequest()->getPost('points');
		$details['amount'] = (Mage::helper('adaptivepayments/data')->getAdaptivePaymentsRate() * $details['points']) / 100;
		$details['refund_msg'] = Mage::getModel(Location_AdaptivePayments_Model_AdaptivePayments::$_adaptivepaymentsTypes[$this->getRequest()->getPost('redemtion_type')])->getAdaptivePaymentsMessage();;
		return $details;
    }

	public function getRedemtionType() {
		return $this->getRequest()->getPost('redemtion_type');
    }

}
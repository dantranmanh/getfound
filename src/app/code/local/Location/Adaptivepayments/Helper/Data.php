<?php
/**
 * Adaptive Payments Helper
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getCurrencySymbol() {
		return Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
	}

	public function getAdaptivePaymentsRate() {
    	$reward = Mage::getModel('enterprise_reward/reward');
		return $reward->getRateToCurrency()->calculateToCurrency(100);
    }
}
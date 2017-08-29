<?php
/**
 * Adaptive Payments Block
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Block_Type_Paypal extends Mage_Core_Block_Template
{
	public function __construct()
    {
        $this->setTemplate('adaptivepayments/type/paypal.phtml');
    }

}
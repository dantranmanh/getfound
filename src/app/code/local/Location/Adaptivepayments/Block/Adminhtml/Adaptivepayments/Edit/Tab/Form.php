<?php
/**
 * Adaptive Payments Block
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */
class Location_Adaptivepayments_Block_Adminhtml_Adaptivepayments_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('adaptivepayments_form', array('legend'=>Mage::helper('adaptivepayments')->__('Payments Information')));
     //echo '<pre>'; print_r(get_class_methods($fieldset)); exit;

      $data = Mage::registry('adaptivepayments_data')->getData();

      $fieldset->addField('points', 'note', array(
          'label'     => Mage::helper('adaptivepayments')->__('Points'),
      	  'text'      => $data['points'],
      ));

      $fieldset->addField('amount', 'note', array(
          'label'     => Mage::helper('adaptivepayments')->__('Amount'),
      	  'text'      => $data['amount'],
      ));

      $type = array(
            Location_AdaptivePayments_Model_AdaptivePayments::ADAPTIVEPAYMENTS_TYPE_PAYPAL        => 'PAYPAL'
        );
      $fieldset->addField('type', 'note', array(
          'label'     => Mage::helper('adaptivepayments')->__('Type'),
      	  'text'      => $type[$data['type']],
      ));

      $fieldset->addField('currency', 'note', array(
          'label'     => Mage::helper('adaptivepayments')->__('Currency'),
      	  'text'      => $data['currency'],
      ));

      $detailArray = array('cc_type' => 'Credit Card Type',
      						'first_name' => 'First Name',
      						'last_name' => 'Last Name',
      						'cc_number' => 'Credit Card Number',
      						'cc_exp_month' => 'Expiration Month',
      						'cc_exp_year' => 'Expiration Year',
      						);



      $details = unserialize($data['details']);
      $detail = '<ul>';
      foreach($details as $key => $val) {
      	$detail .= '<li><label>';
      	if(array_key_exists($key, $detailArray))
      		$detail .= $detailArray[$key];
      	else
      		$detail .= ucwords($key);
      	$detail .= ' : </label>' . $val . '<li>';
      }
      $detail .= '</ul>';
      $fieldset->addField('details', 'note', array(
          'label'     => Mage::helper('adaptivepayments')->__('Details'),
      	  'text'      => $detail,
      ));

      $fieldset->addField('created_time', 'note', array(
          'label'     => Mage::helper('adaptivepayments')->__('Time'),
      	  'text'      => $data['created_time'],
      ));
     // created_time


      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('adaptivepayments')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 'PENDING',
                  'label'     => Mage::helper('adaptivepayments')->__('PENDING'),
              ),

              array(
                  'value'     => 'PROCESSING',
                  'label'     => Mage::helper('adaptivepayments')->__('PROCESSING'),
              ),
              array(
                  'value'     => 'COMPLETED',
                  'label'     => Mage::helper('adaptivepayments')->__('COMPLETED'),
              ),
          ),
      ));

      if ( Mage::getSingleton('adminhtml/session')->getAdaptivePaymentsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAdaptivePaymentsData());
          Mage::getSingleton('adminhtml/session')->setAdaptivePaymentsData(null);
      } elseif ( Mage::registry('adaptivepayments_data') ) {
          $form->setValues(Mage::registry('adaptivepayments_data')->getData());
      }
      return parent::_prepareForm();
  }
}
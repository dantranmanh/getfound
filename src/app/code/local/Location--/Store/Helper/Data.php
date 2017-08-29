<?php
class Location_Store_Helper_Data extends Mage_Core_Helper_Abstract{

    public function toOptionArray(){
        $optionArray = Array(
            0 => array(
                'label'=>'Publish',
                'value'=>'1'
            ),
            1 => array(
                'label'=>'Unpublish',
                'value'=>'2'
            )
        );
        return $optionArray;
    }

    public function toOption(){
        $optionArray = Array(
            '1' => 'Enable',
            '2' => 'Disable'
        );
        return $optionArray;
    }

    public function toOptionSchedule(){
        $optionSchedule = Array(
            0 => array(
                'label'=>'12:00 AM',
                'value'=>'12:00 AM'
            ),
            1 => array(
                'label'=>'12:30 AM',
                'value'=>'12:30 AM'
            ),
            2 => array(
            'label'=>'01:00 AM',
            'value'=>'01:00 AM'
        ),
            3 => array(
            'label'=>'01:30 AM',
            'value'=>'01:30 AM'
        ),
            4 => array(
            'label'=>'02:00 AM',
            'value'=>'02:00 AM'
        ),
            5 => array(
            'label'=>'02:30 AM',
            'value'=>'02:30 AM'
        ),
            6 => array(
                'label'=>'03:00 AM',
                'value'=>'03:00 AM'
            ),
            7 => array(
                'label'=>'03:30 AM',
                'value'=>'03:30 AM'
            ),
            8 => array(
                'label'=>'04:00 AM',
                'value'=>'04:00 AM'
            ),
            9 => array(
                'label'=>'04:30 AM',
                'value'=>'04:30 AM'
            ),
            10 => array(
                'label'=>'05:00 AM',
                'value'=>'05:00 AM'
            ),
            11 => array(
                'label'=>'05:30 AM',
                'value'=>'05:30 AM'
            ),
            12 => array(
                'label'=>'06:00 AM',
                'value'=>'06:00 AM'
            ),
            13 => array(
                'label'=>'06:30 AM',
                'value'=>'06:30 AM'
            ),
            14 => array(
                'label'=>'07:00 AM',
                'value'=>'07:00 AM'
            ),
            15 => array(
                'label'=>'07:30 AM',
                'value'=>'07:30 AM'
            ),
            16 => array(
                'label'=>'08:00 AM',
                'value'=>'08:00 AM'
            ),
            17 => array(
                'label'=>'08:30 AM',
                'value'=>'08:30 AM'
            ),
            18 => array(
                'label'=>'09:00 AM',
                'value'=>'09:00 AM'
            ),
            19 => array(
                'label'=>'09:30 AM',
                'value'=>'09:30 AM'
            ),
            20 => array(
                'label'=>'10:00 AM',
                'value'=>'10:00 AM'
            ),
            21 => array(
                'label'=>'10:30 AM',
                'value'=>'10:30 AM'
            ),
            22 => array(
                'label'=>'11:00 AM',
                'value'=>'11:00 AM'
            ),
            23 => array(
                'label'=>'11:30 AM',
                'value'=>'11:30 AM'
            ),
            24 => array(
                'label'=>'12:00 PM',
                'value'=>'12:00 PM'
            ),
            25 => array(
                'label'=>'12:30 PM',
                'value'=>'12:30 PM'
            ),
            26 => array(
                'label'=>'01:00 PM',
                'value'=>'01:00 PM'
            ),
            27 => array(
                'label'=>'01:30 PM',
                'value'=>'01:30 PM'
            ),
            28 => array(
                'label'=>'02:00 PM',
                'value'=>'02:00 PM'
            ),
            29 => array(
                'label'=>'02:30 PM',
                'value'=>'02:30 PM'
            ),
            30 => array(
                'label'=>'03:00 PM',
                'value'=>'03:00 PM'
            ),
            31 => array(
                'label'=>'03:30 PM',
                'value'=>'03:30 PM'
            ),
            32 => array(
                'label'=>'04:00 PM',
                'value'=>'04:40 PM'
            ),
            33 => array(
                'label'=>'04:30 PM',
                'value'=>'04:30 PM'
            ),
            34 => array(
                'label'=>'05:00 PM',
                'value'=>'05:00 PM'
            ),
            35 => array(
                'label'=>'05:30 PM',
                'value'=>'05:30 PM'
            ),
            36 => array(
                'label'=>'06:00 PM',
                'value'=>'06:00 PM'
            ),
            37 => array(
                'label'=>'06:30 PM',
                'value'=>'06:30 PM'
            ),
            38 => array(
                'label'=>'07:00 PM',
                'value'=>'07:00 PM'
            ),
            39 => array(
                'label'=>'07:30 PM',
                'value'=>'07:30 PM'
            ),
            40 => array(
                'label'=>'08:00 PM',
                'value'=>'08:00 PM'
            ),
            41 => array(
                'label'=>'08:30 PM',
                'value'=>'08:30 PM'
            ),
            42 => array(
                'label'=>'09:00 PM',
                'value'=>'09:00 PM'
            ),
            43 => array(
                'label'=>'09:30 PM',
                'value'=>'09:30 PM'
            ),
            44 => array(
                'label'=>'10:00 PM',
                'value'=>'10:00 PM'
            ),
            45 => array(
                'label'=>'10:30 PM',
                'value'=>'10:30 PM'
            ),
            46 => array(
                'label'=>'11:00 PM',
                'value'=>'11:00 PM'
            ),
            47 => array(
                'label'=>'11:30 PM',
                'value'=>'11:30 PM'
            ),
            48 => array(
                'label'=>'Closed',
                'value'=>'Closed'
            ),


        );
        return $optionSchedule;
    }
}

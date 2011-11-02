<?php

/**
 * Tasks
 *
 * @copyright (c) 2009, Fabian Wuertz
 * @author Fabian Wuertz
 * @link http://fabian.wuertz.org
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Tasks
 */


class AddressBook_Handler_ImportCSV extends Zikula_Form_AbstractHandler
{

    

    function initialize(Zikula_Form_View $view)
    {
        if ((!UserUtil::isLoggedIn()) || (!SecurityUtil::checkPermission('Tasks::', '::', ACCESS_EDIT))) {
            return LogUtil::registerPermissionError();
        }
      
        
        return true;
    }

    

    function handleCommand(Zikula_Form_View $view, &$args)
    {

        if ($args['commandName'] == 'cancel') {
            $url = ModUtil::url('Tasks', 'user', 'main');
            return $view->redirect($url);
        }
        if ($args['commandName'] == 'test') {
            $is_a_test = true;
        } else {
            $is_a_test = false;
        }
        
        
        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        
        $cols = array(
             0 => 'firstname',
             1 => 'lastname',
             2 => 'nickname',
             3 => 'role',
             4 => 'organisation',
             5 => 'emails',
             6 => 'phones',
             7 => 'bday',
             8 => 'note',
        );
        $this->view->assign('cols', $cols );

        

        // load form values
        $data = $view->getValues();
        
        
        //$input = str_replace('"', '\\"', $data['input']);
        $input = explode("\n", $data['input']);
        
                
        // test it!
        foreach ($input as $key => $line) {
            $key = $key+1;
            if($line == '') {
                continue;
            }
            $entry0 = str_getcsv($line , $delimiter = ',', $enclosure = '"', $escape = '\\');
            if( count($entry0) != count($cols) ) {
                return LogUtil::registerError('Line: '.$key.', Check: Amount of entries');
            }
            $entry  = array();
            foreach($entry0 as $key => $value) {
                if(empty($value)) {
                    continue;
                }
                $col = $cols[$key];
                if($col == 'deadline' or $col == 'cr_date' or $col == 'done_date') {
                    $date_array = explode('.', $value);
                    if(count($date_array) != 3 ) {
                        return LogUtil::registerError('Line: '.$key.', Col: '.$col.', Check: dateformat');
                    }
                    if( !checkdate($date_array[1], $date_array[2], $date_array[0]) ) {
                        return LogUtil::registerError('Line: '.$key.', Col: '.$col.', Check: checkdate');
                    }
                }
                $data[$col] = $value;
            }
            $test[] = $data;
        }  
        $this->view->assign('test', $test );
        
        
        
        if(!$is_a_test) {
            foreach ($input as $line) {
                $data =array();
                if($line == '') {
                    continue;
                }
                $entry0 = str_getcsv($line , $delimiter = ',', $enclosure = '"', $escape = '\\');
                $entry  = array();
                foreach($entry0 as $key => $value) {
                    $col = $cols[$key];
                    if($col == 'bday') {
                        if(!empty($value)) {
                            $date_array = explode('.', $value);
                            $value = $date_array[2].'-'.$date_array[1].'-'.$date_array[0];
                            
                        } else {
                            $value = null;
                        }
                    } else if($col == 'phones') {
                        if(!empty($value)) {
                            $value = array(
                                '0'=> array(
                                    'n' => $value,
                                    't' => 'Home'
                                )
                            );
                        } else {
                            $value = null;
                        }
                    } else if($col == 'emails') {
                        if(!empty($value)) {
                            $value = array(
                                '0'=> $value
                            );
                        } else {
                            $value = null;
                        }
                    }
                     else if($col == 'firstname') {
                        $name_array = explode(' ', $value);
                        if(count($name_array) > 1) { 
                            $value = $name_array[0];
                            $data['additionalname'] = $name_array[1];
                        }
                    }
                    $data[$col] = $value;
                }

               $address = new AddressBook_Model_Addresses();
               $address->merge($data);
               $address->save();
               

            }
            LogUtil::registerStatus($this->__('Import successful'));
        }

        return true;
    }

}

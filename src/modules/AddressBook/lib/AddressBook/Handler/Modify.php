<?php
/**
 * AddressBook
 *
 * @copyright (c) 2009, AddressBook Development Team
 * @link http://code.zikula.org/addressbook
 * @version $Id: pnadminform.php 61 2010-03-31 13:44:02Z herr.vorragend $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package AddressBook
 * @subpackage UI
 */

class AddressBook_Handler_Modify extends Zikula_Form_AbstractHandler
{
        /**
     * User id.
     *
     * When set this handler is in edit mode.
     *
     * @var integer
     */
    private $_pid;
    
    function initialize(Zikula_Form_View $view)
    {
        if (!SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_EDIT) ) {
            throw new Zikula_Exception_Forbidden(LogUtil::getErrorMsgPermission());
        }

        $pid = FormUtil::getPassedValue('pid', isset($args['pid']) ? $args['pid'] : null, 'REQUEST');
        
        
        if(!empty($pid)) {
            if (!SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_EDIT)) {
                return LogUtil::registerPermissionError();
            }
            $address = ModUtil::apiFunc('AddressBook','user','getAddress', $pid );
            if ($address) {
                $this->_pid = $pid;
                $address['categories'] = implode(',', $address['categories']);
                if(empty($address['emails'])) {
                    $address['emails'][] = '';
                }
                $this->view->assign($address);
            } else {
                return LogUtil::registerError($this->__f('Address with pid %s not found', $pid));
            }
        } else {
            if (!SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_ADD)) {
                return LogUtil::registerPermissionError();
            }
        }
        
        $phone_types = array(
            0 => array(
                'text' => 'Home',
                'value' => 'Home'
            ),
            1 => array(
                'text' => 'Work',
                'value' => 'Work'
            )
        );
        $this->view->assign('phone_types', $phone_types);

        return true;
    }
    
    
    function handleCommand(Zikula_Form_View $view, &$args)
    {
        
        
        // permission check
        if (!(SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_EDIT))) {
            return LogUtil::registerPermissionError();
        }
        
        $url = ModUtil::url('AddressBook', 'user', 'main');


        if ($args['commandName'] == 'cancel') {
            return $view->redirect($url);
        }
        
        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        $data = $view->getValues();
        
        
        // prepare categories array
        $data['categories'] = explode(',', $data['categories']);
        
       
        // prepare phone array
        foreach($data['phones_numbers'] as $key => $value) {
            if(!empty($value)){
                $key = substr($key, 3); // remove pn_
                $data['phones'][$key] = array(
                    'n' => $data['phones_numbers']['pn_'.$key],
                    't' => $data['phones_types']['pt_'.$key]
                );
            }
        }
        unset($data['phones_numbers']);
        unset($data['phones_types']);
        // merge new phones array
        for ($i = 1; $i <= 3; $i++) {
            if(!empty($data['phone_new'.$i.'_number'])) {
                $item = array(
                    't' => $data['phone_new'.$i.'_type'],
                    'n' => $data['phone_new'.$i.'_number']
                );
                // Zikula forms have problems with the 0 key!
                if(count($data['phones']) == 0 ) {
                    $data['phones'][1] = $item;
                } else {
                    $data['phones'][] = $item;
                }
            }
        }
        
        
        // prepare emails array
        foreach($data['emails'] as $key => $value) {
            if(!empty($value)){
                $key = substr($key, 6); // remove email_
                $emails[$key] = $value;
            }
        }
        $data['emails'] = $emails;
        // merge new emails array
        for ($i = 1; $i <= 3; $i++) {
            if(!empty($data['email_new'.$i])) {
                // Zikula forms have problems with the 0 key!
                if(count($data['emails']) == 0 ) {
                    $data['emails'][1] = $data['email_new'.$i];
                } else {
                    $data['emails'][] = $data['email_new'.$i];
                }
            }
        }
        
        
        
        // switch between edit and create mode
        if ($this->_pid) {
            $address = Doctrine_Core::getTable('AddressBook_Model_Addresses')->find($this->_pid);
        } else {
            //$data['cr_uid'] = UserUtil::getVar('uid');
            //$data['cr_date'] = date('Y-m-d H:i:s');
            $address = new AddressBook_Model_Addresses();
        }
        $address->merge($data);
        $address->save();
        
        
        //print_r($data);
         //return true;

        
        $url = ModUtil::url('AddressBook', 'user', 'modify', array('pid' => $this->_pid));
        return $view->redirect($url);
    }
}
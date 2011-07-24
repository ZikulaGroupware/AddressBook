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
                $this->view->assign($address);
            } else {
                return LogUtil::registerError($this->__f('Address with pid %s not found', $pid));
            }
        } else {
            if (!SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_ADD)) {
                return LogUtil::registerPermissionError();
            }
        }


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
        
        return $view->redirect($url);
    }
}
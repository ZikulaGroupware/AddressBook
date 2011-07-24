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

class AddressBook_Handler_ModifyConfig  extends Zikula_Form_AbstractHandler
{
    
    function initialize(Zikula_Form_View $view)
    {
        if (!SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden(LogUtil::getErrorMsgPermission());
        }
        
        
        $this->view->caching = false;
        $this->view->assign(ModUtil::getVar('AddressBook'));

        return true;
    }
    
    
    function handleCommand(Zikula_Form_View $view, &$args)
    {
        if ($args['commandName'] == 'cancel') {
            $url = ModUtil::url('AddressBook', 'admin', 'modifyconfig' );
            return $view->redirect($url);
        }

        // permission check
        if (!(SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_ADMIN))) {
            return LogUtil::registerPermissionError();
        }

        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        
        $data = $view->getValues();

        // now for each perference entry, set the appropriate module variable
        $this->setVar('abtitle',         $data['abtitle']);
        $this->setVar('special_chars_1', $data['special_chars_1']);
        $this->setVar('special_chars_2', $data['special_chars_2']);
        $this->setVar('globalprotect',   $data['globalprotect']);
        $this->setVar('use_prefix',      $data['use_prefix']);
        $this->setVar('use_img',         $data['use_img']);
        $this->setVar('google_api_key',  $data['google_api_key']);
        $this->setVar('google_zoom',     $data['google_zoom']);
        $this->setVar('itemsperpage',    $data['itemsperpage']);
        $this->setVar('custom_tab',      $data['custom_tab']);

        if (mb_strlen($data['special_chars_1']) != mb_strlen($data['special_chars_2'])) {
            LogUtil::registerError(__('Error! Both fields must contain the same number of characters - Special character replacement was NOT saved!'));
        }

        // redirect back to to main admin page
        LogUtil::registerStatus (__('Done! Configuration saved.'));
        return System::redirect(ModUtil::url('AddressBook', 'admin', 'main'));
    }
}

<?php
/**
 * AddressBook
 *
 * @copyright (c) 2009, AddressBook Development Team
 * @link http://code.zikula.org/addressbook
 * @version $Id: pnuserform.php 70 2010-04-01 14:46:28Z herr.vorragend $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package AddressBook
 * @subpackage UI
 */

class AddressBook_Handler_ImportVCard extends Zikula_Form_AbstractHandler
{
    function initialize(Zikula_Form_View $view)
    {
        $this->view->caching = false;
        return true;
    }

 function handleCommand(Zikula_Form_View $view, &$args)
    {
        if ($args['commandName'] == 'cancel') {
            $url = ModUtil::url('AddressBook');
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

        // redirect back to to main admin page
        LogUtil::registerStatus (__('Done! Configuration saved.'));
        return true;//System::redirect(ModUtil::url('AddressBook'));
    }    
    
}
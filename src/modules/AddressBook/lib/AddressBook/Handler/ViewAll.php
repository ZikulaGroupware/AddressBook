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

class AddressBook_Handler_ViewAll  extends Zikula_Form_AbstractHandler
{
    function initialize(Zikula_Form_View $view)
    {
        if (!SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden(LogUtil::getErrorMsgPermission());
        }
        
        $this->view->caching = false;


        $letter = FormUtil::getPassedValue('letter');
        $name = FormUtil::getPassedValue('name');
        $organisation = FormUtil::getPassedValue('organisation');
        if(is_array($organisation)){
            $organisation = $organisation[0];
        }
        $category = FormUtil::getPassedValue('category');
        if(is_array($category)){
            $category = $category[0];
        }
        
        $addresses = ModUtil::apiFunc('AddressBook','user','getAddresses', array(
            'letter' => $letter,
            'name' => $name, 
            'organisation' => $organisation,
            'category' => $category
        ) );
        
        $this->view->assign('name', $name);
        $this->view->assign('category', $category);
        $this->view->assign('organisation', $organisation);
        $this->view->assign('letter', $letter);
        $this->view->assign('addresses', $addresses);
        
        $organisations = ModUtil::apiFunc($this->name,'user','getOrganisations');
        $this->view->assign('organisations', $organisations);
        
        $categories = ModUtil::apiFunc($this->name,'user','getCategories');
        $this->view->assign('categories', $categories);
        
        return true;
    }

 function handleCommand(Zikula_Form_View $view, &$args)
    {

        // permission check
        if (!(SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_READ))) {
            return LogUtil::registerPermissionError();
        }

        // check for valid form
        if (!$view->isValid()) {
            return false;
        }
        

        
        $data = $view->getValues();
        extract($data);
        
        $letter = FormUtil::getPassedValue('letter');        
        $addresses = ModUtil::apiFunc('AddressBook','user','getAddresses', array(
            'letter' => $letter,
            'name' => $name,
            'organisation' => $organisation,
            'category' => $category
        ) );
        $this->view->assign('addresses', $addresses);      

        return true;
    }    
    
}
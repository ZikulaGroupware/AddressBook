<?php
/**
 * AddressBook
 *
 * @copyright (c) 2009, AddressBook Development Team
 * @link http://code.zikula.org/addressbook
 * @version $Id: pnuser.php 69 2010-04-01 13:30:14Z herr.vorragend $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package AddressBook
 * @subpackage UI
 */

class AddressBook_Controller_User extends Zikula_AbstractController {

    public function main()
    {
        return $this->viewAll();
    }
  
    
    public function view()
    {
        $pid = FormUtil::getPassedValue('pid', isset($args['pid']) ? $args['pid'] : null, 'REQUEST');
        $address = ModUtil::apiFunc('AddressBook','user','getAddress', $pid );
        $this->view->assign($address);
        return $this->view->fetch('user/view.tpl');
    }
    
    public function viewAll()
    {
        
        $form = FormUtil::newForm($this->name, $this);
        return $form->execute('user/viewAll.tpl', new AddressBook_Handler_ViewAll());
    }
    
    public function modify()
    {
        $form = FormUtil::newForm($this->name, $this);
        return $form->execute('user/modify.tpl', new AddressBook_Handler_Modify());
    }
    
    public function importVCard()
    {
        // Permission check
        $this->throwForbiddenUnless(
            SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_ADMIN)
        );

        if(
            array_key_exists('file', $_FILES) and 
            array_key_exists('name', $_FILES['file']) and
            !empty($_FILES['file']['name'])
        ) {
            $data = array();
            $file = fopen($_FILES['file']['tmp_name'], "r") or exit("Unable to open file!");
            while(!feof($file)) {
                $line = fgets($file);
                if(empty($line)) {
                    continue;
                }
                    
                $tmpArray = explode(':', $line);
                $key = strtolower($tmpArray[0]);
                unset($tmpArray[0]);
                $line = implode($tmpArray, '');
                
                if($key == 'begin') {
                    $data = array();
                } else if($key == 'end') {
                    $e = new AddressBook_Model_Addresses();
                    $e->merge($data);
                    $e->save();
                } else if ($key == 'n') {
                    $tmpArray = explode(';', $line);
                    $data['firstname'] = $tmpArray[1];
                    $data['lastname']  = $tmpArray[0];   
                } else {
                    if($key == 'org') {
                        $key = 'organisation';
                    } else if ($key == 'bday') {
                        $line = substr($line, 0, 10);
                    } else if ( substr($key, 0, 3) == 'tel'){
                        $key = 'phone_'.strtolower(substr($key, 9));
                    }
                    $data[$key] = $line;
                }
                

            }
            fclose($file);
        }
        
        return $this->view->fetch('user/importVCard.tpl');
       
    }
   
}

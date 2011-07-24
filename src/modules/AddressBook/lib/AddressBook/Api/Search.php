<?php

/**
 * Copyright Addressbook Team 2011
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Piwik
 * @link http://code.zikula.org/piwik
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */


class AddressBook_Api_Search extends Zikula_AbstractApi
{

    /**
     * Search plugin info
     **/
    public function info()
    {
        return array(
            'title' => 'AddressBook',
            'functions' => array('AddressBook' => 'search')
        );
    }

    /**
     * Search form component
     **/
    public function options($args)
    {
        if (SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_READ)) {
            $renderer = Zikula_View::getInstance('AddressBook');
            $active = (isset($args['active'])&&isset($args['active']['AddressBook']))||(!isset($args['active']));
            $renderer->assign('active',$active);
            return $renderer->fetch('search/options.tpl');
        }

        return '';
    }

    /**
     * Search plugin main function
     **/
    public function search($args)
    {
        // Permission check
        $this->throwForbiddenUnless(
            SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_READ),
            LogUtil::getErrorMsgPermission()
        );

        
        $addresses = ModUtil::apiFunc('AddressBook','user','getAddresses', array(
            'name' => $args['q'],
        ) );
        
        $sessionId = session_id();
        
        foreach ($addresses as $address)
        {
            $email = $address['email'];
            if(!empty($email) ) {
                $email = $this->__('E-mail').': '.$email.', ';
            }
            $phone = $address['phone_home'];
            if(!empty($phone) ) {
                $phone = $this->__('Phone').': '.$phone.', ...';
            }

            
            $item = array(
                'title'   => $address['firstname'].' '.$address['lastname'],
                'text'    => $email.$phone,
                'extra'   => $address['pid'],
                'created' => null,
                'module'  => $this->name,
                'session' => $sessionId
            );
            $insertResult = DBUtil::insertObject($item, 'search_result');
            if (!$insertResult) {
                return LogUtil::registerError($this->__('Error! Could not load any articles.'));
            }
        }

        
      return true;
    }


    /**
     * Do last minute access checking and assign URL to items
     *
     * Access checking is ignored since access check has
     * already been done. But we do add a URL to the found user
     */
    public function search_check($args)
    {
        $datarow = &$args['datarow'];
        $pid = $datarow['extra'];
        $datarow['url'] = ModUtil::url($this->name, 'user', 'view', array('pid' => $pid));

        return true;
    }

}


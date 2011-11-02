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

class AddressBook_Api_Admin extends Zikula_AbstractApi
{


    public function getlinks()
    {
        $links = array();

        if (SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_ADMIN)) {

            $links[] = array(
                'url' => ModUtil::url('AddressBook', 'admin', 'modifyconfig'),
                'text' => __('Settings'),
                'class' => 'z-icon-es-config'
            );
            $links[] = array(
                'url' => ModUtil::url($this->name, 'admin', 'importCSV'),
                'text' => __('Import CSV'),
                'class' => 'z-icon-es-import'
            );
        }

        return $links;
    }
}
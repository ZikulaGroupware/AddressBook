<?php

/**
 * Copyright AddressBook Team 2011
 *
 * This work is licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Piwik
 * @link https://github.com/phaidon/AddressBook
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

class AddressBook_Version extends Zikula_AbstractVersion
{
    
    /**
     * meta data
     *
     * this function return the meta data of the module
     * 
     * @return array
     */
    public function getMetaData()
    {
        $meta = array();
        $meta['name']             = 'AddressBook';
        $meta['oldnames']         = array('Addressbook');
        $meta['displayname']      = __('Address book');
        $meta['url']              = __('addressbook');
        $meta['version']          = '2.0.0';
        $meta['description']      = __('A module to store contacts (names, emails addresses, phone numbers, ...) ');
        $meta['credits']          = 'docs/credits.txt';
        $meta['help']             = 'docs/help.txt';
        $meta['changelog']        = 'docs/changelog.txt';
        $meta['license']          = 'docs/license.txt';
        $meta['official']         = 0;
        $meta['author']           = 'AddressBook Development Team';
        $meta['contact']          = 'https://github.com/phaidon/AddressBook';
        $meta['admin']            = 1;
        $meta['securityschema']   = array('AddressBook::' => '::');
        return $meta;
    }
}
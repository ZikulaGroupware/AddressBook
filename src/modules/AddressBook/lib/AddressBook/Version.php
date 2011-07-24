<?php
/**
 * AddressBook
 *
 * @copyright (c) 2009, AddressBook Development Team
 * @link http://code.zikula.org/addressbook
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package AddressBook
 */


class AddressBook_Version extends Zikula_AbstractVersion
{
    public function getMetaData()
    {
        
        $meta = array();
        $meta['name']             = 'AddressBook';
        $meta['oldnames']         = array('Addressbook');
        $meta['displayname']      = __('Address book');
        $meta['url']              = __('addressbook');
        $meta['version']          = '1.3.1';
        $meta['description']      = __('A name and address book (NAB) is for storing entries called contacts. Each contact entry usually consists of a few standard fields.');
        $meta['credits']          = 'docs/credits.txt';
        $meta['help']             = 'docs/help.txt';
        $meta['changelog']        = 'docs/changelog.txt';
        $meta['license']          = 'docs/license.txt';
        $meta['official']         = 0;
        $meta['author']           = 'AddressBook Development Team';
        $meta['contact']          = 'http://code.zikula.org/addressbook/';
        $meta['admin']            = 1;
        $meta['securityschema']   = array('AddressBook::' => '::');
        return $meta;
    }
}
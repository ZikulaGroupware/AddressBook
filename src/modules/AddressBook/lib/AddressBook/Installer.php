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

class AddressBook_Installer extends Zikula_AbstractInstaller
{

    /**
     * initialise the template module
     *
     * This function is only ever called once during the lifetime of a particular
     * module instance
     * 
     * @return boolean
     */
    public function install()
    {
        try {
            DoctrineUtil::createTablesFromModels('AddressBook');
        } catch (Exception $e) {
            return false;
        }
       
        
        $this->setVar('abtitle', 'Zikula Address Book');
        $this->setVar('itemsperpage', 30);
        $this->setVar('globalprotect', 0);
        $this->setVar('custom_tab', '');
        $this->setVar('use_prefix', 0);
        $this->setVar('use_img', 0);
        $this->setVar('google_api_key', '');
        $this->setVar('google_zoom', 15);
        $this->setVar('special_chars_1', 'ÄÖÜäöüß');
        $this->setVar('special_chars_2', 'AOUaous');
        $this->setVar('enablecategorization', true);

        // Initialisation successful
        return true;
    }

    function upgrade($oldversion)
    {

       /* $prefix = pnConfigGetVar('prefix');

        switch($oldversion) {
            case 1.0:
                $sql = "ALTER TABLE ".$prefix."_addressbook_address ADD adr_geodata VARCHAR( 180 ) NULL AFTER adr_country";
                if (!DBUtil::executeSQL($sql,-1,-1,false,true))
                return false;
                // Upgrade successfull
                $this->setVar('Addressbook', 'google_api_key', '');
                $this->setVar('Addressbook', 'google_zoom', 15);
                return AddressBook_upgrade(1.1);
            case 1.1:
                $this->migratecategories();
                $this->migratecategories();
                $this->delVar('Addressbook', 'name_order');
                $this->delVar('zipbeforecity');
                return AddressBook_upgrade(1.2);
            case 1.2:
                $this->delVar('textareawidth');
                $this->delVar('dateformat');
                $this->delVar('numformat');
                $this->upgradeto_1_3();
                return true;
            case 1.3:
                return true;
        }*/
    }
/*
    function migratecategories()
    {
        $dbprefix = pnConfigGetVar('prefix');

        // pull old category values
        $sql = "SELECT cat_id, cat_name FROM {$dbprefix}_addressbook_categories";
        $result = DBUtil::executeSQL($sql);
        $categories = array();
        for (; !$result->EOF; $result->MoveNext()) {
            $categories[] = $result->fields;
        }

        // load necessary classes
        Loader::loadClass('CategoryUtil');
        Loader::loadClassFromModule('Categories', 'Category');
        Loader::loadClassFromModule('Categories', 'CategoryRegistry');

        // get the language file
        $lang = ZLanguage::getLanguageCode();

        // get the category path for which we're going to insert our place holder category
        $rootcat = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules');
        $adrCat    = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/AddressBook');

        if (!$adrCat) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $rootcat['id']);
            $cat->setDataField('name', 'AddressBook');
            $cat->setDataField('display_name', array($lang => __('AddressBook')));
            $cat->setDataField('display_desc', array($lang => __('Adress administration.')));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
        }

        // get the category path for which we're going to insert our upgraded News categories
        $adrCat = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/AddressBook');

        // migrate our main categories
        foreach ($categories as $category) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $adrCat['id']);
            $cat->setDataField('name', $category[1]);
            $cat->setDataField('is_leaf', 1);
            $cat->setDataField('display_name', array($lang => $category[1]));
            $cat->setDataField('display_desc', array($lang => $category[1]));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
            $catid = $cat->getDataField('id');

            $sql = "UPDATE {$dbprefix}_addressbook_address SET adr_catid = $catid WHERE adr_catid = $category[0]";
            if (!DBUtil::executeSQL($sql)) {
                return LogUtil::registerError(__('Error! Update attempt failed.'));
            }
        }

        if ($adrCat) {
            // place category registry entry
            $registry = new PNCategoryRegistry();
            $registry->setDataField('modname', 'AddressBook');
            $registry->setDataField('table', 'addressbook_address');
            $registry->setDataField('property', 'AddressBook');
            $registry->setDataField('category_id', $adrCat['id']);
            $registry->insert();
        }

        // now drop the category table
        $sql = "DROP TABLE ".$dbprefix."_addressbook_categories";
        DBUtil::executeSQL($sql);

        return true;
    }

    function migratecategories()
    {
        $dbprefix = pnConfigGetVar('prefix');

        // pull old prefix values
        $sql = "SELECT pre_id, pre_name FROM {$dbprefix}_addressbook_prefixes";
        $result = DBUtil::executeSQL($sql);
        $prefixes = array();
        for (; !$result->EOF; $result->MoveNext()) {
            $prefixes[] = $result->fields;
        }

        // load necessary classes
        Loader::loadClass('CategoryUtil');
        Loader::loadClassFromModule('Categories', 'Category');
        Loader::loadClassFromModule('Categories', 'CategoryRegistry');

        // get the language file
        $lang = ZLanguage::getLanguageCode();

        // get the category path for which we're going to insert our place holder category
        $rootcat = CategoryUtil::getCategoryByPath('/__SYSTEM__/General');
        $foaCat  = CategoryUtil::getCategoryByPath('/__SYSTEM__/General/Form of address');

        if (!$foaCat) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $rootcat['id']);
            $cat->setDataField('name', 'Form of address');
            $cat->setDataField('display_name', array($lang => __('Form of address')));
            $cat->setDataField('display_desc', array($lang => __('Form of address')));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
        }

        // get the category path for which we're going to insert our upgraded News categories
        $foaCat = CategoryUtil::getCategoryByPath('/__SYSTEM__/General/Form of address');

        // migrate our main categories
        foreach ($prefixes as $prefix) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $foaCat['id']);
            $cat->setDataField('name', $prefix[1]);
            $cat->setDataField('is_leaf', 1);
            $cat->setDataField('display_name', array($lang => $prefix[1]));
            $cat->setDataField('display_desc', array($lang => $prefix[1]));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
            $catid = $cat->getDataField('id');

            $sql = "UPDATE {$dbprefix}_addressbook_address SET adr_prefix = $catid WHERE adr_prefix = $prefix[0]";
            if (!DBUtil::executeSQL($sql)) {
                return LogUtil::registerError(__('Error! Update attempt failed.'));
            }
        }

        // now drop the prefixes table
        $sql = "DROP TABLE ".$dbprefix."_addressbook_prefixes";
        DBUtil::executeSQL($sql);

        return true;
    }
*/

    function uninstall()
    {

        DoctrineUtil::dropTable('addressbook');

        
        
        //DBUtil::dropTable('addressbook_address');
        //DBUtil::dropTable('addressbook_labels');
        //DBUtil::dropTable('addressbook_customfields');
        //DBUtil::dropTable('addressbook_favourites');

        // Delete any module variables
        $this->delVars();

        // Delete entries from category registry
        //if (!pnModDBInfoLoad('Categories')) {
        //    return false;
        //}

        //DBUtil::deleteWhere('categories_registry', "crg_modname='AddressBook'");

        // Deletion successful
        return true;
    }

    /*function createdefaultcategory()
    {
        // load necessary classes
        Loader::loadClass('CategoryUtil');
        Loader::loadClassFromModule('Categories', 'Category');
        Loader::loadClassFromModule('Categories', 'CategoryRegistry');

        // get the language file
        $lang = ZLanguage::getLanguageCode();

        // get the category path for which we're going to insert our place holder category
        $rootcat = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules');
        $adrCat    = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/AddressBook');

        if (!$adrCat) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $rootcat['id']);
            $cat->setDataField('name', 'AddressBook');
            $cat->setDataField('display_name', array($lang => __('AddressBook')));
            $cat->setDataField('display_desc', array($lang => __('Adress administration.')));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
        }

        // create the first 2 categories
        $adrCat    = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/AddressBook');
        $adrCat1    = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/AddressBook/Business');
        if (!$adrCat1) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $adrCat['id']);
            $cat->setDataField('name', 'Business');
            $cat->setDataField('is_leaf', 1);
            $cat->setDataField('display_name', array($lang => __('Business')));
            $cat->setDataField('display_desc', array($lang => __('Business')));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
        }
        $adrCat2    = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/AddressBook/Personal');
        if (!$adrCat2) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $adrCat['id']);
            $cat->setDataField('name', 'Personal');
            $cat->setDataField('is_leaf', 1);
            $cat->setDataField('display_name', array($lang => __('Personal')));
            $cat->setDataField('display_desc', array($lang => __('Personal')));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
        }


        if ($adrCat) {
            // place category registry entry for products (key == Products)
            $registry = new PNCategoryRegistry();
            $registry->setDataField('modname', 'AddressBook');
            $registry->setDataField('table', 'addressbook_address');
            $registry->setDataField('property', 'AddressBook');
            $registry->setDataField('category_id', $adrCat['id']);
            $registry->insert();
        }

        // now the old prefix field
        // get the category path for which we're going to insert our place holder form of address
        $rootcat = CategoryUtil::getCategoryByPath('/__SYSTEM__/General');
        $foaCat    = CategoryUtil::getCategoryByPath('/__SYSTEM__/General/Form of address');

        if (!$foaCat) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $rootcat['id']);
            $cat->setDataField('name', 'Form of address');
            $cat->setDataField('display_name', array($lang => __('Form of address')));
            $cat->setDataField('display_desc', array($lang => __('Form of address')));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
        }

        // create the first 2 categories
        $foaCat    = CategoryUtil::getCategoryByPath('/__SYSTEM__/General/Form of address');
        $foaCat1    = CategoryUtil::getCategoryByPath('/__SYSTEM__/General/Form of address/Mr');
        if (!$foaCat1) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $foaCat['id']);
            $cat->setDataField('name', 'Mr');
            $cat->setDataField('is_leaf', 1);
            $cat->setDataField('display_name', array($lang => __('Mr.')));
            $cat->setDataField('display_desc', array($lang => __('Mr.')));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
        }
        $foaCat2    = CategoryUtil::getCategoryByPath('/__SYSTEM__/General/Form of address/Mrs');
        if (!$foaCat2) {
            $cat = new PNCategory();
            $cat->setDataField('parent_id', $foaCat['id']);
            $cat->setDataField('name', 'Mrs');
            $cat->setDataField('is_leaf', 1);
            $cat->setDataField('display_name', array($lang => __('Mrs.')));
            $cat->setDataField('display_desc', array($lang => __('Mrs.')));
            if (!$cat->validate('admin')) {
                return false;
            }
            $cat->insert();
            $cat->update();
        }

        return true;
    }
*/

    /**
     * upgrade to 1.3
     *
    
    function upgradeto_1_3()
    {        
        $oldvars = $this->getVars();

        foreach ($oldvars as $varname => $oldvar)
        {
           $this->delVar($varname, $oldvar);
        }

        $this->setVars('AddressBook', $oldvars);

        return true;
    }*/
}
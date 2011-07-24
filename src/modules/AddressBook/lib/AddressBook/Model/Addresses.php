<?php
/**
 * Copyright Zikula Foundation 2010 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * This is the model class that define the entity structure and behaviours.
 */
class AddressBook_Model_Addresses extends Doctrine_Record
{
    /**
     * Set table definition.
     *
     * @return void
     */
    public function setTableDefinition()
    {
        $this->setTableName('adddressbook_addresses');
        $this->hasColumn('pid',   'integer', 16, array(
            'unique'  => true,
            'primary' => true,
            'notnull' => true,
            'autoincrement' => true,
        ));
        $this->hasColumn('lastname',         'string',  64);
        $this->hasColumn('firstname',        'string',  64);
        $this->hasColumn('title',            'string',  64);
        $this->hasColumn('nickname',         'string',  64);
        $this->hasColumn('note',             'string',  64);
        $this->hasColumn('organisation',     'string',  64);
        $this->hasColumn('categories',       'string', 255);
        $this->hasColumn('role',             'string',  64);
        $this->hasColumn('bday',             'date');
        $this->hasColumn('cr_uid',           'integer', 16);
        $this->hasColumn('private',          'integer',  1);
        $this->hasColumn('address_home',     'string', 255);
        $this->hasColumn('address_work',     'string', 255);
        $this->hasColumn('email',            'string',  64);
        $this->hasColumn('phone_home',       'string',  64);
        $this->hasColumn('phone_work',       'string',  64);
        $this->hasColumn('phone_mobile',     'string',  64); 

        
    }
}
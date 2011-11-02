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

class AddressBook_Api_User extends Zikula_AbstractApi
{
    
    /**
    * Get a section by the section ID
    *
    * @param int $city  ection ID
    * @return section data
    */

    public function getAddress($pid)
    {
        return Doctrine_Core::getTable('AddressBook_Model_Addresses')->findOneBy('pid', $pid, Doctrine_Core::HYDRATE_ARRAY);
    }

    /**
    * Get all addresses
    *
    * @param 
    * @return addresses data
    */

    public function getAddresses($args)
    {
        extract($args);
        if(empty($orderBy)) {
            $orderBy = 'firstname';
        }
        $q = Doctrine_Query::create()
            ->from('AddressBook_Model_Addresses s')
            ->orderBy($orderBy);
        if(!empty($letter)) {
            $q->where(
                'firstname like ? or firstname like ?',
                array($letter.'%', strtoupper($letter).'%')
            );
        }
        if(!empty($name)) {
            $q->addWhere(
                'firstname like ? or firstname like ?',
                array('%'.$name.'%', '%'.$name.'%')
            );
        }
        if(!empty($organisation)) {
            $q->addWhere(
                'organisation = ?',
                array($organisation)
            );
        }
        /*if(!empty($category)) {
            $q->addWhere(
                'categories like ?',
                '%:"'.$category.'";%'
            );
        }*/
        $addresses = $q->execute()->toArray();
        return $addresses;
    }
    
    
    public function getOrganisations()
    {
        $q = Doctrine_Query::create()
            ->from('AddressBook_Model_Addresses s')
            ->orderBy('organisation')
            ->groupBy('organisation');
        $result = $q->execute();
        $result = $result->toKeyValueArray('organisation', 'organisation');
        return $this->toDropDownList($result);
    }
    
    public function getCategories()
    {
        $q = Doctrine_Query::create()->from('AddressBook_Model_Addresses s');      
        $result = $q->execute();
        $result->toArray();        

        $categories = array();
        foreach($result as $value) {
            $categories =  array_merge($categories,$value['categories']);
        }
        $categories = array_unique($categories);
        sort($categories);
        
        return $this->toDropDownList($categories);
    }
    
    public function toDropDownList($input) {
        $dropdownlist[] = array(
            'text' => $this->__('All'),
            'value' => '',  
        );
        
        foreach($input as $key => $value) {
            if(!empty($value)) {
                $dropdownlist[] = array(
                    'text' => $value,
                    'value' => $value,             
                );
            }
        }
        return $dropdownlist;
    }
    
    public function getBirthdays($dayslater) {
        
        if(!is_numeric($dayslater)) {
            $dayslater = 7;
        }
        $sql = 'select * from addressbook '.
               'WHERE DATE_FORMAT(bday, \'%m%d\') BETWEEN '.date('md').' AND '.date('md', strtotime("+$dayslater days")).'  AND bday <> \'0000-00-00\''.
               'ORDER BY DATE_FORMAT(bday, \'%m%d\')';
        $res = DBUtil::executeSQL($sql);
        $res = DBUtil::marshallObjects($res);
        return $res;
        

    }

}
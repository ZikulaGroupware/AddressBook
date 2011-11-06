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
        return $this->entityManager->find('AddressBook_Entity_Addresses', $pid)->getAll();
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
            $orderBy = 'a.firstname';
        }
        
        
        $em = $this->getService('doctrine.entitymanager');
        $qb = $em->createQueryBuilder();
        $qb->select('a')
           ->from('AddressBook_Entity_Addresses', 'a')
           ->orderBy($orderBy);

      
        
        if(!empty($letter)) {
            $qb->where('a.firstname like :firstname1 or a.firstname like :firstname2')
               ->setParameter('firstname1', $letter.'%')
               ->setParameter('firstname2', '%'.strtoupper($letter).'%');
        }
        if(!empty($name)) {
            $qb->andWhere('a.firstname like :firstname3')
               ->setParameter('firstname3', '%'.$name.'%');
        }
        if(!empty($organisation)) {
            $qb->andWhere('a.organisation = :organisation')
               ->setParameter('organisation', $organisation);
        }
        /*if(!empty($category)) {
            $q->addWhere(
                'categories like ?',
                '%:"'.$category.'";%'
            );
        }*/
        
        
        $query = $qb->getQuery();
        return $query->getArrayResult();
        

    }
    
    
    public function getOrganisations()
    {
        
        $em = $this->getService('doctrine.entitymanager');
        $qb = $em->createQueryBuilder();
        $qb->select('a.organisation')
           ->from('AddressBook_Entity_Addresses', 'a')
           ->orderBy('a.organisation')
           ->groupBy('a.organisation');
        $query = $qb->getQuery();
        $result = $query->getArrayResult();
        return $this->toDropDownList($result, 'organisation');
    }
    
    public function getCategories()
    {
    }
    
    public function toDropDownList($input, $col) {
        $dropdownlist[] = array(
            'text' => $this->__('All'),
            'value' => '',  
        );
        
        foreach($input as $key => $value) {
            if(!empty($value[$col])) {
                $dropdownlist[] = array(
                    'text' => $value[$col],
                    'value' => $value[$col],             
                );
            }
        }
        return $dropdownlist;
    }
    
    public function getBirthdays($dayslater = 7) {
        
        if(!is_numeric($dayslater)) {
            $dayslater = 7;
        }
        
        $rsm = new Doctrine\ORM\Query\ResultSetMapping;
        $rsm->addEntityResult('AddressBook_Entity_Addresses', 'a');
        $rsm->addFieldResult('a', 'pid', 'pid');
        $rsm->addFieldResult('a', 'firstname', 'firstname');
        $rsm->addFieldResult('a', 'lastname', 'lastname');
        $rsm->addFieldResult('a', 'bday', 'bday');

        $em = $this->getService('doctrine.entitymanager');
        $sql = 'SELECT pid, firstname, lastname, bday '.
               'FROM addressbook '.
               "WHERE DATE_FORMAT(bday, '%m%d') BETWEEN ".date('md').' AND '.date('md', strtotime("+$dayslater days")).' '.
               'ORDER BY DATE_FORMAT(bday, \'%m%d\')';
        $query = $em->createNativeQuery($sql, $rsm);
        
        return $query->getArrayResult();        

    }

}
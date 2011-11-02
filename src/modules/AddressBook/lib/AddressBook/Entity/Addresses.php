<?php

/**
 * Copyright AddressBook Team 2011
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/GPLv3 (or at your option, any later version).
 * @package AddressBook
 * @link https://github.com/phaidon/AddressBook
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AddressBook entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="addressbook")
 */
class AddressBook_Entity_Addresses extends Zikula_EntityAccess
{
    
    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pid;
    
    
    
    // personal
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $lastname;
        
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $additionalname;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $firstname;
        
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $nickname;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $role;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $organisation;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $title;
    
    
    // contact
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $homepage;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="array", nullable="true")
     */
    private $emails;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="array", nullable="true")
     */
    private $phones;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="array", nullable="true")
     */
    private $addresses;


    // dates
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="date", nullable="true")
     */
    private $bday;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="date", nullable="true")
     */
    private $anniversary;

    
    // others
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="string", length=64, nullable="true")
     */
    private $note;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="array", nullable="true")
     */
    private $categories;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="integer", length=11)
     */
    private $cr_uid;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="boolean")
     */
    private $private = false;
    
    /**
     * The following are annotations which define the name field.
     *
     * @ORM\Column(type="array", nullable="true")
     */
    private $custom_fields;
    
    
    public function set($value, $column) {
        $this->$column = $value;
    }
    
    
    public function setAll($data) {
        foreach($data as $key => $value) {
            if($key == 'bday' and is_string($value) ) {
                $value = new DateTime($value);
            }
            $this->set($value, $key);
        }
    }
    

    public function getAll() {

        return array(
            'pid'            => $this->pid,
            'firstname'      => $this->firstname,
            'lastname'       => $this->lastname,    
            'additionalname' => $this->additionalname,
            'nickname'       => $this->nickname,
            'role'           => $this->role,
            'organisation'   => $this->organisation,
            'title'          => $this->title,
            'homepage'       => $this->homepage,
            'emails'         => $this->emails,
            'phones'         => $this->phones,
            'addresses'      => $this->addresses,
            'bday'           => $this->bday,
            'anniversary'    => $this->anniversary,
            'note'           => $this->note,
            'categories'     => $this->categories,
            'cr_uid'         => $this->cr_uid,
            'private'        => $this->private,
            'custom_fields'  => $this->custom_fields
         );
        
    }
    
}
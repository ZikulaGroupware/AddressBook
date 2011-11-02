<?php

/**
 * Copyright Fabian Wuertz 2011
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package ISHAsections
 * @link  http://www.isha-international.org/
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */


class AddressBook_Controller_Ajax extends Zikula_AbstractController
{
    /**
     * Post setup.
     *
     * @return void
     */
    public function _postSetup()
    {
        // no need for a Zikula_View so override it.
    }


    
    public function remove()
    {
        if(!SecurityUtil::checkPermission('AddressBook::', '::', ACCESS_DELETE) ){
            return;
        }
        $pid = FormUtil::getPassedValue('id', -1, 'GET');
        $address = $this->entityManager->find('AddressBook_Entity_Addresses', $tid);
        $this->entityManager->remove($address);
        $this->entityManager->flush();
    }
   
}

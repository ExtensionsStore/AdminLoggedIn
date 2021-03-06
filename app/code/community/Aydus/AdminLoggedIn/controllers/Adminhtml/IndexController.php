<?php

/**
 * Admin index controller override to add logout observer
 *
 * @category   Aydus
 * @package    Aydus_AdminLoggedIn
 * @author     Aydus <davidt@aydus.com>
 */
require_once 'Mage/Adminhtml/controllers/IndexController.php';

class Aydus_AdminLoggedIn_Adminhtml_IndexController extends Mage_Adminhtml_IndexController {

    /**
     * Log out admin
     */
    public function logoutAction() {
        
        $adminSession = Mage::getSingleton('admin/session');
        $adminUser = $adminSession->getUser();

        if ($adminUser && $adminUser->getId()) {

            $adminUserId = (int) $adminUser->getId();

            $ipAddress = Mage::helper('aydus_adminloggedin')->getIp();
            $updatedAt = date('Y-m-d H:i:s');

            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $prefix = Mage::getConfig()->getTablePrefix();
            $table = $prefix . 'aydus_adminloggedin_adminlogin';

            $write->query("REPLACE INTO $table (admin_user_id,ip_address,loggedin,updated_at) VALUES($adminUserId,'$ipAddress',0,'$updatedAt')");
        }

        parent::logoutAction();
    }

}

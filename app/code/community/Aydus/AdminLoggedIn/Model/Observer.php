<?php

/**
 * AdminLoggedIn observer
 *
 * @category   Aydus
 * @package    Aydus_AdminLoggedIn
 * @author     Aydus Consulting <davidt@aydus.com>
 */

class Aydus_AdminLoggedIn_Model_Observer  
{
    
    /**
     * Register admin as logged into the backend
     *
     * @see admin_session_user_login_success controller_action_predispatch
     * @param Varien_Event_Observer $observer
     */
    public function setAdminIsLoggedIn($observer)
    {
        $adminUser = $observer->getUser();
        
        if (!$adminUser || !$adminUser->getId()){
            $adminUser = Mage::getSingleton('admin/session')->getUser();
        }
        
        if ($adminUser && $adminUser->getId()){
            
            $adminUserId = (int)$adminUser->getId();
            
            $ipAddress = Mage::helper('aydus_adminloggedin')->getIp();
             
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $now = date('Y-m-d H:i:s');
            $prefix = Mage::getConfig()->getTablePrefix();
            $table = $prefix.'aydus_adminloggedin_adminlogin';
            $write->query("REPLACE INTO $table (admin_user_id,ip_address,loggedin,updated_at) VALUES($adminUserId,'$ipAddress',1,'$now')");            
        }
        
        return $this;
    }    
    
    /**
     * 
     * @param Mage_Cron_Model_Schedule $schedule
     */
    public function logoutAdmin($schedule)
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $updatedAt = Mage::helper('adminloggedin')->getUpdatedAt();
        $prefix = Mage::getConfig()->getTablePrefix();
        $table = $prefix.'aydus_adminloggedin_adminlogin';
        $affectedRows = $write->exec("UPDATE $table SET loggedin = 0 WHERE updated_at < '$updatedAt'");
        
        return "$affectedRows logged out";
    }
    
}
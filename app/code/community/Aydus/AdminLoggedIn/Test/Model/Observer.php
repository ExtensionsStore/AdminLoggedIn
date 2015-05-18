<?php

/**
 * Observer test
 *
 * @category   Aydus
 * @package    Aydus_AdminLoggedIn
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_AdminLoggedIn_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case_Config
{    
    /**
     * Test observer
     *
     * @test
     * @loadFixture
     */
    public function setAdminIsLoggedIn()
    {
        echo "\nStarting Aydus_AdminLoggedIn model test.";
        
        $adminUserId = 1;
        $adminUser = Mage::getModel('admin/user');
        $adminUser->load($adminUserId);
        $_SERVER['REMOTE_ADDR'] = '173.61.104.116';
        
        $observer = new Varien_Event_Observer();
        $event = new Varien_Event();
        $observer->setEvent($event);    
        $observer->setUser($adminUser);
        
        $model = Mage::getModel('aydus_adminloggedin/observer');
        
        $observer = $model->setAdminIsLoggedIn($observer);
        $adminIsLoggedIn = $observer->getAdminIsLoggedIn();
        
        $prefix = Mage::getConfig()->getTablePrefix();
        $table = $prefix.'aydus_adminloggedin_adminlogin';
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $adminIsLoggedIn = (bool)$read->fetchOne("SELECT loggedin FROM $table WHERE admin_user_id = '$adminUserId'");
        
        $this->assertTrue($adminIsLoggedIn);
        

    }
    
    /**
     * Test observer
     *
     * @test
     * @loadFixture
     */    
    public function logoutAdmin() {
        
        $adminUserId = 1;
        $prefix = Mage::getConfig()->getTablePrefix();
        $table = $prefix.'aydus_adminloggedin_adminlogin';
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $updatedAt = Mage::helper('adminloggedin')->getUpdatedAt();
        $write->query("UPDATE $table SET loggedin = 1, updated_at = '$updatedAt'");
        sleep(1);
        
        $schedule = Mage::getModel('cron/schedule');
        $schedule->load(1);

        $model = Mage::getModel('aydus_adminloggedin/observer');
        $model->logoutAdmin($schedule);
        
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $loggedout = (bool)$read->fetchOne("SELECT loggedin FROM $table WHERE admin_user_id = '$adminUserId'");
        
        $this->assertFalse($loggedout);
        
        echo "\nCompleted Aydus_AdminLoggedIn model test.";        
    }

}
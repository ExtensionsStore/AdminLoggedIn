<?php

/**
 * Admin index controller override to add logout observer
 *
 * @category   Aydus
 * @package    Aydus_AdminLoggedIn
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_AdminLoggedIn_Test_Controller_Adminhtml_IndexController extends EcomDev_PHPUnit_Test_Case_Controller {


    
    /**
     * @test
     */
    public function logoutAction() {

        echo "\nStarting Aydus_AdminLoggedIn controller test.";
        $_SERVER['REMOTE_ADDR'] = '173.61.104.116';
        
        $adminUserId = 1;
        $adminUser = Mage::getSingleton('admin/user');
        $adminUser->load($adminUserId);
        
        $prefix = Mage::getConfig()->getTablePrefix();
        $table = $prefix.'aydus_adminloggedin_adminlogin';
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $updatedAt = Mage::helper('adminloggedin')->getUpdatedAt();
        $write->query("UPDATE $table SET loggedin = 1, updated_at = '$updatedAt' WHERE admin_user_id = '$adminUserId'");
        
        //log in admin
        $adminSession = Mage::getSingleton('admin/session');
        $adminSession->setIsFirstVisit(true);
        $adminSession->setUser($adminUser);
        $adminSession->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());
        Mage::dispatchEvent('admin_session_user_login_success',array('user'=>$adminUser));
        
        //mock admin user
        $adminUser = $this->getModelMock('admin/user');
        $adminUser->expects($this->any())->method('getId')->will($this->returnValue($adminUserId));
        $this->replaceByMock('singleton', 'admin/user', $adminUser);                    
        
        //set mock user
        $adminSession->setUser($adminUser);
        
        $this->dispatch('adminhtml/index/logout');
        
        $this->assertRequestRoute('adminhtml/index/logout');   
        
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $loggedout = (bool)$read->fetchOne("SELECT loggedin FROM $table WHERE admin_user_id = '$adminUserId'");
        
        $this->assertFalse($loggedout);        
        echo "\nCompleted Aydus_AdminLoggedIn controller test.";        
        
    }

}

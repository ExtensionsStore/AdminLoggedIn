<?php

/**
 * Login into the admin first before testing
 * 
 * Put your email address and IP address below in the set up
 *
 * @category    Aydus
 * @package     Aydus_AdminLoggedIn
 * @author      Aydus <davidt@aydus.com>
 */

include('bootstrap.php');

class LoginTest extends PHPUnit_Framework_TestCase {
    
    protected $_email;

    public function setUp() {
        
        $_SERVER['REMOTE_ADDR'] = '173.61.72.205';//NJ
        
        $this->_email =  'davidt@aydus.com';
    }

    public function testLogin() {
    	
        //first of all log into the admin
        $loggedin = Mage::helper('adminloggedin')->adminIsLoggedIn();
        
        $true = ($loggedin) ? true : false;
        
        $this->assertTrue($true);
    }
    
    public function testGetAdmin()
    {
        $admin = Mage::helper('adminloggedin')->getAdmin();
        
        $this->assertEquals($this->_email, $admin->getEmail());
    }

}

<?php

/**
 * Log out of the admin first before testing or 
 * put a different IP address below from the one 
 * you used to test login
 * 
 * @category    Aydus
 * @package     Aydus_AdminLoggedIn
 * @author      Aydus <davidt@aydus.com>
 */

include('bootstrap.php');

class LoggedoutTest extends PHPUnit_Framework_TestCase {
    
    protected $_email;

    public function setUp() {
        
        $_SERVER['REMOTE_ADDR'] = '173.61.72.206';//different from Login test
    }

    public function testLoggedout() {
    	
        $loggedin = Mage::helper('adminloggedin')->adminIsLoggedIn();
        
        $true = ($loggedin) ? true : false;
        
        $this->assertFalse($true);
    }
    


}

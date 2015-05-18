<?php

/**
 * Helper test
 *
 * @category   Aydus
 * @package    Aydus_AdminLoggedIn
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_AdminLoggedIn_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{    
    /**
     *
     * @test
     */
    public function getIp()
    {
        echo "\nStarting Aydus_AdminLoggedIn helper test...";
        $ip = '173.61.104.116';
        $_SERVER['REMOTE_ADDR'] = $ip;

        $helper = Mage::helper('aydus_adminloggedin');
        
        $this->assertEquals($ip, $helper->getIp());
        
        echo "\nCompleted Aydus_AdminLoggedIn helper test.";        
    }


}
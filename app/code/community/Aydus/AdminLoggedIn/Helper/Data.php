<?php

/**
 * Cms Auth helper
 *
 * @category   Aydus
 * @package    Aydus_AdminLoggedIn
 * @author     Aydus <davidt@aydus.com>
 */
class Aydus_AdminLoggedIn_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     *
     * @param string $long
     * @return Ambigous <number, string>
     */
    public function getIp($long = false) {
        $request = Mage::app()->getRequest();

        if ($request->getServer('HTTP_CLIENT_IP')) {
            $ip = $request->getServer('HTTP_CLIENT_IP');
        } else if ($request->getServer('HTTP_X_FORWARDED_FOR')) {
            $ip = $request->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $request->getServer('REMOTE_ADDR');
        }

        if ($long) {

            $ip = ip2long($ip);
        }

        return $ip;
    }

    /**
     * 
     * @return string
     */
    public function getUpdatedAt() {
        $adminSessionLifetime = (int) Mage::getStoreConfig('admin/security/session_cookie_lifetime');
        $now = date('Y-m-d H:i:s');
        $updatedAt = date('Y-m-d H:i:s', time() - $adminSessionLifetime);

        return $updatedAt;
    }

    /**
     * 	See if admin is logged in
     *
     * 	@return boolean
     */
    public function adminIsLoggedin() {
        $loggedin = false;

        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $ipAddress = $this->getIp();
        $updatedAt = $this->getUpdatedAt();

        $prefix = Mage::getConfig()->getTablePrefix();
        $table = $prefix . 'aydus_adminloggedin_adminlogin';

        $sql = "SELECT loggedin FROM $table WHERE ip_address = '$ipAddress' AND updated_at > '$updatedAt'";
        $loggedin = (int) $read->fetchOne($sql);

        return $loggedin;
    }

    /**
     * Get admin instance
     * 
     * @return Mage_Admin_Model_User
     */
    public function getAdmin() {
        $admin = Mage::getModel('admin/user');

        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $ipAddress = $this->getIp();

        $prefix = Mage::getConfig()->getTablePrefix();
        $table = $prefix . 'aydus_adminloggedin_adminlogin';

        $sql = "SELECT admin_user_id FROM $table WHERE ip_address = '$ipAddress'";
        $adminUserId = (int) $read->fetchOne($sql);

        if ($adminUserId) {

            $admin->load($adminUserId);
        }

        return $admin;
    }

}

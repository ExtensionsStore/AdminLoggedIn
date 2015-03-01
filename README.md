Admin Logged In
===============

Helper module to check if the admin is logged. May be useful if you 
have the need to check for the admin user on the front end.

Description
-----------
On the front end, some times you have the need to check whether the 
admin is logged. For example, for debugging purposes. This helper module 
provides a boolean that you can add to front end code to test for the 
presence of the admin.


How to use
----------

Use the helper to test for admin log in. For example:

<pre>
    if (Mage::helper('adminloggedin')->adminIsLoggedIn()){
    ...
    } else {
    ...
    }
</pre>
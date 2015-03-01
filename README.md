Admin Logged In
===============

Helper module to check if you're logged in as admin on the front end.
Maybe be useful for debugging purposes.

Description
-----------
On the front end, some times you have the need to check whether the 
admin is logged in. For example, you want certain front end features 
to be available only to the admin. Or for debugging purposes on a live 
site, you want to print out a bug. This module provides a helper method 
that you can add to front end code to test whether an admin is viewing 
the page.


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
This package adds RESS for improved mobile detection as detailed here:
http://www.lukew.com/ff/entry.asp?1392
http://www.netmagazine.com/tutorials/getting-started-ress

NOTE: You must manually copy the contents of this package's libraries directory into your root/libraries directory.
This is necessary because the libraries/view.php cannot be overridden from a package.

The basic idea is to overwrite the mobile detection to test against a list of user agent strings upon
the initial user visit and save the findings to a cookie.  Then load a javascript that will measure
the viewport and overwrite the cookie if it can get a good reading.  This package also provides a
ress image block which allows the user to add a different image for mobile/tablet/desktop.

This package works in conjunction with the mobile templating system found within concrete5.  It simply
does a better job of detecting mobile devices than the core detection.  You can use the given mobile
templating system or build your responsive design in one theme.

With this package installed you can do things like this in your templates:

<?php if(IS_MOBILE){
  echo "Do something only for mobile";
} ?>

<?php if(IS_TABLET){
  echo "Do something only for tablets";
} ?>

<?php if(IS_DESKTOP){
  echo "Do something only for desktop";
} ?>

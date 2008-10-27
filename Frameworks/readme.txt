Frameworks provides a collective of common functions, classes, service packages like fpdf, tranfser that are required or can be used by modules like article, cbb, planet, wordpress, mediawiki and more

Make sure to use the latest version.

user guide:

1 check the files xoops_version.php under /Frameworks/ and subfolder to make sure it is newer than your current ones

2 upload /Frameworks/ to your XOOPS root path:
  XOOPS/Frameworks/art
  XOOPS/Frameworks/captcha
  XOOPS/Frameworks/fpdf
  XOOPS/Frameworks/PEAR
  XOOPS/Frameworks/textsanitizer
  XOOPS/Frameworks/transfer
  XOOPS/Frameworks/compat
  XOOPS/Frameworks/xoops22 (for compat)

3 check file names: for filename case sensitive system, make sure you have the file names literally correct, i.e., "Frameworks" is not identical to "frameworks"

4 configure preferences where applicable
4.1 ./fpdf/language/: make your local langauge file based on english.php, you could check schinese.php as example, or inline comments in english.php
4.2 ./textsanitizer/config.php: check inline comments
4.3 ./transfer/:
4.3.1 ./transfer/language/: make your local langauge file based on english.php
4.3.2 ./transfer/modules/: for developers only, add transfer handler for your module, or store the file as: XOOPS/modules/mymodule/include/plugin.transfer.php
4.3.3 ./transfer/plugin/: add items available for the transfer
4.3.4 ./transfer/plugin/myplugin/config: configurations for a plugin
4.3.5 ./transfer/plugin/myplugin/language/: make your local langauge file based on english.php
4.3.6 ./transfer/bar.transfer.php: set "$limit" for number of plugins that will be displayed on a front page;
4.4 ./compat/language/: make your local langauge files based on /english/
4.5 ./captcha/:
4.5.1 ./captcha/language/: make your local langauge file based on english.php
4.5.2 ./captcha/config.php: set configs

5 Requirements for XOOPS 2.2* users:
 Copy 
  /Frameworks/compat/language/english/local.php
  /Frameworks/compat/language/english/local.class.php
 To 
  XOOPS/language/english/
 And for other languages, after creating local language files as in step 4.4,, for instance "french"
 Copy
 /Frameworks/compat/language/french/local.php
 To
  XOOPS/language/french/
#secufiles
## by patrick hafner
#### secure one time sharing for notes and images


based on cakephp 2.6, jquery 2.x, bootstrap 3.x


----
installation
* clone this repo into your website root (this repository is the app/ dir of cakephp)
* if needed install php5-sqlite and php5-mcrypt
* copy Config/secufiles.default.php to Config/secufiles.php
* change security key
* open webroot/index.php and change cakephp library path to your needs
* run Console/cake schema create for creating the database
* maybe fix permissions for webroot/files/
* open your virtual host (etc.) to start
* for best security, use a (self signed) ssl-certificate
* have fun

---
features:
* text and images are encrypted with rijndael
* sqlite powered, no MySQL db needed
* images are on filesystem, encrypted (!)
* data will be removed from fs and database after expiration
* mobile first template
* whatsapp url scheme support for sharing the link directly

---
todo:
* option for ssl (force enabled)
* local storage list for uploaded elements
* password option
* custom value for how many times the file can be opened
* multilanguage

---
images:

![](https://raw.githubusercontent.com/patrickhafner/secufiles/master/tmp/ios.png)


![](https://raw.githubusercontent.com/patrickhafner/secufiles/master/tmp/desktop.png)

![](https://raw.githubusercontent.com/patrickhafner/secufiles/master/tmp/desktop2.png)

---
demo:

* no demo, sorry

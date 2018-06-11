===============================================
= Newspaper Project for CrossOver
= Rev. by D.A.Paula
===============================================

PREREQUISITES
 - WAMP Server with the extensions below:
	- PHP >= 5.6.4
	- OpenSSL PHP Extension
	- PDO PHP Extension
	- Mbstring PHP Extension
	- Tokenizer PHP Extension
	- XML PHP Extension
	- mod_rewrite
 
 
 
===============================================
= Server Setup Guide
===============================================

Assumed the usage of an WAMP server for this setup:

1.	Import file 'newspaper.sql' to MySQL server.

2.	Add the VirtualHost setup below to the Apache httpd.conf. Change the DocumentRoot
	and Directory if the path of the project is different from below. Be sure to enable
	the mod_rewrite module so the .htaccess file will be honored by the server:

	<VirtualHost *:80>
		ServerName newspaper
		DocumentRoot "e:/web-dev/laravel/newspaper/Source/public"
		<Directory  "e:/web-dev/laravel/newspaper/Source/public/">
			Options +Indexes +Includes +FollowSymLinks +MultiViews
			AllowOverride All
			Require local
		</Directory>
	</VirtualHost>

	if the above information does not work, try the apache config listed
	on https://laravel.com/docs/5.4/installation
	
	
3.	Add the following lines to C:\Windows\system32\drivers\etc\hosts to enable access
	of the project thru http://newspaper/ in the browser

	127.0.0.1	newspaper
	::1	newspaper
	
4. Restart WAMP Server

===============================================
= Project Setup
===============================================

All the config below was applied to the enviroment file /Source/.env

1.	If the SQL file was injected sucessfully to MySQL Server, it comes already with an user setup.
	If a different user or server was choosen for this application, please change the setup below
	in the enviroment file with required server information:

	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=newspaper
	DB_USERNAME=newspaper
	DB_PASSWORD=HYjZ6FFTYXrE9xK4

2.	Was used mailtrap services for this test. If another smtp server will be used, please change
	the setup below in the enviroment file with required server information. This project does not
	work with Google authentication system (needed libs not included):

	MAIL_HOST=smtp.mailtrap.io
	MAIL_PORT=2525
	MAIL_USERNAME=ad703ad7a15568
	MAIL_PASSWORD=26f1cbf8b34dff


===============================================
= Test units
===============================================

Before tests, xdebug tool must be installed to ensure the tests
 1.	go to https://xdebug.org/wizard.php
 2. post your php -i
 3. and run the steps

 for example only: in my case, it will required to download a library php_xdebug-2.5.4-5.6-vc11-x86_64.dll,
 moved the downloaded file to e:\wamp64\bin\php\php5.6.25\ext and
 edited file \wamp64\bin\php\php5.6.25\php.ini to add line below
 zend_extension = e:\wamp64\bin\php\php5.6.25\ext\php_xdebug-2.5.4-5.6-vc11-x86_64.dll

PHP bin directory must be in PATH variables
if not please add E:\wamp64\bin\php\php5.6.25 (your server location)
because phpunit requires PHP.exe to run

after installations, if you are in windows, open CMD:
 1.	go to project source directory
 2.	vendor\bin\phpunit.bat

===============================================
= Information
===============================================

Only for info, this project was created by artisan tool using the commands below

//using cmd (comand line tool in Windows)
//creating directory
e:
cd web-dev/laravel
mkdir newspaper

//creating new laravel project
laravel new newspaper

//copied enviroment file
copy .env.example .env

//generate Application Key
php artisan key:generate

//create authentication login forms
php artisan make:auth

//create tables in mysql from artisan
php artisan migrate


## Virus Maester
A simple VirusTotal Client

### Requirement
* PHP 5.5
* Mbstring PHP Extension
* PHP Composer

### Installation

#### Install Composer
First of all, you need to install composer. to get composer, run the following commands:

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '92102166af5abdb03f49ce52a40591073a7b859a86e8ff13338cf7db58a19f7844fbc0bb79b2773bf30791e935dbd938') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --install-dir=bin --filename=composer
php -r "unlink('composer-setup.php');"
```

More info at [https://getcomposer.org/download/](https://getcomposer.org/download/)

#### Install Packages

To install required packages you should run the following command:

```
composer install
```

### Configuration
To generate the VirusTotal config file you should run following command:

```
php artisan vendor:publish
```

Then open or create `.env` file in root of project, and add the following line in it:
 
 ```
 VT_API_KEY={YOU_API_KEY}
 ```
 
 > For configuring web server, set root document to `{path_to_project}/public`
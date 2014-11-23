# SmartHome-GUI #
----------

SmartHome-GUI is a visualisation of [SmartHome-PHP](https://github.com/Bubelbub/SmartHome-PHP.git).
You could manage your SmartHomes with this.

## Supported SmartHomes ##

- [RWE-SmartHome](http://www.rwe-smarthome.de)

## Functions ##

**Implemented:**
- Multiple central management (list/add/remove centrals)

**Planned:**
- Complete documentation for functions
- Installation documentation for Raspberry Pi computer

## Installation ##

1. Download GIT

   Debian/Ubuntu: `apt-get install git-core`
   Windows: http://msysgit.github.io/

2. Clone the project

        $ git clone https://github.com/Bubelbub/SmartHome-GUI.git

3. Go into the directory

        $ cd SmartHome-GUI

3. Download [composer](https://getcomposer.org/download/)

        $ php -r "readfile('https://getcomposer.org/installer');" | php

4. Install the project

        $ php composer.phar install
   If you're asking for a database things enter your database data.
   At the other questions you could hit enter. For mailing you could enter your SMTP mail data.
   SQLite Users should look at this [help](http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html#driver)

5. Clearing cache in production mode (on Windows you should start cmd as administrator! For the symlink!)

        $ php app/console cache:clear --env=prod
        $ php app/console doctrine:schema:update --force --env=prod
        $ php app/console assets:install --symlink web --env=prod
        $ php app/console assetic:dump --env=prod

5. Have fun with [http://localhost/SmartHome-GUI/web/app_dev.php](http://localhost/SmartHome-GUI/web/app_dev.php) for example! :)

## License ##

[SmartHome-GUI](https://github.com/Bubelbub/SmartHome-GUI) is licensed under a [MIT License](http://opensource.org/licenses/MIT).

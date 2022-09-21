# Simple basic Xdebug configuration with integration to PHPStorm

## To config xdebug you need add these lines in php-fpm/php-ini-overrides.ini:

### For linux:
```
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_autostart = 1
```

### For MacOS and Windows:
```
xdebug.remote_enable=1
xdebug.remote_host=host.docker.internal
xdebug.remote_autostart = 1
```

## Add the section “environment” to the php-fpm service in docker-compose.yml:

environment:

  PHP_IDE_CONFIG: "serverName=Docker"

### Create a server configuration in PHPStorm:
 * In PHPStorm open Preferences | Languages & Frameworks | PHP | Servers
 * Add new server
 * The “Name” field should be the same as the parameter “serverName” in “environment” in docker-compose.yml
 * A value of the "port" field should be the same as first port(before a colon) in "webserver" service in docker-compose.yml
 * Select "Use path mappings" and set mappings between a path to your project on a host system and the Docker container.
 * Finally, add “Xdebug helper” extension in your browser, set breakpoints and start debugging




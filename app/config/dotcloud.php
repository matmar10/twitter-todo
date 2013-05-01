<?php 

$dotcloud_env_file = '/home/dotcloud/environment.json';
$dotcloud_env = json_decode(file_get_contents($dotcloud_env_file), true);

$container->setParameter('database_driver', 'pdo_mysql');
$container->setParameter('database_host', $dotcloud_env['DOTCLOUD_DB_MYSQL_HOST']);
$container->setParameter('database_port', $dotcloud_env['DOTCLOUD_DB_MYSQL_PORT']);
$container->setParameter('database_user', $dotcloud_env['DOTCLOUD_DB_MYSQL_LOGIN']);
$container->setParameter('database_password', $dotcloud_env['DOTCLOUD_DB_MYSQL_PASSWORD']);



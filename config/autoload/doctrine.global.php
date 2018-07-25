<?php
//config/autoload/doctrine.global.php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'user'      => 'root',
                    'password'  => '',
                    'host'      => 'localhost',
                    'port'      => '3306',
                    'dbname'    => 'certificados',
                    'driverOptions' => array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                    )

                ),
                'doctrine_type_mappings' => array(
                    'enum' => 'string'
                ),
            ),
        ),
    ),
    'php_settings' => array(
        'date.timezone'                 => 'America/Bahia',
        'mbstring.internal_encoding'    => 'UTF-8',
    )
);
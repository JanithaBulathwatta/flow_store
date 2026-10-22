<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Central database for authentication
$db['central'] = array(
    'dsn'       => '',
    'hostname'  => '127.0.0.1',
    'username'  => 'root',
    'password'  => '',
    'database'  => 'inv2_main',
    'dbdriver'  => 'mysqli',
    'dbprefix'  => '',
    'pconnect'  => FALSE,
    'db_debug'  => (ENVIRONMENT !== 'production'),
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => 'utf8',
    'dbcollat'  => 'utf8_general_ci',
    'swap_pre'  => '',
    'encrypt'   => FALSE,
    'compress'  => FALSE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries' => TRUE
);

// Default database - will be switched dynamically
$db['default'] = array(
    'dsn'       => '',
    'hostname'  => '127.0.0.1',
    'username'  => 'root',
    'password'  => '',
    'database'  => 'medi',  // Default tenant
    'dbdriver'  => 'mysqli',
    'dbprefix'  => '',
    'pconnect'  => FALSE,
    'db_debug'  => (ENVIRONMENT !== 'production'),
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => 'utf8',
    'dbcollat'  => 'utf8_general_ci',
    'swap_pre'  => '',
    'encrypt'   => FALSE,
    'compress'  => FALSE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries' => TRUE
);

$active_group = 'default';
$query_builder = TRUE;
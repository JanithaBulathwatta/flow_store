<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Get tenant database connection
 */
function get_tenant_db() {
    $CI =& get_instance();
    
    if (!isset($CI->tenant_db)) {
        // Check if tenant info exists in session
        if (isset($_SESSION['tenant_database']) && isset($_SESSION['tenant_id'])) {
            $tenant_db_config = array(
                'hostname'  => $_SESSION['tenant_db_host'] ?? '127.0.0.1',
                'username'  => $_SESSION['tenant_db_username'] ?? 'dev_erp',
                'password'  => $_SESSION['tenant_db_password'] ?? 'Dev@p00471Ct',
                'database'  => $_SESSION['tenant_database'],
                'dbdriver'  => 'mysqli',
                'db_debug'  => (ENVIRONMENT !== 'production'),
                'char_set'  => 'utf8',
                'dbcollat'  => 'utf8_general_ci',
            );
            $CI->tenant_db = $CI->load->database($tenant_db_config, TRUE);
        } else {
            // Fallback to default DB
            $CI->tenant_db = $CI->db;
        }
    }
    
    return $CI->tenant_db;
}

/**
 * Get central database connection
 */
function get_central_db() {
    $CI =& get_instance();
    
    if (!isset($CI->central_db)) {
        $CI->central_db = $CI->load->database('central', TRUE);
    }
    
    return $CI->central_db;
}

/**
 * Check if tenant DB is available
 */
function has_tenant_db() {
    $CI =& get_instance();
    
    if (isset($_SESSION['tenant_database']) && isset($_SESSION['tenant_id'])) {
        return true;
    }
    return false;
}
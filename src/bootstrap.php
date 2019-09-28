<?php
declare(strict_types = 1);

error_reporting(E_ALL);

mb_internal_encoding("utf-8");
mb_http_output("utf-8");

date_default_timezone_set("Europe/Amsterdam");

textdomain("default");
bind_textdomain_codeset("default", "UTF-8");

if (extension_loaded('xdebug')) {
    ini_set("xdebug.var_display_max_children", "-1");
    ini_set("xdebug.var_display_max_data", "-1");
    ini_set("xdebug.var_display_max_depth", "-1");
}

require(__DIR__ . '/../vendor/autoload.php');

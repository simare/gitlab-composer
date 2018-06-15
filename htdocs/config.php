<?php

function getConfig()
{
// See ../confs/samples/gitlab.ini
    $config_file = __DIR__ . '/../confs/gitlab.ini';
    if (!file_exists($config_file)) {
        header('HTTP/1.0 500 Internal Server Error');
        die('confs/gitlab.ini missing');
    }
    return parse_ini_file($config_file, false, INI_SCANNER_TYPED);

}

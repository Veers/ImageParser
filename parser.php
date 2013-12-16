<?php
require 'lib/simple_html_dom.php';
require 'db.php';

if ($_POST['data']) {
    #echo $_POST['data'];
    $address = $_POST['data'];
    $slash = '://';
    $protocol = 'http://';
    $pos = strpos($address, $slash);
    $arr = array();
    if ($pos === false)
        $address = $protocol.$address;
    $data = file_get_html($address);
    foreach($data->find('img') as $element)
        array_push($arr, array($element->src, remotefsize($element->src)));
    db::putImages($address, $arr);
}

function remotefsize($url) {
    $sch = parse_url($url, PHP_URL_SCHEME);
    if (($sch != "http") && ($sch != "https") && ($sch != "ftp") && ($sch != "ftps")) {
        return false;
    }
    if (($sch == "http") || ($sch == "https")) {
        $headers = get_headers($url, 1);
        if ((!array_key_exists("Content-Length", $headers))) { return false; }
        return $headers["Content-Length"];
    }
    if (($sch == "ftp") || ($sch == "ftps")) {
        $server = parse_url($url, PHP_URL_HOST);
        $port = parse_url($url, PHP_URL_PORT);
        $path = parse_url($url, PHP_URL_PATH);
        $user = parse_url($url, PHP_URL_USER);
        $pass = parse_url($url, PHP_URL_PASS);
        if ((!$server) || (!$path)) { return false; }
        if (!$port) { $port = 21; }
        if (!$user) { $user = "anonymous"; }
        if (!$pass) { $pass = "phpos@"; }
        switch ($sch) {
            case "ftp":
                $ftpid = ftp_connect($server, $port);
                break;
            case "ftps":
                $ftpid = ftp_ssl_connect($server, $port);
                break;
        }
        if (!$ftpid) { return false; }
        $login = ftp_login($ftpid, $user, $pass);
        if (!$login) { return false; }
        $ftpsize = ftp_size($ftpid, $path);
        ftp_close($ftpid);
        if ($ftpsize == -1) { return false; }
        return $ftpsize;
    }
}



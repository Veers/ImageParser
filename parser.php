<?php
require 'lib/simple_html_dom.php';

class Parser
{
    function __construct()
    {
        //var_dump($_GET);
    }

    function parseLinks($links)
    {
        $address = $links;
        $slash = '://';
        $protocol = 'http://';
        $pos_is_http_in_address = strpos($address, $slash);
        if ($pos_is_http_in_address === false) {
            $address = $protocol . $address;
        }
        $data = file_get_html($address);
        $input_array_links_sizes = array();
        foreach ($data->find('a') as $element) {
            $rest = substr($element->href, strlen($element->href) - 3);
            if (strcasecmp($rest, 'jpg') == 0) {
                array_push($input_array_links_sizes, array($element->href => Parser::getRemoteFileSize($element->href)));
            }
        }
        return array($address, $input_array_links_sizes);
    }


    function getRemoteFileSize($url)
    {
        $schema = parse_url($url, PHP_URL_SCHEME);
        if (($schema != "http") && ($schema != "https") && ($schema != "ftp") && ($schema != "ftps")) {
            return false;
        }
        if (($schema == "http") || ($schema == "https")) {
            $headers = get_headers($url, 1);
            if ((!array_key_exists("Content-Length", $headers))) {
                return false;
            }
            return $headers["Content-Length"];
        }
    }

    function printData($links)
    {
        array_shift($links);
        $content = array();
        foreach ($links as $value){
            for ($i = 1; $i<count($value); $i++) {
                foreach ($value[$i] as $key=>$val){
                    array_push($content, $key);
                }
            }
        }
        return $content;
    }

}




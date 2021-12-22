<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');  

// require_once APPPATH."/third_party/simple_html_dom.php";
require_once APPPATH.'third_party\google-search-results.php';
 require_once APPPATH.'third_party\restclient.php';

class Search extends SerpApiSearch {
    public function __construct() {
        parent::__construct();
    }
}
?>
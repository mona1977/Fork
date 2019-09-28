<?php
/**

DEVELOPER : Surendra Gupta
DATE : 28-SEP-2019


 * file used for core configuration
 */

//show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//home page url
$home_url="http://localhost:2050/vessel/";

//page given in url parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//set number of records per page
$records_per_page = 10;

//calculate for query limit clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

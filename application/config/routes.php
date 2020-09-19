<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['/'] = 'welcome/index';
$route['insert'] = 'welcome/insert';
$route['fetch'] = 'welcome/fetch';
$route['delete'] = 'welcome/delete';
$route['edit'] = 'welcome/edit';
$route['update'] = 'welcome/update';

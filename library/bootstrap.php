<?php
define('MSC_ROOT', realpath(__DIR__ . '/..'));
define('MSC_LIB', __DIR__ . '/Msc');
require_once MSC_LIB . '/Checker.php';
require_once MSC_LIB . '/HttpClientCurl.php';
require_once MSC_LIB . '/TaskController.php';
require_once MSC_LIB . '/FileProcessor.php';
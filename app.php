<?php

ini_set('display_errors', true);
set_time_limit(600);
session_start();

require 'config.php';
require 'vendor/autoload.php';

function dd($content) {
    var_dump($content);
    die();
}

function logThis($message) {
    file_put_contents('sync.log', date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    echo $message . PHP_EOL;
}

use Picqer\Api\Client as PicqerClient;

// Picqer connection
$picqerclient = new PicqerClient($config['picqer-company'], $config['picqer-apikey']);

if (!isset($_GET['step'])) {
    header('Location: app.php?step=upload');
    exit;
}

switch ($_GET['step']) {
    case 'upload':
        include('view-form.php');

        break;

    case 'preview':
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $excelextrator = new PicqerImporter\ExcelExtractor($config);
            $orders = $excelextrator->processExcel(
                $_FILES['file']['tmp_name'],
                $_POST['customernumbers-rule'],
                $_POST['productcode-column'],
                $_POST['start-row'],
                $_POST['start-column']
            );

            $_SESSION['orders'] = $orders;
            $_SESSION['reference'] = $_POST['reference'];

            include('view-preview.php');
        } else {
            include('view-no-data.php');
            exit;
        }

        break;

    case 'import':
        if (!isset($_SESSION['orders']) || empty($_SESSION['orders'])) {
            include('view-no-data.php');
            exit;
        }
        $importer = new PicqerImporter\OrderImporter($picqerclient, $config);
        $orderids = $importer->importOrders($_SESSION['orders'], $_SESSION['reference']);
        unset($_SESSION['orders']);

        include('view-done.php');

        break;

    case 'cancel':
        unset($_SESSION['orders']);
        header('Location: app.php?step=upload');
        exit;

        break;
}

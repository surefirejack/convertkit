<?php


require_once("../includes/ConvertKit.class.php");

require_once('config.php');

$ck = new ConvertKit($apiKey, $apiSecretKey);


/*
 * ADD CUSTOM FIELD
 */

$params = array(
	'label' => $_POST['field_name']
);

$customfield = $ck->customfield();
$response = $customfield->add($params);

// print_r($response);

header('Location: example.php');


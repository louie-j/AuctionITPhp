<?php

// Require so both aren't needed
require 'FPDFWrapper.php';

// Takes array of items from database and sorts by item id to separate by sections
function GetItemsBySection($items) {
	$items100s = array();
	$items200s = array();
	$items300s = array();

	foreach ($items as $item) {
		if ($item['ItemId'] >= 100 && $item['ItemId'] < 200) {
			$items100s[count($items100s)] = $item;
		} else if ($item['ItemId'] >= 200 && $item['ItemId'] < 300) {
			$items200s[count($items200s)] = $item;
		} else if ($item['ItemId'] >= 300 && $item['ItemId'] < 400) {
			$items300s[count($items300s)] = $item;
		}
	}

	return array(
		array( "title" => "SECTION ONE - SILENT (PINK)",    "items" => $items100s ),
		array( "title" => "SECTION TWO - SILENT (YELLOW)",  "items" => $items200s ),
		array( "title" => "SECTION THREE - LIVE",						"items" => $items300s )
	);
}

// Makes a receipt by adding up purchases per buyers and listing each purchase
function GetReceiptsFromPurchases($purchases) {
	$receipts = array();

	foreach ($purchases as $purchase) {

		// Check if a receipt for that buyer is already started
		if (isset($receipts[$purchase['BuyerId']])) {
			$receipts[$purchase['BuyerId']]['Total'] += $purchase['Value'];
			$receipts[$purchase['BuyerId']]['Items'][count($receipts[$purchase['BuyerId']]['Items'])] = array(
				"ItemId"      => $purchase['ItemId'],
				"Value"       => $purchase['Value'],
				"Description" => $purchase['Description']
			);
		} else {
			$receipts[$purchase['BuyerId']] = array(
				"BuyerId"	=> $purchase['BuyerId'],
				"Name"		=> $purchase['Name'],
				"Total"   => $purchase['Value'],
				"Items"   => array(
					array(
						"ItemId"			=> $purchase['ItemId'],
						"Value"       => $purchase['Value'],
						"Description"	=> $purchase['Description']
					)
				)
			);
		}
	}

	return $receipts;
}

// Gets donor names and totals donated for thank you notes
function GetDonorsAndTotals($donations) {
	$donors = array();

	foreach ($donations as $donation) {

		// Check if a receipt for that buyer is already started
		if (isset($donors[$donation['Name']])) {
			$donors[$donation['Name']]['Total'] += $donation['Value'];
			$donors[$donation['Name']]['Items'][count($donors[$donation['Name']]['Items'])] = array(
				"ItemId"      => $donation['ItemId'],
				"Value"       => $donation['Value'],
				"Description" => $donation['Description']
			);
		} else {
			$donors[$donation['Name']] = array(
				"Name"		=> $donation['Name'],
				"Total"   => $donation['Value'],
				"Items"   => array(
					array(
						"ItemId"			=> $donation['ItemId'],
						"Value"       => $donation['Value'],
						"Description"	=> $donation['Description']
					)
				)
			);
		}
	}

	return $donors;
}

?>

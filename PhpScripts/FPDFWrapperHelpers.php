<?php

// Require so both aren't needed
require 'FPDFWrapper.php';

// Takes array of items from database and sorts by item id to separate by sections
function GetItemsBySection($items) {
	$items100s	= array();
	$items200s	= array();
	$items300s	= array();
	$retVal			= array();

	foreach ($items as $item) {
		if ($item['value'] < 0) {
			$item['value'] = 'Priceless';
		}

		if ($item["auction_id"] >= 100 && $item["auction_id"] < 200) {
			array_push($items100s, $item);
		} else if ($item['auction_id'] >= 200 && $item['auction_id'] < 300) {
			array_push($items200s, $item);
		} else if ($item['auction_id'] >= 300 && $item['auction_id'] < 400) {
			array_push($items300s, $item);
		}
	}

	if (count($items100s) > 0) {
		array_push($retVal, array( "title" => "SECTION ONE - SILENT (PINK)", "items" => $items100s ));
	}

	if (count($items200s) > 0) {
		array_push($retVal, array( "title" => "SECTION TWO - SILENT (YELLOW)", "items" => $items200s ));
	}

	if (count($items300s) > 0) {
		array_push($retVal, array( "title" => "SECTION THREE - LIVE", "items" => $items300s ));
	}

	return $retVal;
}

// Makes a receipt by adding up purchases per buyers and listing each purchase
function GetReceiptsFromPurchases($purchases, $bidderID) {
	$receipts = array();

	foreach ($purchases as $purchase) {

		// Check if a receipt for that buyer is already started
		if (!isset($bidderID) || ($purchase['bidder_id'] == $bidderID)) {
			if (isset($receipts[$purchase['bidder_id']])) {
				$receipts[$purchase['bidder_id']]['total'] = $receipts[$purchase['bidder_id']]['total'] == '______' ? '______' : ($purchase['value'] > 0 ? $receipts[$purchase['bidder_id']]['total'] + $purchase['value'] : '______');
				$receipts[$purchase['bidder_id']]['items'][count($receipts[$purchase['bidder_id']]['items'])] = array(
					"auction_id"  => $purchase['auction_id'],
					"value"       => $purchase['value'] > 0 ? $purchase['value'] : "______",
					"description" => $purchase['description']
				);
			} else {
				$receipts[$purchase['bidder_id']] = array(
					"bidder_id"	=> $purchase['bidder_id'],
					"name"			=> $purchase['name'],
					"total"   	=> $purchase['value'] > 0 ? $purchase['value'] : '______',
					"items"   	=> array(
						array(
							"auction_id"	=> $purchase['auction_id'],
							"value"       => $purchase['value'] > 0 ? $purchase['value'] : "______",
							"description"	=> $purchase['description']
						)
					)
				);
			}
		} else {
			
		}
	}

	return $receipts;
}

// Gets donor names and totals donated for thank you notes
function GetDonorsAndTotals($donations) {
	$donors = array();

	foreach ($donations as $donation) {

		// Check if a receipt for that buyer is already started
		if (isset($donors[$donation['donated_by']])) {
			$donors[$donation['donated_by']]['total'] = $donors[$donation['donated_by']]['total'] == '______' ? '______' : ($donation['value'] > 0 ? $donors[$donation['donated_by']]['total'] + $donation['value'] : '______');
			$donors[$donation['donated_by']]['items'][count($donors[$donation['donated_by']]['items'])] = array(
				"auction_id"  => $donation['auction_id'],
				"value"       => $donation['value'] > 0 ? $donation['value'] : "______",
				"description" => $donation['description']
			);
		} else {
			$donors[$donation['donated_by']] = array(
				"donated_by"	=> $donation['donated_by'],
				"total"   	  => $donation['value'] > 0 ? $donation['value'] : "______",
				"items"   	  => array(
					array(
						"auction_id"	=> $donation['auction_id'],
						"value"       => $donation['value'] > 0 ? $donation['value'] : "______",
						"description"	=> $donation['description']
					)
				)
			);
		}
	}

	return $donors;
}

// Sets the value correctly for priceless items
function GetNumSheetItems($items) {
	$retVal = array();

	foreach ($items as $item) {
		array_push($retVal, array(
			"auction_id"  => $item['auction_id'],
			"description" => $item['description'],
			"donated_by"  => $item['donated_by'],
			"value"       => $item['value'] > 0 ? $item['value'] : "Priceless"
		));
	}

	return $retVal;
}

?>

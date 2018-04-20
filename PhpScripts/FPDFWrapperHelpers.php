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

		if ($item['auctionId'] >= 100 && $item['auctionId'] < 200) {
			array_push($items100s, $item);
		} else if ($item['auctionId'] >= 200 && $item['auctionId'] < 300) {
			array_push($items200s, $item);
		} else if ($item['auctionId'] >= 300 && $item['auctionId'] < 400) {
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
		if (!isset($bidderID) || ($purchase['BidderId'] == $bidderID)) {
			if (isset($receipts[$purchase['BidderId']])) {
				$receipts[$purchase['BidderId']]['Total'] = $receipts[$purchase['BidderId']]['Total'] == '______' ? '______' : ($purchase['Value'] > 0 ? $receipts[$purchase['BidderId']]['Total'] + $purchase['Value'] : '______');
				$receipts[$purchase['BidderId']]['Items'][count($receipts[$purchase['BidderId']]['Items'])] = array(
					"AuctionId"   => $purchase['AuctionId'],
					"Value"       => $purchase['Value'] > 0 ? $purchase['Value'] : "______",
					"Description" => $purchase['Description']
				);
			} else {
				$receipts[$purchase['BidderId']] = array(
					"BidderId"	=> $purchase['BidderId'],
					"Name"			=> $purchase['Name'],
					"Total"   	=> $purchase['Value'] > 0 ? $purchase['Value'] : '______',
					"Items"   	=> array(
						array(
							"AuctionId"		=> $purchase['AuctionId'],
							"Value"       => $purchase['Value'] > 0 ? $purchase['Value'] : "______",
							"Description"	=> $purchase['Description']
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
		if (isset($donors[$donation['donatedBy']])) {
			$donors[$donation['donatedBy']]['Total'] = $donors[$donation['donatedBy']]['Total'] == '______' ? '______' : ($donation['value'] > 0 ? $donors[$donation['donatedBy']]['Total'] + $donation['value'] : '______');
			$donors[$donation['donatedBy']]['Items'][count($donors[$donation['donatedBy']]['Items'])] = array(
				"AuctionId"   => $donation['auctionId'],
				"Value"       => $donation['value'] > 0 ? $donation['value'] : "______",
				"Description" => $donation['description']
			);
		} else {
			$donors[$donation['donatedBy']] = array(
				"DonatedBy"	=> $donation['donatedBy'],
				"Total"   	=> $donation['value'] > 0 ? $donation['value'] : '______',
				"Items"   	=> array(
					array(
						"AuctionId"		=> $donation['auctionId'],
						"Value"       => $donation['value'] > 0 ? $donation['value'] : "______",
						"Description"	=> $donation['description']
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
			"auctionId"		=> $item['auctionId'],
			"description"	=> $item['description'],
			"donatedBy"		=> $item['donatedBy'],
			"value"				=> $item['value'] > 0 ? $item['value'] : 'Priceless'
		));
	}

	return $retVal;
}

?>

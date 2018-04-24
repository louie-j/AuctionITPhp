<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <?php

            session_start();
            if($_SESSION["accountType"] != 'user' && $_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
            $items = [];
        ?>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>      
        <script src="DataTables/datatables.min.js"></script>     
        <script type="text/javascript">
            var items;
            var bidders;
            var userValid = false;
            var itemValid = false;
            var itemSold = false;
            var bidValid = false;
            var minBid;
            var table;

            $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                     var id = document.getElementById('auctionID').value;
                    if (id == parseInt(data[0]))
                        return true;  
                    return false;
                }
            );

            $( document ).ready(function() {
                if(<?php echo $_SESSION['bidSuccess'] ?> === 1)
                {
                    alert("Bid Added");
                    <?php $_SESSION['bidSuccess'] = 0; ?>
                }
                else if(<?php echo $_SESSION['bidSuccess'] ?> === 2)
                {
                    alert("Error adding Bid to Database");
                    <?php $_SESSION['bidSuccess'] = 0; ?>
                }

                table = $('#myDataTable').DataTable( {
                    ajax: "phpScripts/ViewBids.php", 
                    columns: [
                        { mData: 'AuctionId', searchable: true, visible:false},
                        { mData: 'BidderId', searchable: false} ,
                        { mData: 'Amount', searchable: false},
                        { mData: 'Winning', searchable: false}
                    ],
                    bPaginate: false,
                    ordering: false,
                    order: [[2, "asc"]],
                    bInfo: false
                } );

                 $('#myDataTable tbody').on('click', 'tr', function () {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                });
                

                var oReq = new XMLHttpRequest();
                oReq.onload = function() {
                    items = JSON.parse(this.responseText).aaData;
                };
                oReq.open("get", "PhpScripts/ViewItemTable.php", true);
                oReq.send();

                var oReq2 = new XMLHttpRequest();
                
                oReq2.onload = function() {
                    bidders = JSON.parse(this.responseText).aaData;
                };
                oReq2.open("get", "PhpScripts/ViewBidders.php", true);
                oReq2.send();
            });

            function deleteBid() {
                var auctionId = document.getElementById("auctionID").value;
                var bidderId = table.rows('.selected').data()[0].BidderId;
                console.log(auctionId);
                console.log(bidderId);
                if (confirm("Are you sure you want to delete the selected bid?")) {
                        $.ajax ( {
                            type: "POST",
                            url: "phpScripts/DeleteBid.php",
                            data: {auctionId: auctionId, bidderId: bidderId },
                            success: function(data) {
                                console.log(data);
                                $('#myDataTable').DataTable().ajax.reload();
                            }
                        });
                    }
            }

            function searchDescriptions(filterText, type) {
                if (filterText == "") {
                    closeDropdown(type);
                }
                else {
                    var possible = [];
                    var id = "description" + type;
                    var drop = document.getElementById(id);
                    while (drop.firstChild) {
                        drop.removeChild(drop.firstChild);
                    }
                    filterText = filterText.toLowerCase();
                    var arr = type == "Item" ? 
                        items.filter(function (item) {
                            return item.auctionId != null;
                         }) : 
                         bidders;
                    for (var i = 0; i < arr.length; i++) {
                        if (type == "Item") {
                            var description = arr[i].description.toLowerCase();
                            if (description.indexOf(filterText) !== -1) {
                                possible.push(arr[i]);
                                var el = document.createElement("div");
                                el.textContent = arr[i].description;
                                el.value = arr[i].auctionId;
                                el.onclick = function() { 
                                    changeValue(this.value, type, this.textContent); 
                                    closeDropdown(type);
                                }
                                el.classList.add("dropdown");
                                drop.appendChild(el);
                            }
                        }
                        else {
                            var name = arr[i].Name;
                            if (name && name.toLowerCase().indexOf(filterText) !== -1) {
                                possible.push(arr[i]);
                                var el = document.createElement("div");
                                el.textContent = arr[i].Name;
                                el.value = arr[i].BidderId;
                                el.onclick = function() { 
                                    changeValue(this.value, type, this.textContent); 
                                    closeDropdown(type);
                                }
                                el.classList.add("dropdown");
                                drop.appendChild(el);
                            }
                        }
                    }
                }
            }

            function closeDropdown(type) {
                var id = "description" + type;
                var drop = document.getElementById(id);
                while (drop.firstChild) {
                    drop.removeChild(drop.firstChild);
                }
            }

            function changeValue(value, type, name="") {
                if (type == "Item") {
                    if(document.getElementById("auctionID")) {
                        document.getElementById("auctionID").value = value;
                        document.getElementById("searchTextItem").value = name;
                        doesAuctionIdExist(value, type);
                    }
                } 
                else if (type == "Bidder") {
                    if(document.getElementById("bidderID")) {
                        document.getElementById("bidderID").value = value;
                        document.getElementById("searchTextBidder").value = name;
                        doesAuctionIdExist(value, type);
                    }
                }

            }

            function getBidderName(id) {
                bidders.forEach((bidder) => {
                    if (bidder.BidderId == id) {
                        return bidder.Name;
                    }
                });
            }

            function doesAuctionIdExist(id, type) {
                if (type == "Item") {
                    for(var i = 0; i < items.length; i++) {
                    if (items[i].auctionId == id) {
                        itemValid = true;
                        itemSold = items[i].sold ? true : false;
                        $(".bidder-hist").removeClass("none");
                        table.draw();
                        if (items[i].winningbid) minBid = parseInt(items[i].winningbid) + 5;
                        else minBid = null;
                        document.getElementById("searchTextItem").value = items[i].description;
                        return manipulateHtml(true, "Item");
                    }
                }
                    itemValid = false;
                    $(".bidder-hist").addClass("none")
                    return manipulateHtml(false, type);
                }
                else if (type == "Bidder") {
                    for(var i = 0; i < bidders.length; i++) {
                        if (bidders[i].BidderId == id) {
                            userValid = true;
                            document.getElementById("searchTextBidder").value = bidders[i].Name;
                            return manipulateHtml(true, "Bidder");
                        }   
                    }
                    userValid = false;
                    return manipulateHtml(false, type)
                }
            }
            function manipulateHtml(valid, type) {
                var errorMessage = type === "Item" ? "auctionError" : "bidderError";
                if (valid) {
                    hideOrShowElement("hide", errorMessage);
                    if (userValid && itemValid && bidValid && !itemSold) {
                        hideOrShowElement("show", "enabled");
                        hideOrShowElement("hide", "disabled");
                    }
                }
                else {
                    hideOrShowElement("show", errorMessage);
                    hideOrShowElement("hide", "enabled");
                    hideOrShowElement("show", "disabled");
                }
                return;
            }

            function hideOrShowElement(hideOrShow, element) {
                if (hideOrShow == "hide") {
                    if (document.getElementById(element).classList.contains('block')) {
                        document.getElementById(element).classList.toggle('block');
                    }
                    document.getElementById(element).classList.add('none');
                }
                if (hideOrShow == "show") {
                    if (document.getElementById(element).classList.contains('none')) {
                        document.getElementById(element).classList.toggle('none');
                    }
                    document.getElementById(element).classList.add('block');
                }
            }

            function checkBid(bid) {
                if (minBid == null) minBid = 5;
                if (bid >= minBid) {
                    hideOrShowElement("hide", "minBidError");
                    if (bid % 5 == 0) {
                        bidValid = true;
                        hideOrShowElement("hide", "multipleOfFiveError")
                        if (userValid && itemValid) {
                            hideOrShowElement("show", "enabled");
                            hideOrShowElement("hide", "disabled");
                        }
                    }
                    else {
                        bidValid = false;
                        hideOrShowElement("show", "multipleOfFiveError")
                        hideOrShowElement("hide", "enabled");
                        hideOrShowElement("show", "disabled");
                    }
                } 
                else {
                    bidValid = false;
                    document.getElementById("minBidError").textContent = "Bid must be at least $" + minBid.toString();
                    hideOrShowElement("show", "minBidError");
                    hideOrShowElement("hide", "enabled");
                    hideOrShowElement("show", "disabled"); 
                }
            }

        </script> 
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    
        <?php include "PhpScripts/Templates/Nav.php";?>


         <div class="container body-content">
            <div class="forty">
                <form class="form-group" action="PhpScripts/AddBidDatabase.php" method="post">
                    <div class="form-group">
                        <label for="auctionID">Auction Number</label>
                        <input type="number" class="form-control" name="auctionID" id="auctionID"
                        onkeyup="doesAuctionIdExist(document.getElementById('auctionID').value, 'Item')">
                    </div>
                    <div class="form-group">
                        <label for="bidderID">Bidder ID</label>
                        <input type="number" class="form-control" name="bidderID" id="bidderID"
                        onkeyup="doesAuctionIdExist(document.getElementById('bidderID').value, 'Bidder')">
                    </div>
                    <div class="form-group">
                        <label for="amount">Bid Amount</label>
                        <input onkeyup="checkBid(document.getElementById('amount').value)" type="number" class="form-control" name="amount" id="amount">
                    </div>
                    <button id="disabled" disabled type="submit" class="btn btn-primary">Submit</button>
                    <button id="enabled" type="submit" class="btn none btn-primary">Submit</button>
                    <div class="error none" id="auctionError">That Auction Number does not exist</div>
                    <div class="error none" id="bidderError">That Bidder Number does not exist</div>
                    <div class="error none" id="minBidError"></div>
                    <div class="error none" id="multipleOfFiveError">Bids must be multiples of 5</div>
                </form>
            </div>

            <div class="forty description-search">
                <div>Search By Auction Description<div>
                <input type="text" placeholder="Search..." class="form-control drop" id="searchTextItem" 
                onkeyup="searchDescriptions(document.getElementById('searchTextItem').value, 'Item')">
                <div id="descriptionItem"></div>

                <div style="margin-top: 1rem">Search By Bidder Name<div>
                <input type="text" placeholder="Search..." class="form-control drop" id="searchTextBidder" 
                onkeyup="searchDescriptions(document.getElementById('searchTextBidder').value, 'Bidder')">
                <div id="descriptionBidder"></div>
            </div>
            <div class="container bidder-hist none" col-md-12>
            <h3>Bid History</h3>
            <table id="myDataTable"  class="stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td></td>
                        <td class="first head">BidderId</td>
                        <td class="head">Bid Amount</td>
                        <td class="last head">Winning</td>
                    </tr>
                </thead>
            </table>
            <button type="button" onclick="deleteBid()" class="btn btn-danger">Delete</button>
            </div>
        </div>
        
        <!-- <div>
            <table style="width:20%">
                <tr>
                    <th>Item Number</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <th>600</th>
                    <th>Cake Slices</th>
                </tr>
                <tr>
                    <th>601</th>
                    <th>Whole Cake</th>
                </tr>
                <tr>
                    <th>602</th>
                    <th>Ducks</th>
                </tr>
                <tr>
                    <th>603</th>
                    <th>Button Type 1</th>
                </tr>
                <tr>
                    <th>604</th>
                    <th>Button Type 2</th>
                </tr>
            </table>
        </div> -->
    </body>
</html>

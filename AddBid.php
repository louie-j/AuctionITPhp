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
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <script type="text/javascript">
            var items;
            var bidders;
            var userValid = false;
            var itemValid = false;
            $( document ).ready(function() {

                if(<?php echo $_SESSION['databaseSuccess'] ?> === 1)
                {
                    alert("Bid Added");
                    <?php $_SESSION['databaseSuccess'] = 0; ?>
                }
                else if(<?php echo $_SESSION['databaseSuccess'] ?> == 2)
                {
                    alert("Error adding Bid to Database");
                    <?php $_SESSION['databaseSuccess'] = 0; ?>
                }


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
                    var arr = type == "Item" ? items : bidders;
                    for (var i = 0; i < arr.length; i++) {
                        if (type == "Item") {
                            var description = arr[i].description.toLowerCase();
                            if (description.indexOf(filterText) !== -1) {
                                possible.push(arr[i]);
                                var el = document.createElement("div");
                                el.textContent = arr[i].description;
                                el.value = arr[i].auctionId;
                                el.onclick = function() { 
                                    changeValue(this.value, type); 
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
                                    changeValue(this.value, type); 
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

            function changeValue(value, type) {
                if (type == "Item") {
                    if(document.getElementById("auctionID")) {
                        document.getElementById("auctionID").value = value;
                        document.getElementById("searchTextItem").value = "";
                        doesAuctionIdExist(value, type);
                    }
                } 
                else if (type == "Bidder") {
                    if(document.getElementById("bidderID")) {
                        document.getElementById("bidderID").value = value;
                        document.getElementById("searchTextBidder").value = "";
                        doesAuctionIdExist(value, type);
                    }
                }

            };

            function doesAuctionIdExist(id, type) {
                if (type == "Item") {
                    for(var i = 0; i < items.length; i++) {
                    if (items[i].auctionId == id) {
                        itemValid = true;
                        return manipulateHtml(true, "Item");
                    }
                }
                    itemValid = false;
                    return manipulateHtml(false, type);
                }
                else if (type == "Bidder") {
                    for(var i = 0; i < bidders.length; i++) {
                        if (bidders[i].BidderId == id) {
                            userValid = true;
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
                    if (userValid && itemValid) {
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

        </script>
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
                        <input type="number" class="form-control" name="amount" id="amount">
                    </div>
                    <button id="disabled" disabled type="submit" class="btn btn-primary">Submit</button>
                    <button id="enabled" type="submit" class="btn none btn-primary">Submit</button>
                    <div class="error none" id="auctionError">That Auction Number does not exist</div>
                    <div class="error none" id="bidderError">That Bidder Number does not exist</div>
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

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
            });


            function searchDescriptions(filterText) {
                if (filterText == "") {
                    closeDropdown();
                }
                else {
                    var possible = [];
                    var drop = document.getElementById("description");
                    while (drop.firstChild) {
                        drop.removeChild(drop.firstChild);
                    }
                    filterText = filterText.toLowerCase();
                    for (var i = 0; i < items.length; i++) {
                        var description = items[i].description.toLowerCase();
                        if (description.indexOf(filterText) !== -1) {
                            possible.push(items[i]);
                            var el = document.createElement("div");
                            el.textContent = items[i].description;
                            el.value = items[i].auctionId;
                            el.onclick = function() { 
                                changeValue(this.value); 
                                closeDropdown();
                            }
                            el.classList.add("dropdown");
                            drop.appendChild(el);
                        }
                    }
                }

            }

            function closeDropdown(){
                var drop = document.getElementById("description");
                while (drop.firstChild) {
                    drop.removeChild(drop.firstChild);
                }
            }

            function changeValue(value) {
                if(document.getElementById("auctionID")) {
                    document.getElementById("auctionID").value = value;
                    document.getElementById("searchText").value = "";
                    doesAuctionIdExist(value);
                }
            };

            function doesAuctionIdExist(id) {
                for(var i = 0; i < items.length; i++) {
                    if (items[i].auctionId == id) {
                        return manipulateHtml(true);
                    }
                }
                return manipulateHtml(false);
            }

            function manipulateHtml(valid) {
                if (valid) {
                    hideOrShowElement("hide", "auctionError");
                    hideOrShowElement("show", "enabled");
                    hideOrShowElement("hide", "disabled");
                }
                else {
                    hideOrShowElement("show", "auctionError");
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
                        onkeyup="doesAuctionIdExist(document.getElementById('auctionID').value)">
                    </div>
                    <div class="form-group">
                        <label for="bidderID">Bidder ID</label>
                        <input type="number" class="form-control" name="bidderID" id="bidderID">
                    </div>
                    <div class="form-group">
                        <label for="amount">Bid Amount</label>
                        <input type="number" class="form-control" name="amount" id="amount">
                    </div>
                    <button id="disabled" disabled type="submit" class="btn btn-primary">Submit</button>
                    <button id="enabled" type="submit" class="btn none btn-primary">Submit</button>
                    <div class="error none" id="auctionError">That Auction Number does not exist</div>
                </form>
            </div>
            <div class="forty description-search">
                <div>Search By Description<div>
                <input type="text" placeholder="Search..." class="form-control drop" id="searchText" 
                onkeyup="searchDescriptions(document.getElementById('searchText').value)">
                <div id="description"></div>
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

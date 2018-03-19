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
        ?>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <script src="DataTables/datatables.min.js"></script>
        <script type="text/javascript">
            var interval;
            $( document ).ready(function() {
                
                var table = $('#myDataTable').DataTable( {
                    "ajax": "phpScripts/ViewItemTable.php",
                    "bPaginate":true,
                    "bProcessing": true,
                    "columns": [
                        { mData: 'auctionId', "searchable": true } ,
                        { mData: 'description', "searchable": false },
                        { mData: 'donatedBy', "searchable": false },
                        { mData: 'value', "searchable": false},                        
                        // { mData: 'CurrentWinningBidder', "searchable": false},
                        // { mData: 'CurrentWinningBid', "searchable": false}
                    ]
                });
                setInterval( function () {
                    table.ajax.reload(null, false);
                }, 10000 );
            });
            function changePagesAutomatically()
            {
                var table = $('#myDataTable').DataTable();
                if(interval)
                {
                    clearInterval(interval);
                    interval = null;
                }
                else
                {
                    interval = setInterval( function () {
                        var info = table.page.info();
                        var pageNum = (info.page < info.pages) ? info.page + 1 : 1;
                        table.page(pageNum).draw(false); 
                    }, 10000);                   
                }
            }
        </script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>

    </head>
    <body>
    <?php include "PhpScripts/Templates/Nav.php";?>
        <div class="container body-content">
            <input id="clickMe" type="button" class="btn-info" value="Start/Stop Rotating Through Pages" onclick="changePagesAutomatically();" />
            <table id="myDataTable"  class="stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td>ItemId</td>
                        <td>Description</td>
                        <td>Donated By</td>
                        <td>Value</td>
                        <td>Winning Bidder</td>
                        <td>Winning Bid</td>
                    </tr>
                </thead>
            </table>
        </div>
    </body>
</html>

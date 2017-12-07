        <?php
            ob_start();
            session_start();
            if($_SESSION["accountType"] != 'user' && $_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
        ?>
<html>
    <head>

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
                        { mData: 'ItemId', "searchable": true } ,
                        { mData: 'Description', "searchable": false },
                        { mData: 'DonatedBy', "searchable": false },
                        { mData: 'Value', "searchable": false},
                        { mData: 'CurrentWinningBidder', "searchable": false},
                        { mData: 'CurrentWinningBid', "searchable": false}
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
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <nav class="navbar navbar-inverse bg-inverse">
            <div class="container">
                <div class="navbar-header">
                    <button style="background-color: #292b2c;"type="button" class="navbar-inverse-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <a class="navbar-brand" href="Index.php">AuctionIT</a>
                    </button>
                    <?php if ($_SESSION["accountType"] != 'guest'): ?>
                        <form style="float: right;"action="PhpScripts/Logout.php">
                            <input type="submit" class="btn btn-primary" value="Logout" />
                        </form>
                    <?php endif;?>
                </div>
                <?php if ($_SESSION["accountType"] != 'guest'): ?>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a class="nav-link" href="index.php"><h4>Home</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="AddItem.php"><h4>Add an Item</h4></a>
                        </li>
                    <?php if ($_SESSION["accountType"] == 'admin'): ?>
                        <li>
                            <a class="nav-link" href="FindItem.php"><h4>Edit an Item</h4></a>
                        </li>
                    <?php endif; ?>
                        <li>
                            <a class="nav-link" href="ViewAllItems.php"><h4>View Items</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="Reports.php"><h4>Reports</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="AddBid.php"><h4>Add Bid</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="RegisterBidder.php"><h4>Bidder Registration</h4></a>
                        </li>
                    <?php if ($_SESSION["accountType"] == 'admin'): ?>
                        <li>
                            <a class="nav-link" href="AdminPage.php"><h4>Administrator Tools</h4></a>
                        </li>
                    <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>
        </nav>
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

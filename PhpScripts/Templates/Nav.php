<link href="css/customStyles.css" text="text/css" rel="stylesheet">
<nav class="navbar navbar-inverse bg-inverse">
            <div class="container">
                <div class="navbar-header">
                    <span class="header" href="index.php" data-toggle="collapse" data-target=".navbar-collapse">
                        <span>
                            <span>AuctionIT</span>
                            <span class="chevron">></span>
                        </span>
                        <span class="page-name">
                            <?php 
                                switch(basename($_SERVER['PHP_SELF'])) {
                                    case("ViewAllItems.php"):
                                        echo("View All Items");
                                        break;
                                    case("AddBid.php"):
                                        echo("Add Bid");
                                        break;
                                    case("AdminPage.php"):
                                        echo("User Management");
                                        break;
                                    case("EditItem.php"):
                                        echo("Edit Item");
                                        break;
                                    case("PhpScripts/FindItem.php"):
                                        echo("Find Item");
                                        break;
                                    case("Reports.php"):
                                        echo("Reports");
                                        break;
                                    case("RegisterBidder.php"):
                                        echo("Register Bidder");
                                        break;
                                    case("AddItem.php"):
                                        echo("Add Item");
                                        break;
                                    case("index.php"):
                                        echo("Log In");
                                        break;
                                    case("AccountEditor.php"):
                                        echo("Account Editor");
                                    break;
                                    default:
                                        echo(basename($_SERVER['PHP_SELF']));
                                        break;
                                        
                                } 
                            ?>
                        </span>
                    </span>
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
                            <a class="nav-link" href="AdminPage.php"><h4>User Management</h4></a>
                        </li>
                    <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>
        </nav>
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
                                    case("ItemManagement.php"):
                                        echo("Item Management");
                                        break;
                                    case("Reports.php"):
                                        echo("Reports");
                                        break;
                                    case("bidderManagement.php"):
                                        echo("Bidder Management");
                                        break;
                                    case("index.php"):
                                        echo("Log In");
                                        break;
                                    case("AccountEditor.php"):
                                        echo("Account Editor");
                                        break;
                                    case("BuyNow.php"):
                                        echo("Buy Now");
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
                            <a class="nav-link" href="ViewAllItems.php"><h4>View Items</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="AddBid.php"><h4>Add Bid</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="BuyNow.php"><h4>Buy Now</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="Reports.php"><h4>Reports</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="ItemManagement.php"><h4>Item Management</h4></a>
                        </li>
                        <li>
                            <a class="nav-link" href="bidderManagement.php"><h4>Bidder Management</h4></a>
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
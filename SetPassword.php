
<?php
    ob_start();
    session_start();
?>
<html>
    <head>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <script type="text/javascript">
            $( document ).ready(function() {
                if(<?php echo $_SESSION['databaseSuccess'] ?> === 2)
                {
                    alert("Password was not the same as the confirmation");
                    <?php $_SESSION['databaseSuccess'] = 0 ?>
                }
            });
        </script>
        <title></title>
    </head>
    <body>
        <div class="navbar navbar-inverse bg-inverse">
            <div clas="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">AuctionIT</a>
                </div>
            </div>
        </div>
        <div class="container body-content">
            <form class="form-group" action="PhpScripts/SetPasswordDatabase.php" onsubmit=""  method="post">
                <div class="form-group">
                    <label for="userName">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="description">Confirm Password</label>
                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </body>
</html>

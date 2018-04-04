         <?php
            session_start();
            if($_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
        ?>

        <script type="text/javascript">
        // var radioStatusActive = document.getElementById("statusARadioBtn");
        // radioStatusActive.addEventListener("click", updateRadioBtns());

            function intialializeRadioBtns() 
            {
                document.getElementById("statusARadioBtn").checked = true;
                var status =  $('#UserManagementBody').data( 'status');
                var accType =  $('#UserManagementBody').data( 'accType');
            }

            //Radio button action buttons
            function clickActive() {document.getElementById("statusInARadioBtn").checked = false;}
            function clickInActive() {document.getElementById("statusARadioBtn").checked = false;}
            function clickAdmin(){document.getElementById("type2RadioBtn").checked = false;}
            function clickRegular(){document.getElementById("type1RadioBtn").checked = false}

            function update(){}

        </script>


    <div id = "tease">
        <?php include "PhpScripts/Templates/Nav.php";?>
        
        <form id = "radioBtnForm" action="" >
        <label>Status</label><br>
            <input onclick="clickActive()" id = "statusARadioBtn" type="radio" name="statusA" value="Active"> Active<br>
            <input onclick="clickInActive()" id = "statusInARadioBtn" type="radio" name="statusInA" value="Inactive"> Inactive<br>

            <label>Type of User</label><br>
            <input onclick="clickAdmin()" id = "type1RadioBtn" type="radio" name="type1" value="Admin"> Admin <br>
            <input onclick="clickRegular()" id = "type2RadioBtn" type="radio" name="type2" value="Regular"> Regular <br>
        </form>

          <form action="">
            <label>New Password</label><br>
            <input id = "newPasswordText" type="text" name="New Password">
  
        </form>

          <form action="">
            <button onclick="location.href = 'AdminPage.php';" id = "updateButton" type="button">Update</button>
            <button onclick="location.href = 'AdminPage.php';" id = "deleteButton" type="button">Delete</button>
            <button onclick="location.href = 'AdminPage.php';" id = "cancelButton" type="button">Cancel</button>
        </form>
        
        

    </div>

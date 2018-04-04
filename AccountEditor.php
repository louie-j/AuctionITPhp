

     

         <?php
            session_start();
            if($_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
        ?>

        <script type="text/javascript">
        
        function intialializeRadioBtns() 
            {
                alert( "Satans testicle");

                document.getElementById("statusARadioBtn").checked = true;
                var status =  $('#UserManagementBody').data( 'status');
                var accType =  $('#UserManagementBody').data( 'accType');
                alert( "test" + status + accType);
            }
          
        </script>


    <div id = "tease">
        <?php include "PhpScripts/Templates/Nav.php";?>
        
        <form id = "radioBtnForm" action="" >
            <input id = "statusARadioBtn" type="radio" name="statusA" value="Active"> Active<br>
            <input id = "statusInARadioBtn" type="radio" name="statusInA" value="Inactive"> Inactive<br>

            <input id = "type1RadioBtn" type="radio" name="type1" value="Admin"> Admin <br>
            <input id = "type2RadioBtn" type="radio" name="type2" value="Pleb"> Pleb <br>
        </form>

          <form action="">
            <label>New Password</label><br>
            <input id = "newPasswordText" type="text" name="New Password">
  
        </form>

          <form action="">
            <button id = "updateButton" type="button">Update</button>
            <button id = "deleteButton" type="button">Delete</button>
            <button id = "cancelButton" type="button">Cancel</button>
        </form>
        
        

    </div>

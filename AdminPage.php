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
            if($_SESSION["accountType"] != 'admin')
            {
                header('Location: index.php'); 
            }
        ?>
		<script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src ="js/bootstrap.min.js"></script>
        <script src="DataTables/datatables.min.js"></script>
        <script type="text/javascript">           
        
            $( document ).ready(function()
            {
                var table = $('#myDataTable').DataTable( {
                    "ajax": "phpScripts/viewAccountsTable.php", 
                    "bPaginate":true,
                    "bProcessing": true,
                    "columns": [
                        { mData: 'Username', "searchable": true } ,
                        { mData: 'Active', "searchable": false },
                        { mData: 'Type', "searchable": false },
  
                        {  "targets": -1,
                            "data": null,
                            "orderable":false,
                            "className": "editButton",
                            "defaultContent": "<button>Edit</button>"}
                    ],
                    "columnDefs": [
                        {
                            "render": function(data,type,row) {
                                 return data == 1 ? 'Active' : 'Inactive';
                            },
                            "targets":1
                        },
                        {
                            "render": function(data,type,row) {
                                 return data == 0 ? 'User' : 'Admin';
                            },
                            "targets":2
                        }
                    ]
                    
                } );

                //Function that responds to user clicking edit button
                $('#myDataTable tbody').on( 'click', 'button', function () {

                    //Get the data from the selected row
                    var dataObj = table.row( $(this).parents('td') ).data();
                    var data    = Object.values(dataObj);
                    var AccID   = data[0];
                    var TypeValue   = data[3];
                    var activeValue = data[4];

                    //alert("deez nuts");
                    var modal = document.getElementById('myModal');
                    modal.style.display = "block";
                    var accountLabel = document.getElementById('accountLabel');
                    accountLabel.value = AccID;

                    if (activeValue == 1)
                        document.getElementById("statusARadioBtn").checked = true;
                    else
                        document.getElementById("statusInARadioBtn").checked = true;
                    if(TypeValue == 1)
                        document.getElementById("typeAdminRadioBtn").checked = true;
                    else   
                        document.getElementById("typeRegRadioBtn").checked = true;
                
                    } );    
               

                    setInterval( function () {
                    table.ajax.reload(null, false);
                }, 10000 );
            });
            var interval;

            function changePagesAutomatically()
            {
                var table = $('#myDataTable').DataTable();
                if(interval)
                {
                    document.getElementById("start").value = "Start Rotating Pages";
                    clearInterval(interval);
                    interval = null;
                }
                else
                {
                    document.getElementById("start").value = "Stop Rotating Pages";
                    interval = setInterval( function () {
                        var info = table.page.info();
                        var pageNum = (info.page < info.pages) ? info.page + 1 : 1;
                        table.page(pageNum).draw(false); 
                    }, 10000);                   
                }
            }

            function validate()
                {
                    var error="";
                    var activeBtn     = document.getElementById( "statusARadioBtn" );
                    var inActiveBtn   = document.getElementById( "statusInARadioBtn" );
                    var adminBtn      = document.getElementById( "type1RadioBtn" );
                    var regUserBtn    = document.getElementById( "type2RadioBtn" );

                    if( activeBtn.value === false && inActiveBtn.value === false)
                    {
                        error = "You have not selected user activity.";
                        document.getElementById( "error_para" ).innerHTML = error;
                        return false;
                    }
                    var description = document.getElementById( "description" );
                    if( adminBtn.value === false && regUserBtn.value === false )
                    {
                        error = "You have not selected user type.";
                        document.getElementById( "error_para" ).innerHTML = error;
                        return false;
                    }

                    else
                    {
                        return true;
                    }
                }

            //Radio button action buttons
            function clickActive() {document.getElementById("statusInARadioBtn").checked = false;}
            function clickInActive() {document.getElementById("statusARadioBtn").checked = false;}
            function clickAdmin(){document.getElementById("typeRegRadioBtn").checked = false;}
            function clickRegular(){document.getElementById("typeAdminRadioBtn").checked = false}

		</script>
		<link href="css/bootstrap.min.css" text="text/css" rel="stylesheet">
        <link href="css/customStyles.css" text="text/css" rel="stylesheet">
        <link href="DataTables/datatables.min.css" text="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body id="UserManagementBody">
    <?php include "PhpScripts/Templates/Nav.php";?>
        
		<div class="container body-content top">
            <table id="myDataTable"  class="stripe" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <td class="first head">Username</td>
                        <td class="head">State</td>
                        <td class="head">User Type</td>
                        <td class="last head">Edit</td>
                    </tr>
                </thead>
            </table>
        <input id="start" type="button" class="center btn-info" value="Start Rotating Through Pages" onclick="changePagesAutomatically();" />
    
    <!--
    Html for the modal view
    -->
    <div id="myModal" class="modal">      
            
            <div class="modal-content page">
                    <form class="form-group" action="PhpScripts/EditUser.php" method="post">
                        <span class="name"></span>
                        <div id = "radioBtns" class="form-group">

                        <label for "accountLabel">Account Number</label>
                        <input type="text" class="form-control" name="autoId" id="accountLabel" value="" readonly>

                        <label>Status</label><br>
                            <input onclick="clickActive()"   id = "statusARadioBtn"      type="radio" name="active"> Active<br> 
                            <input onclick="clickInActive()" id = "statusInARadioBtn"    type="radio" name="inActive"> Inactive<br>
                        <label>Type of User</label><br>
                            <input onclick="clickAdmin()"    id = "typeAdminRadioBtn"    type="radio" name="typeAdmin"      value = false  > Admin <br>
                            <input onclick="clickRegular()"  id = "typeRegRadioBtn"      type="radio" name="typeRegular"> Regular <br>
                        </div>

                        <div class="form-group">
                            <label for="newPassword">New Password</label><br>
                            <input id="newPasswordText" class="form-control" type="text" name="newPassword">
                        </div>

                        <div class="form-group">
                                <button class="btn btn-primary" id = "updateButton" type="submit">Update</button>
                                <button onclick="location.href = 'AdminPage.php';" class="btn btn-primary" id = "cancelButton" type="button">Cancel</button>
                        </div>
                    </form>
                    <p id="error_para" ></p>
                    
            </div>
    </div>  
   
    </body>
</html>


<!DOCTYPE html>
<html>
<head>
        
<title>Candidates | OCES </title>
    
    <?php 
        require_once('top.php');
    ?>

    	<!-- A hidden input field , For taking base URL value to javascript variable -->
        <input type="hidden" value="<?php echo base_url();?>" id="base_url">

        

    
</head>
<body>

<div class="modal fade" id="publishModal" role="dialog">
            <div class="modal-dialog">
        
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Dept</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                
                <div class="modal-body">
                  <form id="publishResultForm" onsubmit="return false">
                      <!-- Email ID<input type="email" name="email_id" required class="form-control"><br> -->
                            <input type="hidden" name="hidID" id="hidID" value="0" required  class="form-control">
                            Admin Password<input type="text" name="adminPass" id="adminPass" required  class="form-control">    
                            
                  <div id="errorMsg" class="errorMsg">
                       <!-- to print error message in UI  -->
                  </div>

                </div>

                <div class="modal-footer">
                   
                  </form>  
                  <button type="button" class="btn btn-success" id="btnPublish" onclick="adminVal();"> Publish</button>
                </div>
              </div>
              
            </div>
          </div>
        
    <?php
        require_once('header.php');
     ?>
        <!-- ------------------------------------------------------------------------------------ -->
        <section id="main-bg">

        
        
            <div class="table_div">
            <button class="btn btn-success addbtn" onclick="publishResult();">Publish Result</button>
                <!-- <table width="600px" id="dataTable">
                    <thead>
                        <th>Settings</th>
                        <th>Value</th>
                    </thead>
                    <tbody>

                    <?php 

                        $servername="localhost";
                        $username="root";
                        $password="";
                        $dbname="oces";

                        //create connection
                        $dbcon=mysqli_connect($servername,$username,$password,$dbname);

                        $sql = "SELECT * FROM settings";
                        $result = mysqli_query($dbcon, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr><td> TIme </td><td>".$row["time"]."</td></tr>
                                      <tr><td> Date</td><td>".$row["date"]."</td></tr>";
                            }
                        }

                        ?>
                    </tbody>
                    
                    <tfoot>
                        <th>Setting</th>
                        <th>Value</th> -->
                        
                        <!-- <th>Actions</th> -->
                    </tfoot>
                </table>
            </div>
        </section>
        <!-- ------------------------------------------------------------------------------------ -->

        <footer>
            <p>O C E S &copy; 2018 </p>
        </footer>

        <script>
        
        function adminVal(){

            console.log("yhis works");
            var adminPass = document.querySelector('#adminPass').value;
            var login_data= $.ajax({
                url:BASE_URL+"Oces/adminValidate/" + adminPass,
                data:{
                    adminPass : $('#publishForm').val()},
                type:"post"
            });

            login_data.done(function(res){
                
                
                

            });

            login_data.fail(function(){
                        alert("Network Error");

            });

            }
        
        </script>
</body>
</html>
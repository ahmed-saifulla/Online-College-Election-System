<!DOCTYPE html>
<html>
<head>
    <title>Home | OCES </title>

    <?php 
        require_once('top.php');
    ?>

    	<!-- A hidden input field , For taking base URL value to javascript variable -->
        <input type="hidden" value="<?php echo base_url();?>" id="base_url">
    
</head>
<body>


    <?php
        require_once('header.php');
     ?>

      
    <div class="modal fade" id="voteModal" role="dialog">
            <div class="modal-dialog">
        
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Voter Login</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                <div class="modal-body">
                
                      USN<input type="text" name="usn2" id="usn2" required class="form-control">
                      <button  class="btn btn-success" id="otpBtn" > Send OTP </button><br>
                      OTP<input type="text" name="otp2"  id="otp2"  required  class="form-control">
                    

                  <div id="errorMsg" class="errorMsg">
                       <!-- to print error message in UI  -->
                  </div>

                </div>

                <div class="modal-footer">
                  <button  class="btn btn-success" id="btnOTPsubmit" > Submit </button>
                
                    
                </div>
              </div>
              
            </div>
          </div>

        

        
        <!-- ------------------------------------------------------------------------------------ -->
        <section id="rules-sec">
            <div>
                <h3>Rule and Regs to be followed</h3>
                <!-- <ul>
                    <li>
                        Voters should Complete voting in 5 minutes.
                    </li>
                    <li>
                        Do not refresh the page while voting.
                    </li>
                    <li>
                        Do not share your OTP with others. 
                    </li>
                </ul> -->
                <?php 

                    $servername="localhost";
                    $username="root";
                    $password="";
                    $dbname="oces";

                    //create connection
                    $dbcon=mysqli_connect($servername,$username,$password,$dbname);
                    
                    $sql = "SELECT * FROM rules";
                    $result = mysqli_query($dbcon, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<li>".$row["rule"]."</li>";
                        }
                    }




                    ?>

                    <p> <br> <button class="btn btn-success" id="voteNow-btn"data-toggle="modal"  data-target="#voteModal"> Vote Now </button> </p>

            </div>

            <div>
                
            </div>
            
        </section>
        

        <!-- ------------------------------------------------------------------------------------ -->

       <footer>
            <p>O C E S &copy; 2018 </p>
        </footer>
        
</body>
</html>
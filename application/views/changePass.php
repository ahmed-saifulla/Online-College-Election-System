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
        
        <!-- Main Banner START-->
        <section id="main-bg">

        <div class="row">
            <div class="col-md-4"> 
            
            </div>

            <div class="col-md-3"> 
                <form action="" method="POST" id="changePassForm">
                <br>
                    <input placeholder="User ID " type="text" name="userId" class="form-control"><br>
                    <input  placeholder="New Password " type="text" name="newPass" class="form-control"><br>
                    <input  placeholder="Confirm New Password "  name="newPassConfirm"  type="text" class="form-control"><br>
                    <input type="text"  placeholder="Admin Password "  name="adminPass"  class="form-control"><br>
                 
                
                </form>

                <input type="submit" class="btn btn-danger" value="Change" id="changePass">
            </div>

            <div class="col-md-4"> 
            
            </div>
        </div>
        </section>
        <!-- Main Banner E N D -->

        
        


        <!-- ------------------------------------------------------------------------------------ -->

        <footer>
            <p>A Shabaka Product &copy; 2018 </p>
        </footer>

        
</body>
</html>
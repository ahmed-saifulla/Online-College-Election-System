<!DOCTYPE html>
<html>
<head>
    
    <title>Home | OCES </title>
    
    <?php 
        require_once('top.php');
    ?>
        <style> 
        h3,p{
            color:white;
            /* text-align:center; */
            margin-left:100px;
        }

        #h31{
            padding-top:200px;
        }
        </style>
    	<!-- A hidden input field , For taking base URL value to javascript variable -->
        <input type="hidden" value="<?php echo base_url();?>" id="base_url">
      
</head>
<body>

    <?php
        require_once('header.php');
     ?>
        
        <!-- Main Banner START-->
        <section id="main-bg">
            <h3 id="h31">P. A. College Of Engineering</h3>
            <p >Nadupadav, Montepadav Post, Mangalore - 574153</p>
            <h3>Online College Election System </h3>
            <p>modern  -  fast  -  reliable</p>
            <p> <a class="btn btn-success" href="<?php echo base_url();?>/Oces/rules"> Vote Now </a> </p>
        </section>
        <!-- Main Banner E N D -->

        
        </div>

        <footer>
            <p>O C E S &copy; 2018 </p>
        </footer>

        
</body>
</html>
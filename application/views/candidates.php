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
        
    <?php
        require_once('header.php');
     ?>
        <!-- ------------------------------------------------------------------------------------ -->
        <section id="main-bg">
            <div class="table_div ">
                <table width="600px" id="" class="candid_table">
                    <thead>
                        <th>USN</th>
                        <th>Name</th>
                        <th>Post</th>
                        <th>Dept</th>
                        <th>Sem</th>
                        
                    </thead>
                    <tbody>

                    <?php 

                    $servername="localhost";
                    $username="root";
                    $password="";
                    $dbname="oces";

                    //create connection
                    $dbcon=mysqli_connect($servername,$username,$password,$dbname);
                    
                    $sql = "SELECT * FROM nominees WHERE status = 'Accept' ORDER BY post";
                    $result = mysqli_query($dbcon, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr><td>".$row["usn"]."</td><td>".$row["c_name"]."</td><td>".$row["post"]."</td><td>".$row["dept"]."</td><td>".$row["sem"]."</td></tr>";
                        }
                    }




                    ?>

                        
                    </tbody>
                    
                    <tfoot>
                        <th>USN</th>
                        <th>Name</th>
                        <th>Post</th>
                        <th>Dept</th>
                        <th>Sem</th>
                       
                    </tfoot>
                
                </table>

            </div>

        </section>
        

        <!-- ------------------------------------------------------------------------------------ -->

        <footer>
            <p>O C E S &copy; 2018 </p>
        </footer>
        
</body>
</html>
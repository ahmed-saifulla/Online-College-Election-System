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
            <div class="table_div">
                <table width="600px" id="dataTable">
                    <thead>
                        <th>USN</th>
                        <th>Name</th>
                        <th>D O B</th>
                        <th>Dept</th>
                        <th>Sem</th>
                        <th>E Mail</th>
                    </thead>
                    <tbody>

                        
                    </tbody>
                    
                    <tfoot>
                        <th>USN</th>
                        <th>Name</th>
                        <th>D O B</th>
                        <th>Dept</th>
                        <th>Sem</th>
                        <th>E Mail</th>
                    </tfoot>
                
                </table>

                <script type="text/javascript" src="<?php echo base_url();?>dataTables/jquery.datatables.js"></script>
                <script type="text/javascript" src="<?php echo base_url();?>dataTables/datatables.bootstrap4.js"></script>
                <script type="text/javascript">
                    var table;
                    var BASE_URL=$('#base_url').val();
                    $(document).ready(function(){

                    table=$('#dataTable').DataTable({ 

                            "processing": true, //Feature control the processing indicator.
                            "serverSide": true, //Feature control DataTables' server-side processing mode.
                            "ordering": true,
                            "searching": true,

                            "iDisplayLength" : 10,
                            // Load data for the table's content from an Ajax source
                            "ajax": {
                                "url": BASE_URL + "Oces/studentList", 
                                "type": "POST"
                            },

                            //Set column definition initialisation properties.
                        });
                    });

                    function edit_btn(id){
                        var xyz= $.ajax({
                            url:BASE_URL+"welcome/delete_id/"+id,
                            dataType:"json"
                        });

                        xyz.done(function (res){
                            alert(res.msg);
                            table.ajax.reload();
                        });

                        xyz.fail(function(){
                                    alert("Network Error");
                        
                        });
                    } 
                </script>
            </div>
        </section>
    
        <!-- ------------------------------------------------------------------------------------ -->

        <footer>
            <p>O C E S &copy; 2018 </p>
        </footer>
        
</body>
</html>
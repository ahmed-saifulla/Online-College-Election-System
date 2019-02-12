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

<div class="modal fade" id="editDeptModal" role="dialog">
            <div class="modal-dialog">
        
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Dept</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                
                <div class="modal-body">
                  <form id="editDeptForm" onsubmit="return false">
                      <!-- Email ID<input type="email" name="email_id" required class="form-control"><br> -->
                            <input type="hidden" name="hidID" id="hidID" value="0" required  class="form-control">
                            Dept Name<input type="text" name="deptName" id="deptName" required  class="form-control">    
                            
                  <div id="errorMsg" class="errorMsg">
                       <!-- to print error message in UI  -->
                  </div>

                </div>

                <div class="modal-footer">
                   
                  </form>  
                  <input type="button" class="btn btn-success" id="btnSaveDept" value="save">
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
            <button class="btn btn-success addbtn" onclick="addDept();">Add Department </button>
                <table width="600px" id="dataTable">
                    <thead>
                        <th>ID</th>
                        <th>Deparment</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                        
                    </tbody>
                    
                    <tfoot>
                        <th>ID</th>
                        <th>Deparment</th>
                        
                        <th>Actions</th>
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
                                "url": BASE_URL + "Oces/deptList", 
                                "type": "POST"
                            },

                            //Set column definition initialisation properties.
                        });
                    });

                    function delete_btn(id){
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
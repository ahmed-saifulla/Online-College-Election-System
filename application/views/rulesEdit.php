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

<div class="modal fade" id="editRuleModal" role="dialog">
            <div class="modal-dialog">
        
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Rule</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                
                <div class="modal-body">
                  <form id="editRuleForm" onsubmit="return false">
                      <!-- Email ID<input type="email" name="email_id" required class="form-control"><br> -->
                            <input type="hidden" name="hidID" id="hidID" value="0" required  class="form-control">
                            Rule<input type="text" name="rule" id="rule" required  class="form-control">    
                            
                  <div id="errorMsg" class="errorMsg">
                       <!-- to print error message in UI  -->
                  </div>

                </div>

                <div class="modal-footer">
                   
                  </form>  
                  <input type="button" class="btn btn-success" id="btnSaveRule" value="save">
                </div>
              </div>
              
            </div>
          </div>


    <?php   
        require_once('header.php');
     ?>
        
        <!-- Main Banner START-->
        <section id="main-bg">
            <div>
            

            <div class="table_div">
            <button class="btn btn-success addbtn" onclick="addRule();">Add a Rule </button>
                <table width="600px" id="dataTable">
                    <thead>
                        <th>ID</th>
                        <th>RULE</th>
                        <th>ACTION</th>
                    </thead>
                    <tbody>

                        
                    </tbody>
                    
                    <tfoot>
                        <th>ID</th>
                        <th>RULE</th>
                        <th>ACTION</th>
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
                                "url": BASE_URL + "Oces/rulesList", 
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
            </div>

        </section>
        <!-- Main Banner E N D -->

        
        


        <!-- ------------------------------------------------------------------------------------ -->

        <footer>
            <p>O C E S &copy; 2018 </p>
        </footer>

        
</body>
</html>
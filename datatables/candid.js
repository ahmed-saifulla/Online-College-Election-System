
var base_url = $("#hidBASE_URL").val(); // for delete after saving .
var controller =$("#hidAdminController").val();
//BASE_URL + "index.php/" + ADMIN_CONTROLLER +

var save_method; //for save method string

    //datatables
    table = $('#dataTable').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		 "ordering": true,
        "searching": true,
		
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "index.php/admin/candidsList", //<?php echo site_url('person/ajax_list')?>
            "type": "POST"
			
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
			
        },
		{ "targets": [1], "searchable": true, "orderable": false, "visible": true }, // Show Count column
		
        ],
		

    });
  
  //------------------------------------------- DATA VALIDATION AND SUBMIT ---------------------------------------------------------
  $("#btnSave").click(function(){
	  
	  
	
   var hasErrors = false;
	
	//------ removing all error borders ....
   $('#form input,#form select').each(function() {
          var $this = $(this);
          $($this).removeClass('error-border');
		  $( ".error" ).remove();
	
     });
   
	
	$('#form input,#form select').not('.optional').each(function() {
          var $this = $(this);
          if (!$this.val()) {
            hasErrors = true;
					
            $($this).addClass('error-border');
			$( "<div class='error'><span class='error'><i class='fa fa-hand-pointer-o' aria-hidden='true'></i> Error! Please fill up this field.</span></div>" ).insertAfter($this);
		
          }
     });
	 
	//----- validating email
	
	

	 if (hasErrors) {
		
		var errorMsg	 = '<button style="color:white;" type="button" class="close"  aria-hidden="true" onclick="$(\'.alert\').hide()"> &times; </button>';
                    errorMsg	+='<strong style="color:white;">Error ! Missing required fields.</strong>';
						
		$('#divError').show();
		$('#divError').html(errorMsg);
        //$btn.val('reset');
        
        // error msg alert closing in 2 sec.
        $("#divError").fadeTo(2000, 200).slideUp(500, function(){
				$(".alert").hide();
          });                       
        
        return false;
      }
	  
	 
	 
	//----------------- submitting the form data : AJAX POST ----------------
		save();
		
  }) // button save click ending	
  
  
  function reloadTable()
{
   
    table.ajax.reload(null,false); //reload datatable ajax 
}

  
  function save()
  {
	
		
		$(".alert").hide(); // hiding all the message alert.
		$('#btnSave').text('Saving...'); //change button text
		$('#btnSave').attr('disabled',true); //set button disable 

		
	    var url = base_url + "index.php/admin/saveCandid";
    

  // ajax adding data to database
  // FormData is using for ajax file uploading.
  
 if (typeof FormData == 'undefined')
  {
      alert("Oops,Your Browser Don't support FormData API! Use IE 10 or Above!");
      return false;
  }
  
         var formData = new FormData("#form");
		 
		 
		  var fileField = document.getElementById('userfile'); // getting the file field object.
          var fileField1 = document.getElementById('userfile1'); // getting the file field object.
          
         
         //checking file are a is hidden or not. this is only for add data.
         
         //if($("#hideWhenEdit").is(":visible")) 
       
         formData.append('userfile', fileField.files[0]); 
		 formData.append('userfile1', fileField1.files[0]); 
		 
		 
         formData.append('AdmissionNumber', $("#AdmissionNumber").val());
		 formData.append('FirstName', $("#FirstName").val());
		 formData.append('LastName', $("#LastName").val());
		 formData.append('Gender', $("#Gender").val());
		 formData.append('PostType', $("#PostType").val());
		 formData.append('PostName', $("#PostName").val());
		 formData.append('RegNo', $("#RegNo").val());
		 formData.append('DOB', $("#DOB").val());
		 formData.append('DepartmentName', $("#DepartmentName").val());
		 formData.append('Semester', $("#Semester").val());
		 formData.append('Guardian', $("#Guardian").val());
		 formData.append('Address', $("#Address").val());
		 formData.append('MobileNumber', $("#MobileNumber").val());
		 formData.append('Email', $("#Email").val());
		 formData.append('hidID', $("#hidID").val());
		 
		 
   // alert(formData);
    //return;
    $.ajax({
        url : url,
        type: "POST",
        data:  formData,
        dataType: "json",
        processData: false,
        contentType: false,
    	cache: false,
        enctype: 'multipart/form-data',
        success: function(res)
        {
			
			
                  // if false
          if(res.status== false)
		  {
				var errorMsg		= '<button style="color:white;" type="button" class="close"  aria-hidden="true" onclick="$(\'.alert\').hide()"> &times; </button>';
					errorMsg		+='<strong style="color:white;">' + res.msg +'</strong>';
					
				$('#divError').show();
				$('#divError').html(errorMsg);
				
				
                                //formUtils.clearForm();               
                                //reloadTable();
                               
								// For message alert closing in 2 sec.
			$("#divError").fadeTo(2000, 500).slideUp(500, function(){
				
				$(".alert").hide();
				//$("#form")[0].reset(); // reseting form
			
			});
							

							   $("#hidBASE_URL").val(base_url); // for delete after load table.
                                $("#hidAdminController").val("admin");
							    $('#btnSave').text('Save'); //change button text
                                $('#btnSave').attr('disabled',false); //set button enable 
						
								 $("#form")[0].reset(); // reseting form         
                
                
                
                                return false;
		
		  }
                  
                  
     
		if(res.status)
			{		
                var saveOrEdit ="saved";
                var EDIT_ID = $("#hidID").val();
				if(EDIT_ID>0)
                    var saveOrEdit ="edited";
			
			reloadTable();
			var msg		= '<button style="color:white;" type="button" class="close"  aria-hidden="true" onclick="$(\'.alert\').hide()"> &times; </button>';
				msg	+='<strong style="color:white;">Success! Data has been ' + saveOrEdit  + ' successfully!.</strong>';
				$('#divMessage').html(msg);
				$('#divMessage').show();
			$('#upload-file-info').html("");	
			$('#upload-file-info1').html("");
			// For message alert closing in 2 sec.
			$("#divMessage").fadeTo(2000, 500).slideUp(500, function(){
				
				$(".alert").hide();
				//$("#form")[0].reset(); // reseting form
			
			});
                
                if(EDIT_ID==0)
                    $("#form")[0].reset(); // reseting form         
                $("#hidBASE_URL").val(base_url); // for delete after load table.
                
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
			
		}	


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            var errorMsg		= '<button style="color:white;" type="button" class="close"  aria-hidden="true" onclick="$(\'.alert\').hide()"> &times; </button>';
			errorMsg	+='<strong style="color:white;">Error ! Error while saving data. Please check your internet connection</strong>';
						
			$('#divError').show();
			$('#divError').html(errorMsg);
				
			// For message alert closing in 2 sec.
			$("#divError").fadeTo(2000, 500).slideUp(500, function(){
				
				$("#divError").hide();
				
			});
            
            $('#btnSave').text('Save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
		
    }); // ajax end
			
			

	
  }
  
  
  function viewData(id)
{
 	
	var url = base_url + "admin/addCand/"  + id;
	window.location.href = url;
	
	
}

$(document).ready(function (){
	
	var viewId = $("#view_id").val();
	if(viewId>0)
		viewDetails(viewId); // this is for viewing the details.
	
	else
	{
			$("#title_head").html("Add Candidate");
			$("#userfile1").removeClass("optional");
			
			$("#hideWhenEdit").show();
			$("#hideWhenEdit1").show();
			
		
	}
	
	
	
	
});

 function viewDetails(id)
 {
	 
	 var url = base_url + "index.php/admin/viewCandidateData/"  + id;
	 
	 save_method = 'edit';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    
    // hiding image upload area when editing data.
    $('#hideWhenEdit').hide();
	
    //Ajax Load data from ajax
    $.ajax({
        url : url + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $("#id").val(data.Id);
			$("#hidID").val(data.Id);
			$("#AdmissionNumber").val(data.AdmissionNumber);
            
			$("#LastName").val(data.LastName);
			$("#FirstName").val(data.FirstName);
			$("#Gender").val(data.Gender);
			$("#PostType").val(data.PostType);
			$("#PostName").val(data.PostName);
			$("#RegNo").val(data.RegNo);
			$("#DOB").val(data.DOB);
			$("#DepartmentName").val(data.DepartmentName);
			$("#Semester").val(data.Semester);
			$("#Guardian").val(data.Guardian);
			$("#Address").val(data.Address);
			$("#MobileNumber").val(data.MobileNumber);
			$("#Email").val(data.Email);
			
			if(data.LastSemesterResult !=null && data.LastSemesterResult!="" )
			var pdfLink = base_url + "uploads/candidate_result/" + data.LastSemesterResult;
				pdfLink = " | <a href='" + pdfLink + "' target='_blank'>Show Semester Result</a>";
			
			var backLink = base_url +  "admin/candidList"; 	
				pdfLink += " | <a href ='" +  backLink + "'>Go back to list</a>";
				
			
				pdfLink += "<div class='row'>";
				pdfLink += "<div class='col-sm-8'>";
				pdfLink += " <form id='form1' name='form1' action=\"\" onsubmt='return false;'>";
				pdfLink += " <a href ='#'><br/><br/>";
				pdfLink += " <label class='btn btn-sm btn-primary btn-file'>Upload new result pdf file";
				pdfLink += " <input type='file' name='userfile2' id='userfile2' value='Upload new result pdf file'/>";
				pdfLink += "</label>";
				pdfLink += "</a>";
				pdfLink += "<button id='UploadPDF' onclick='uploadNewPDF();'>Upload</button>";
			    pdfLink += "<div id='divError1' class='error'></div>";
				pdfLink += "<div id='divMessage1' style='color:green!important;' id='divMessage1'></div>";
				
				pdfLink += "</form>";
				pdfLink += "</div>";
				pdfLink += "<div class='col-sm-4'>";
				
			
				var photo=base_url + "uploads/candidate_image/male.jpg";
				if(data.Gender=="Female")
					photo=base_url + "uploads/candidate_image/female.jpg";
			  if(data.ProfilePhoto!=null && data.ProfilePhoto!="")
			     photo = base_url + "uploads/candidate_image/" + data.ProfilePhoto;	
			
			
				pdfLink += "<span id='spanPhoto'><img src='" +  photo + "' id='photo' width='150' height='150'/></span>";
				pdfLink += "</div>";
				pdfLink += "</div>";
			
			$("#pdf_link").html(pdfLink);
			$("#title_head").html("Details of the candidate : " + data.FirstName + " " + data.LastName );
			
			$("#hideWhenEdit").hide();
			$("#hideWhenEdit1").hide();
			$("#userfile1").addClass("optional"); 
			
			
			

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
	 
	 
	 
 }

  
  function uploadNewPDF()
	 {
		
		  var formData = new FormData("#form1");
		  var fileField = document.getElementById('userfile2'); // getting the file field object.
         
		 
		 if(fileField.files[0]==null || fileField.files[0] =="")
		 {
				$("#divError1").text("Please select a file");
				return false;
				
			 
		 }
		 
		 $("#divError").text("");
		 
         formData.append('userfile', fileField.files[0]); 
		 formData.append('id', $("#hidID").val());
		 
		 
		 var url = base_url +  "index.php/admin/uploadPdfResult";	
		 
		  
		 
		 
   // alert(formData);
    //return;
    $.ajax({
        url : url,
        type: "POST",
        data:  formData,
        dataType: "json",
        processData: false,
        contentType: false,
    	cache: false,
        enctype: 'multipart/form-data',
        success: function(res)
        {
				 $("#divMessage1").text(res.msg);
		},
		error: function (jqXHR, textStatus, errorThrown)
        {
			console.log(jqXHR.responseText);
            alert('Error get data from ajax');
        }
     });
		 
		 
}

 function acceptData(id)
{
    
    bootbox.confirm("Are you sure to Accept this data?", function(result) {
		
     if(result)
	{
        // ajax acceptData data to database
		var url = base_url + "index.php/admin/acceptCandid/" + id;
        $.ajax({
            url : url,
            type: "POST",
            dataType: "json",
            success: function(res)
            {
                
                 bootbox.alert(res.msg);
				 reloadTable();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                bootbox.alert('Error while Accepting data');
            }
        });

        }
    }); // bootbox confirm ending
} 


function rejectData(id)
{
    
    bootbox.confirm("Are you sure to Reject this data?", function(result) {
		
     if(result)
	{
        // ajax acceptData data to database
		var url = base_url + "index.php/admin/rejectCandid/" + id;
        $.ajax({
            url : url,
            type: "POST",
            dataType: "json",
            success: function(res)
            {
                
                 bootbox.alert(res.msg);
				 reloadTable();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                bootbox.alert('Error while Rejecting data');
            }
        });

        }
    }); // bootbox confirm ending
} 
  
  
  
  function deleteData(id)
{
    
    bootbox.confirm("Are you sure to delete this data?", function(result) {
		
     if(result)
	{
        // ajax delete data to database
		var url = base_url + "index.php/admin/deleteCandid/" + id;
        $.ajax({
            url : url,
            type: "POST",
            dataType: "text",
            success: function(res)
            {
                
                 if(res.indexOf("Details exists")>=0)
                 {
                     var errorMsg ='<span style="color:red; font-weight:bold;">Sorry Can\'t delete this data, details exists.<span>'; 
                     bootbox.alert(errorMsg);
                     return false;
                 }
                 
                 if(res.indexOf("Error")>=0)
                 {
                     var errorMsg ='<span style="color:red; font-weight:bold;">' + res +'<span>'; 
                     bootbox.alert(errorMsg);
                     return false;
                 }
                 
                reloadTable();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                bootbox.alert('Error deleting data');
            }
        });

        }
    }); // bootbox confirm ending
}
 
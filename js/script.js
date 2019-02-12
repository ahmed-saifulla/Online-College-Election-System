


function myAlert(msg , selector){
    $(selector).html(msg);
    $(selector).slideDown(500,function(){
        setTimeout(function(){
            $(selector).slideUp(1500 , function(){

            });
        },3000);
    });
    

}


$(document).ready(function(){

    // Login Button Clicked
    $('#btnLogin').click(function(){

        var hasError = false;

        $('#loginForm input').removeClass('errorBorder'); 

        // Checking each input fields in form
        $('#loginForm input').each(function(){
            
            
            if(!$(this).val()){ //if its empty, change border of that field to highlight
                hasError = true;
                $(this).addClass('errorBorder');        
            }

        });
        
        if(hasError){
            myAlert('Fill All fields', '#errorMsg');
            return;
        }
    
        var login_data= $.ajax({
            url:BASE_URL+"Oces/login",
            data:$('#loginForm').serialize(),
            type:"post",	
            dataType:"json"
        });
    
        login_data.done(function(res){
            if(!res.status)
        	{
                myAlert(res.message, "#errorMsg");
                $('#loginForm input').addClass('errorBorder');
                return;
            }
            
            
            window.location.href = BASE_URL+"Oces/admin_panel";
    
        });
    
        login_data.fail(function(){
                    alert("Network Error");
        
        });
    
    });          

    
    // LogOUT Button Clicked
    $('#btnLogout').click(function(){
        bootbox.confirm({
            message: "You are about to Logout .<br>Are You Sure?",
            buttons: {
                confirm: {
                    label: 'Logout',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {
                console.log('This was logged in the callback: ' + result);

                if (result == true){
                    $.ajax({
                        url:BASE_URL+"Oces/logout",
                        success: function () {
                            
                            window.location.href = BASE_URL;
                        }
                    
                    });
                            
                }
            }
        });
    });


    // Save Button Clicked
    $('#btnSave').click(function(){

        var hasError = false;

            $('#editVoterForm input').removeClass('errorBorder'); 

            // Checking each input fields in form
            $('#editVoterForm input').each(function(){
                
                
                if(!$(this).val()){ //if its empty, change border of that field to highlight
                    hasError = true;
                    $(this).addClass('errorBorder');        
                }

            });
            
            if(hasError){
                myAlert('Fill All fields', '#errorMsg');
                return;
            }

        var login_data= $.ajax({
            url:BASE_URL+"Oces/saveVoter",
            data:$('#editVoterForm').serialize(),
            type:"post",	
            dataType:"json"
        });

        login_data.done(function(res){
            if(!res.status)
            {
                myAlert(res.message, "#errorMsg");
                $('#loginForm input').addClass('errorBorder');
                return;
            }
            
            
            window.location.href = BASE_URL+"Oces/votersEdit";

        });

        login_data.fail(function(){
                    alert("Network Error");
        
        });

    });   


    $('#otpBtn').click(function(){

        $('#otpBtn').attr('disabled',true);

        var login_data= $.ajax({
            url:BASE_URL+"Oces/voteProcess",
            data:{
                usn : $('#usn2').val() 
            },
            type:"get",	
            dataType:"json"
        });

        login_data.done(function(res){
            if(!res.status)
            {
                myAlert(res.message, "#errorMsg");
                $('#loginForm input').addClass('errorBorder');
                return;
            }

            $('#otpBtn').attr('disabled',false);
            
            
            

        });

        login_data.fail(function(){
            $('#otpBtn').attr('disabled',false);
                    alert("Network Error");
        
        });

    });   

    $('#btnOTPsubmit').click(function(){

        $('#btnOTPsubmit').attr('disabled',true);

        var login_data= $.ajax({
            url:BASE_URL+"Oces/otpValidation",
            data:{
                usn2 : $('#usn2').val() ,
                otp2 : $('#otp2').val() 
            },
            type:"get",	
            dataType:"json"
        });

        login_data.done(function(res){
            if(!res.status)
            {
                myAlert(res.message, "#errorMsg");
                $('#loginForm input').addClass('errorBorder');
                return;
            }
            
            $('#btnOTPsubmit').attr('disabled',false);

            window.location.href = BASE_URL+"Oces/voting";
            
            
            

        });

        login_data.fail(function(){
            $('#btnOTPsubmit').attr('disabled',false);
                    alert("Network Error");
        
        });

    });   



    // Rule Save Button Clicked
    $('#btnSaveRule').click(function(){

        var hasError = false;

            $('#editRuleForm input').removeClass('errorBorder'); 

            // Checking each input fields in form
            $('#editRuleForm input').each(function(){
                
                
                if(!$(this).val()){ //if its empty, change border of that field to highlight
                    hasError = true;
                    $(this).addClass('errorBorder');        
                }

            });
            
            if(hasError){
                myAlert('Fill All fields', '#errorMsg');
                return;
            }

        var login_data= $.ajax({
            url:BASE_URL+"Oces/saveRule",
            data:$('#editRuleForm').serialize(),
            type:"post",	
            dataType:"json"
        });

        login_data.done(function(res){
            if(!res.status)
            {
                myAlert(res.message, "#errorMsg");
                $('#loginForm input').addClass('errorBorder');
                return;
            }
            
            
            window.location.href = BASE_URL+"Oces/rulesEdit";

        });

        login_data.fail(function(){
                    alert("Network Error");
        
        });

    });   


    // Apply Noinee Button Clicked
    $('#btnApply').click(function(){

        var hasError = false;

            $('#applyForm input').removeClass('errorBorder'); 

            // Checking each input fields in form
            $('#applyForm input').each(function(){
                
                
                if(!$(this).val()){ //if its empty, change border of that field to highlight
                    hasError = true;
                    $(this).addClass('errorBorder');        
                }

            });
            
            if(hasError){
                myAlert('Fill All fields', '#errorMsg');
                return;
            }

        var login_data= $.ajax({
            url:BASE_URL+"Oces/applyNominee",
            data:$('#applyForm').serialize(),
            type:"post",	
            dataType:"json"
        });

        login_data.done(function(res){
            if(!res.status)
            {
                myAlert(res.message, "#errorMsg");
                $('#applyForm input').addClass('errorBorder');
                return;
            }
            
            
            window.location.href = BASE_URL;

        });

        login_data.fail(function(){
                    alert("Network Error");
        
        });

    });
    
    
    


    $('#btnSaveDept').click(function(){

        var hasError = false;

            $('#editDeptForm input').removeClass('errorBorder'); 

            // Checking each input fields in form
            $('#editRuleForm input').each(function(){
                
                
                if(!$(this).val()){ //if its empty, change border of that field to highlight
                    hasError = true;
                    $(this).addClass('errorBorder');        
                }

            });
            
            if(hasError){
                myAlert('Fill All fields', '#errorMsg');
                return;
            }

        var login_data= $.ajax({
            url:BASE_URL+"Oces/saveDept",
            data:$('#editDeptForm').serialize(),
            type:"post",	
            dataType:"json"
        });

        login_data.done(function(res){
            if(!res.status)
            {
                myAlert(res.message, "#errorMsg");
                $('#loginForm input').addClass('errorBorder');
                return;
            }
            
            
            window.location.href = BASE_URL+"Oces/deptsEdit";

        });

        login_data.fail(function(){
                    alert("Network Error");
        
        });

    });   


    $('#changePass').click(function(){

        var hasError = false;

            $('#changePassForm input').removeClass('errorBorder'); 

            // Checking each input fields in form
            $('#changePassForm input').each(function(){
                
                
                if(!$(this).val()){ //if its empty, change border of that field to highlight
                    hasError = true;
                    $(this).addClass('errorBorder');        
                }

            });
            
            if(hasError){
                myAlert('Fill All fields', '#errorMsg');
                return;
            }

        var login_data= $.ajax({
            url:BASE_URL+"Oces/savePass",
            data:$('#changePassForm').serialize(),
            type:"post",	
            dataType:"json"
        });

        login_data.done(function(res){
            if(!res.status)
            {
                myAlert(res.message, "#errorMsg");
                $('#changePassForm input').addClass('errorBorder');
                return;
            }
            
            
            window.location.href = BASE_URL+"Oces/admin_panel";

        });

        login_data.fail(function(){
                    alert("Network Error");
        
        });

    });   



    

});



function editData(id)
{
 	
	var url = BASE_URL + "Oces/getEditVoter";
	
	
	save_method = 'add';
    $('#editVoterForm')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
 
	
    //Ajax Load data from ajax
    
    $.ajax({
        url : url + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            // $("#id").val(data.Id);
            $("#hidID").val(data.Id);
            $("#usn").val(data.usn);
            $("#vName").val(data.s_name);
            $("#gender").val(data.gender);
            $("#vdob").val(data.dob);
            $("#semester").val(data.semester);
            $("#vDept").val(data.department);
            $("#email").val(data.email);
            $("#phone").val(data.MobileNo);
			
			$('#editVoterModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Voter'); // Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



function acceptCandi(id)
{
 	
	var url = BASE_URL + "Oces/acceptCandi";
	
	
	
    //Ajax Load data from ajax
    
    $.ajax({
        url : url + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            alert('Accepted');
            window.location.href = BASE_URL+"Oces/candidatesEdit";
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}





function rejectCandi(id)
{
 	
	var url = BASE_URL + "Oces/rejectCandi";
	
	
	
    //Ajax Load data from ajax
    
    $.ajax({
        url : url + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            alert('Rejected');
            window.location.href = BASE_URL+"Oces/candidatesEdit";
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function editRules(id)
{
 	
	var url = BASE_URL + "Oces/getEditRule";
	
	
	save_method = 'add';
    $('#editRuleForm')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
 
	
    //Ajax Load data from ajax
    
    $.ajax({
        url : url + "/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            // $("#id").val(data.Id);
            $("#hidID").val(data.Id);
            $("#rule").val(data.rule);
    
			$('#editRuleModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Rule'); // Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}



  function deleteData(id)
{
    
    bootbox.confirm("Are you sure to delete this data?", function(result) {
		
     if(result)
	{
        // ajax delete data to database
		var url = BASE_URL + "Oces/deleteVoter/" + id;
        $.ajax({
            url : url,
            type: "POST",
            dataType: "text",
            success: function(res)
            {
                window.location.href = BASE_URL+"Oces/votersEdit";
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                bootbox.alert('Error deleting data');
            }
        });

        }
    }); // bootbox confirm ending
}

function deleteDept(id)
{
    
    bootbox.confirm("Are you sure to delete this data?", function(result) {
		
     if(result)
	{
        // ajax delete data to database
		var url = BASE_URL + "Oces/deleteDept/" + id;
        $.ajax({
            url : url,
            type: "POST",
            dataType: "text",
            success: function(res)
            {
                window.location.href = BASE_URL+"Oces/deptsEdit";
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                bootbox.alert('Error deleting data');
            }
        });

        }
    }); // bootbox confirm ending
}
 

function deleteRule(id)
{
    
    bootbox.confirm("Are you sure to delete this data?", function(result) {
		
     if(result)
	{
        // ajax delete data to database
		var url = BASE_URL + "Oces/deleteRule/" + id;
        $.ajax({
            url : url,
            type: "POST",
            dataType: "text",
            success: function(res)
            {
                window.location.href = BASE_URL+"Oces/rulesEdit";
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                bootbox.alert('Error deleting data');
            }
        });

        }
    }); // bootbox confirm ending
}


function addVoter(){
    $('#editVoterModal').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Add Voter'); // Set title to Bootstrap modal title
    $('#editVoterForm')[0].reset(); // reset form on modals

    $("#hidID").val("0");
}

function addRule(){
    $('#editRuleModal').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Add Rule'); // Set title to Bootstrap modal title
    $('#editRuleForm')[0].reset(); // reset form on modals

    $("#hidID").val("0");
}

function addDept(){
    $('#editDeptModal').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Add Dept'); // Set title to Bootstrap modal title
    $('#editDeptForm')[0].reset(); // reset form on modals

    $("#hidID").val("0");
}

function publishResult(){
    $('#publishModal').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Pulish Result'); // Set title to Bootstrap modal title
    $('#publishResultForm')[0].reset(); // reset form on modals

    $("#hidID").val("0");
}
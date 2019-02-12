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
        <div class="row" style="color:white; padding-top:50px;">
				<div class="col-md-4" >
					<div id="post1" >
                   
						<center>
						<h2> President </h2>
                        <?php foreach($result as $row){
                            if($row['post']=='President')
							echo '<button type="button" onclick="vote(\''.$row['Id'].'\');" class="btn btn-info vote-btns-1" id="'.$row['Id'].'">'.$row['c_name'].'</button> &nbsp;';
                        }
                        
                        ?><!-- <button type="button" class="btn btn-warning vote-btns-1" id="p1c2">  </button>
							<button type="button" class="btn btn-danger vote-btns-1" id="p1c3">  </button> -->
						</center>
					</div>	
				</div>

				<div class="col-md-4">
					<div id="post2">
						<center>
						<h2> Secretary </h2>
						<?php foreach($result as $row){
                            if($row['post']=='Secretary')
							echo '<button type="button" class="btn btn-info vote-btns-2" onclick="vote(\''.$row['Id'].'\');" id="'.$row['Id'].'">'.$row['c_name'].'</button> &nbsp;';
                        }
                        
                        ?>
						</center>
					</div>	
				</div>

				<div class="col-md-4">
					<div id="post3">
						<center>
						<h2> Treasurer </h2>
                        <?php foreach($result as $row){
                            if($row['post']=='Treasurer')
                        echo '<button type="button" class="btn btn-info vote-btns-3" onclick="vote(\''.$row['Id'].'\');" id="'.$row['Id'].'">'.$row['c_name'].'</button> &nbsp;';
                        }
                        
                        ?>
						</center>
					</div>	
				</div>
			</div>
        </section>
        <!-- Main Banner E N D -->

		<section id="slider-sec">
         
        </section> 

        
        </div>

        <footer>
            <p>O C E S &copy; 2018 </p>
        </footer>


		<script>

                        function vote(candidateId){

                            var login_data= $.ajax({
                        url:BASE_URL+"Oces/vote/" + candidateId,
                        type:"post"
                    });

                    login_data.done(function(res){
                        if(!res.status)
                        {
                            myAlert(res.message, "#errorMsg");
                            $('#changePassForm input').addClass('errorBorder');
                            return;
                        }
                        
                        
                     

                    });

                    login_data.fail(function(){
                                alert("Network Error");
                    
                    });


					
			
				

                        }

			$('.vote-btns-1').click(function(){
				$('#post1').fadeOut();
				
			});

			$('.vote-btns-2').click(function(){
				$('#post2').fadeOut(function(){
					alert('VOte for Post 2 Done!');
				});
				
			});

			$('.vote-btns-3').click(function(){
				$('#post3').fadeOut(function(){
					alert('VOte for Post 3 Done!');
				});
				
			});
		</script>

        
</body>
</html>
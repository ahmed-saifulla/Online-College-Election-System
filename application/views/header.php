<header>
<!-- Navbar START-->
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="#">OCES</a>
        
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                
                <!-- Load if login session is Not set (Public Users) -->
                <?php if (!isset($_SESSION['admin'])){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/candidates">Candidates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/voters">Voters</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/rules">Rules</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="#" data-target="#applyModal" data-toggle="modal" >Apply</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="#" data-target="#myModal" data-toggle="modal" >Admin</a>
                    </li>

                <!-- Load if login session is SET (for Admins)-->
                <?php } else{?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/users">Users</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/votersEdit">Voters</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/candidatesEdit">Candidates</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/rulesEdit">Rules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/deptsEdit">Departments</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/settings">Settings</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url()?>Oces/changePass">Change Password</a>
                    </li> 
                        
                                
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="btnLogout">Logout</a>
                    </li> 
                <?php } ?>
            </ul>
        </div> 
    </nav>
    <!-- Navbar E N D -->
</header>

    
    <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
        
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                <div class="modal-body">
                  <form id="loginForm" onsubmit="return false">
                      Email ID<input type="email" name="email_id" required class="form-control"><br>
                      Password<input type="password" name="password" required  class="form-control">
                  

                  <div id="errorMsg" class="errorMsg">
                       <!-- to print error message in UI  -->
                  </div>

                </div>

                <div class="modal-footer">
                  <button  class="btn btn-success" id="btnLogin" > Login </button>
                
                  </form>  
                </div>
              </div>
              
            </div>
          </div>


          <div class="modal fade" id="applyModal" role="dialog">
            <div class="modal-dialog">
        
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Apply as Nominee</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
                </div>
                <div class="modal-body">
                  <form id="applyForm" onsubmit="return false">
                  USN<input type="text" name="usn" required class="form-control"><br>
                    Name<input type="text" name="c_name" required class="form-control"><br>
                    Gender<input type="text" name="gender" required class="form-control"><br>
                    Post<input type="text" name="post" required class="form-control"><br>
                    Date of Birth<input type="date" name="dob" required class="form-control"><br>
                    Department<input type="text" name="dept" required class="form-control"><br>
                    Semester<input type="text" name="sem" required class="form-control"><br>
                    Mobile NO<input type="text" name="mobile" required class="form-control"><br>
                    Email ID<input type="email" name="email_id" required class="form-control"><br>
                  <div id="errorMsg" class="errorMsg">
                       <!-- to print error message in UI  -->
                  </div>

                </div>

                <div class="modal-footer">
                  <button  class="btn btn-success" id="btnApply" > Login </button>
                
                  </form>  
                </div>
              </div>
              
            </div>
          </div>
    
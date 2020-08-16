<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</head>
<body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Job Wizard</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="results.php">All Listings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="mailto:admin@jobwizard.com">Contact Us</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="welcome.php">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">My Account</button>
    </form>
  </div>
</nav>
    
    
    <div class="page-header text-center">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to your profile.</h1>
    </div>
    
    
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <?php
                    require_once 'config.php';
                    // if(usertype=1) $_PostorAp = Post
                    //else $PostorAp = Ap
                    //whenevber posting or ap used ->echo $_PostorAp 
                    $sql = "SELECT account_type from account where username = '".htmlspecialchars($_SESSION["username"])."'";
                    
                     if($stmt = mysqli_prepare($link, $sql)){
                        if($stmt->execute()){
                            
                            $stmt->bind_result($account_type);
                            
                            while($stmt->fetch()){
                                if($account_type == 1){
                                    echo '<h3>My Applications</h3>';
                                    echo '<a href="viewaps.php" class="btn btn-primary mb-2"> View Applications</a>';
                                    echo '<a href="delete_ap.php" class="btn btn-primary mb-2"> Delete Applications</a>';
                                }
                                else{
                                    echo '<h3>My Postings</h3>';
                                    echo '<a href="viewposting.php" class="btn btn-primary mb-2">View Postings</a>';
                                    echo '<a href="createposting.php" class="btn btn-primary mb-2">Create Posting</a>';
                                    echo '<a href="delete_posting.php" class="btn btn-primary mb-2">Delete Posting</a>';
                                }
                            }
                            $stmt->close();
                        }
                     }
                ?>
            </div>
            <div class="col">
                <h3>Account Management</h3>
                <a href="logout.php" class="btn btn-warning"> Log Out</a>
                <a href="reset-password.php" class="btn btn-warning"> Reset Password</a>
            </div>
        </div>
    </div>
    

<footer class="page-footer font-small pt-4">
  <div class="footer-copyright text-center py-3">© 2020 Job Wizard LLC</div>
</footer>


</body>
</html>
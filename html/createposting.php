<?php

session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once 'config.php';
    
    if(isset($_POST['isPost'])){
        $sql="INSERT INTO posting (post_name, poster, post_desc, post_type, wage, hours, region) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
        if($stmt = mysqli_prepare($link, $sql)){
            
            $stmt->bind_param('sssiiis', $post_name, $poster, $post_desc, $post_type, $wage, $hours, $region);
            $poster=htmlspecialchars($_SESSION['username']);
            
            $post_name=$_POST['posName'];
            $post_desc=$_POST['posDes'];
            $post_type=$_POST['posType'];
            $wage=$_POST['wage'];
            $hours=$_POST['hours'];
            $region=$_POST['region'];
            
            switch($post_type){
                case 'Technology':
                    $post_type = 0;
                    break;
                case 'Business':
                    $post_type = 1;
                    break;
                case 'Retail':
                    $post_type = 2;
                    break;
            }
            
            if($stmt->execute())
                printf("Post Creation Successful!");
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create Posting</title>
  <meta charset="utf-8">
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
        <a class="nav-link" href="index.php">Home</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="results.php">All Listings <span class="sr-only">(current)</a>
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
  
<div class="container mt-4 justify-content-center">
    <div class="row justify-content-md-center">
            <div class="col-3">
                <form action="createposting.php" method="post">
                    <div clas="form-group">
                        <label for="posName">Position Name:</label>
                        <input type="text" class="form-control" id="posName" name="posName">
                        <label for="posType">Position Type:</label>
                        <select class="form-control" id="posType" name="posType">
                            <?php 
                              $sql  = "SELECT value FROM types";
                              if($stmt = mysqli_prepare($link, $sql)){
                                    $stmt->execute();
                                    
                                    $stmt->bind_result($value);
                                      
                                    while($stmt->fetch()){
                                        echo '<option>';
                                        echo  $value;
                                        echo '</option>';
                                    }  
                                    
                                    $stmt->close();
                              }
                            ?>
                        </select>
                        <label for="posDes">Position Description:</label>
                        <input type="text" class="form-control" id="posDes" name="posDes">
                        <label for="wage">Wage ($/h):</label>
                        <input type="number" class="form-control" id="wage" name="wage">
                        <label for="hours">Hours (Per Week):</label>
                        <input type="number" class="form-control" id="hours" name="hours">
                        <label for="region">Region:</label>
                        <input type="text" class="form-control" id="region" name="region">
                        <button type="submit" class="btn btn-primary mb-2 mt-2">Submit</button>
                        <input type="hidden" name="isPost" id="isPost" value="1">
                    </div>
                </form>
            </div>
    </div>
    
<footer class="page-footer font-small pt-4">
  <div class="footer-copyright text-center py-3">© 2020 Job Wizard LLC</div>
</footer>

</body>
</html>
<?php
session_start();
 
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Job Post</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../showpost.js"></script>

</head>

<?php
$sql = 'select account_type FROM account where username="'.htmlspecialchars($_SESSION['username']).'"';

if($stmt = mysqli_prepare($link, $sql)){
    if($stmt->execute()){
        $stmt->bind_result($ac_type);
        while($stmt->fetch()){
            echo '<body onload="hide_section('.$ac_type.')">';
        }
    }else{
        echo '<body onload="hide_section(1)">';
    }
}
?>

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
      <li class="nav-item active">
        <a class="nav-link" href="results.php">All Listings <span class="sr-only">(current)</span></a>
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
            <div class="col justify-content-md-center">
                <?php
                require_once 'config.php';
                $pid = $_GET['id'];
                $sql="SELECT post_id, post_name, post_desc, poster, post_type, wage, hours, create_ts FROM posting where post_id = '";
                $sql= $sql.$pid."'";
                //echo '<h1>'.$sql.'</h1>';
                //$sql="SELECT post_name FROM posting where poster = ";
                //$sql=$sql.'"IT COMPANY"';
                
                if($stmt = mysqli_prepare($link, $sql)){
                    
                    //$stmt->bind_param('s', $poster);
                    //$poster = htmlspecialchars($_SESSION['username']);
                    
                    if($stmt->execute()){
                        
                        $stmt->bind_result($post_id, $post_name, $post_desc,$poster, $post_type, $wage, $hours, $create_ts);
                        //$stmt->bind_result($post_name);
                          
                        while($stmt->fetch()){
                            echo '<h1 class="text-center">';
                            echo $post_name;
                            echo '</h1>';
                            echo '<h2 class="text-center">Employer: '.$poster.'</h2>';
                            echo '<h3 class="text-center">Job Details:<br> '.$post_desc.'</h3>';
                            echo '<p class="text-center">Wage: $'.$wage.'/h</p>';
                            echo '<p class="text-center">Hours per week: '.$hours.'</p>';
                        }  
                        
                        $stmt->close();
                    }
                }
                ?>
            </div>
    </div>
    <div class="row justify-content-md-center" id="applybtn" style="visibility: visible;">
        <form action="apply.php" method="post">
            <div class="form-group ">
                <input type="hidden" name="post_id" id="post_id" value=<?php echo '"'.$post_id.'"' ?>>
                <button type="submit" class="btn btn-primary mb-2 mt-2 ">Apply</button>
            </div>
        </form>
    </div>
    <div class="row justify-content-md-center" id="aps" style="visibility: hidden;">
        <h1>Applicants:</h1>
    </div>
        <?php
            $sql = 'select ap_name FROM application where post_id="'.$post_id.'"';
            
            if($stmt = mysqli_prepare($link, $sql)){
                if($stmt->execute()){
                    $stmt->bind_result($apl);
                    while($stmt->fetch()){
                        echo '<div class="row justify-content-md-center">';
                        echo '<h3>'.$apl.'</h3>';
                        echo '</div>';
                    }
                }
            }
        ?>
    
</div>
    

<footer class="page-footer font-small pt-4">
  <div class="footer-copyright text-center py-3">© 2020 Job Wizard LLC</div>
</footer>


</body>
</html>
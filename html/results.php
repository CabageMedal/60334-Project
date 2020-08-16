<?php 
require_once 'config.php';
$jType=$_POST["jType"]; 
$region=$_POST["region"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Job Postings</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="../js/showpost.js"></script>
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
  
<div class="container mt-4">
    <div class="row">
            <div class="col">
                <form action="results.php" method="post">
                    <label for="sortby">Sort By:</label>
                    <select class="form-control" id="sortby" name="sortby">
                        <option>--Sort By--</option>
                        <option>Date</option>
                        <option>Type</option>
                        <option>Wage</option>
                        <option>Name</option>
                    </select>
                    <label for="region">Filter By:</label>
                    <select class="form-control" id="region" name="region">
                        <option>--Region--</option>
                        <?php 
                          $sql  = "SELECT distinct region FROM posting where region is not null";
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
                    <select class="form-control" id="jType" name="jType">
                        <option>--Job Type--</option>
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
                    <button type="submit" class="btn btn-primary mb-2 mt-2">Apply</button>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="reset" name="reset">
                        <label class="form-check-label mb-4" for="reset">Reset All Filters</label>
                    </div>
                </form>
            </div>
    </div>
    
    <div clas="row">
        <div class="col">
            <?php 
                  
                  $sortBy = $_POST["sortby"];
                  
                  if(isset($_POST['reset']) && $_POST['reset'] == 1){
                      $jType='--Job Type--';
                      $sortBy='';
                      $region='--Region--';
                  }
                  
                  $sql="SELECT post_id, post_name, poster, post_desc FROM posting";
                  
                  if(isset($jType) && $jType!='--Job Type--'){
                      if($jType=='Technology')
                        $sql=$sql." WHERE post_type = 0";
                      else if($jType=='Business')
                        $sql=$sql." WHERE post_type = 1";
                      else if($jType=="Retail")
                        $sql=$sql." WHERE post_type = 2";
                        
                      if(isset($region) && $region!='--Region--'){
                          $sql=$sql." and region = '".$region."'";
                      }
                  }else if(isset($region) && $region!='--Region--'){
                        $sql=$sql." where region = '".$region."'";
                  }else{
                        $sql="SELECT post_id, post_name, poster, post_desc FROM posting";
                  }
                  
                  
                  
                  if($sortBy == 'Name'){
                    $sql  = $sql." ORDER BY post_name";
                  }
                  else if($sortBy == 'Date'){
                    $sql  = $sql." ORDER BY create_ts DESC";
                  }
                  else if($sortBy == 'Type'){
                    $sql  = $sql." ORDER BY post_type";
                  }
                  else if($sortBy == 'Wage'){
                    $sql  = $sql." ORDER BY wage DESC";
                  }
    
                  //print($sql);
    
                  if($stmt = mysqli_prepare($link, $sql)){
                        if($stmt->execute()){
                            
                            $stmt->bind_result($post_id, $post_name, $poster, $post_desc);
                              
                            while($stmt->fetch()){
                                echo '<a href="post.php?id='.$post_id.'">';
                                echo '<h3>';
                                echo $post_name;
                                echo '</h3>';
                                echo '<p>';
                                echo $poster;
                                echo '</p>';
                                echo '</a>';
                            }  
                            
                            $stmt->close();
                        }
                  }
                ?>  
        </div>
    </div>
</div>


<footer class="page-footer font-small pt-4">
  <div class="footer-copyright text-center py-3">© 2020 Job Wizard LLC</div>
</footer>



</body>
</html>
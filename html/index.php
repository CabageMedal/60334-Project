<?php 
              require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Job Wizard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Job Wizard</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
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
  
<div class="container mt-4 justify-content-center">
  <form action="results.php" method="post">
    <div class="row justify-content-md-center">
      <div class="col">
        <select class="form-control" name="jType">
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
      </div>
      <div class="col">
         <select class="form-control" name="region">
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
      </div>
      <div class="col">
          <button type="submit" class="btn btn-primary mb-2">Make Magic</button>
      </div>
    </div>
  </form>
</div>

<div class="container mt-4 justify-content-center">
    <div class="row">
        <div class="col">
            <h3 class="text-center">Recommended Searches</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-6 justify-content-center text-center">
            <?php
                $sql = 'SELECT post_type, count(*) as cmt FROM posting group by post_type';
                $result = mysqli_query($link, $sql);
                $rows = $result->num_rows;
                echo <<<_END
  
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['corechart']});
                      google.charts.setOnLoadCallback(drawChart);
                
                      function drawChart() {
                
                        var data = google.visualization.arrayToDataTable([
                          ['Job Type', 'Count'],
_END;
                  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
    
    if($row[0] == 0){
        $col_name = "Technology";
    }else if($row[0] == 1){
        $col_name = "Business";
    }else{
        $col_name = "Retail";
    }
    
    if($j != $rows -1){
        echo'[\''.$col_name.'\','.$row[1].'],';
    }
    else{
        echo'[\''.$col_name.'\','.$row[1].']';
    }
    
  }

  echo <<<_END
        ]);

        var options = {
          title: 'Job Type Popularity'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

    <div id="piechart"></div>
_END;
  $result->close();

            ?>
        </div>
        
    </div>
</div>




<footer class="page-footer font-small pt-4">
  <div class="footer-copyright text-center py-3">© 2020 Job Wizard LLC</div>
</footer>



</body>
</html>

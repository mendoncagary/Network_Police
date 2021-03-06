<?php
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Statistics</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="css/decor.css">
     <link rel="stylesheet" href="css/templatemo-style.css">


  </head>
  <body>

<nav class="navbar navbar-inverse" style="margin-bottom:0px">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img id="logo" src = "img/logo1.png"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li  class="active"><a href="statistics.php">Statistics</a></li>
        <li><a href="pc.php">PC</a></li>
        <li><a href="alert.php">Alert</a></li>
        <li><a href="block.php">Block</a></li>
      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php
                  $dump = file_get_contents("server/client.dump");
                  $obj = json_decode($dump, true);

                  $result = mysql_query("SELECT * FROM pc_usage");
                  $totalPCS = mysql_num_rows($result);

                   $result = mysql_query("SELECT * FROM pc_usage where status = -1");
                  $totalPCSThatAreDead = mysql_num_rows($result);

                  $dataUsage = 0;
                  $total = 0;
                  for($i = 0; $i < count($obj); $i++) {
                             $dataUsage += array_values($obj)[$i]["nu"]["received"]; 
                             $total = $i;
                  }

                  $inUse = ($total / $totalPCS) * 100;
                  
                  $deadPCPercentage = sprintf("%d", ($totalPCSThatAreDead/$totalPCS) * 100);


                  $result = mysql_query("SELECT * FROM blacklist");
                  $blcount = mysql_num_rows($result);
                 
    
            ?>

<div>

    <div class="row" >
      
        
              <section id="about" class="parallax-section" >
                  <div class="container">
                        <div class="row">

                            <div class="col-md-6 col-sm-12">
                                  <div class="about-thumb">
                                      <div class="wow fadeInUp section-title" >
                                            <h1 style="padding-left:6px">Network Police</h1>
                                            <p class="color-red">Network manager software</p>
                                      </div>
                                      <div class="wow fadeInUp" >
                                            <p>Software can be used to monitor all machines on the network. The network usage as well as the applications being accessed by them can be monitored. Remote access and machine status can also be controlled.</p>
                                            
                                      </div>
                                  </div>
                            </div>

                            
                            <div class="bg-red col-md-3 col-sm-6">
                                            <img src="img/logo.png" style="width:82%; padding:10% 0% 5% 15%">                       
                                                                 
                            </div>

                            <div class="bg-yellow col-md-3 col-sm-6">
                                  <div class="skill-thumb">
                                      <div class="wow fadeInUp section-title color-white" >
                                            <h2><center>Machine</center></h2>
                                           
                                      </div>

                                      <div class=" wow fadeInUp skills-thumb">
                                      <strong>ON</strong>
                                            <span class="color-white pull-right"><?php echo $inUse; ?></span>
                                                <div class="progress">
                                                      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?php echo $inUse; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $inUse; ?>%;"></div>
                                                </div>

                                      <strong>OFF</strong>
                                            <span class="color-white pull-right"><?php echo 100-$inUse; ?></span>
                                                <div class="progress">
                                                      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?php echo 100-$inUse; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo 100-$inUse; ?>%;"></div>
                                                </div>

                                      <strong>OUT OF SERVICE</strong>
                                            <span class="color-white pull-right"><?php echo $deadPCPercentage; ?>%</span>
                                                <div class="progress">
                                                      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?php echo $deadPCPercentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $deadPCPercentage; ?>%;"></div>
                                                </div>
                                      </div>

                                  </div>
                            </div>

                        </div>
                  </div>
              </section>

              

                            
              <section id="service" class="parallax-section">
                  <div class="container">
                        <div class="row">

                            <div class="bg-yellow col-md-3 col-sm-6">
                                  <div class="wow fadeInUp color-white service-thumb">
                                      <i class="fa fa-desktop"></i>
                                            <h3>Total Network Usage</h3>
                                            <p class="color-white"><h1><?php echo sprintf("%0.2f", $dataUsage/1000000); ?> MB</h1></p>
                                  </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                  <div class="wow fadeInUp color-white service-thumb" >
                                      <i class="fa fa-paper-plane"></i>
                                            <h3>Blacklisted Applications</h3>
                                            <?php 
                                                $hashes = array();
                                                $result = mysql_query("SELECT * FROM app_hash");
                                            ?>
                                            <p class="color-white"><h1><?php echo mysql_num_rows($result); ?></h1></p>
                                  </div>
                            </div>

                            <div class="bg-dark col-md-3 col-sm-6">
                                  <div class="wow fadeInUp color-white service-thumb">
                                      <i class="fa fa-table"></i>
                                            <h3>Blacklist</h3>
                                            <p class="color-white"><h2><?php echo $blcount; ?></h2></p>
                                  </div>
                            </div>

                            <div class="bg-white col-md-3 col-sm-6">
                                  <div class="wow fadeInUp service-thumb" >
                                      <i class="fa fa-html5"></i>
                                            <h3>Total Connections</h3>
                                            <p><h1><?php echo $total ?></h1></p>
                                  </div>
                            </div>

                        </div>
                  </div>
              </section>

       
    </div>

</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        require('./js/renderer.js')
    </script>

  </body>
</html>

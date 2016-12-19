<?php
session_start();

//destroy edit and random session to display default image when going back to home
unset($_SESSION[edit]);
unset($_SESSION[rand]);

//destroy default_alert session
unset($_SESSION[default_alert]);

//get parameters
include ('parameters.php');

//define _SESSION values as array
foreach($_SESSION[param_array] as $value){$_SESSION[$value."_gal"] = array();}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>ImgGen v2</title>
        <meta charset="utf-8">
        <meta name="description" content="Generate images with PHP">
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css" media="all"/>
        <link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
        <link rel="stylesheet" type="text/css" href="css/styles.css" media="all"/>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta property="og:title" content="ImgGen V2" />
        <meta property="og:url" content="http://www.pochworld.com/imggen/v2/" />
        <meta property="og:image" content="http://www.pochworld.com/imggen/v2/img/imggenv2.png" />
        <meta property="og:description" content="Generate images with PHP" />
    </head>

    <body>
        <header id="hhh" class="hhh">
            <div class="title1"><h3>ImgGen v2</h3></div>
                <!-- firefox hack for title banner style-->
                <svg class="clip-svg">
                    <defs>
                        <clipPath id="banner" clipPathUnits="objectBoundingBox">
                            <polygon points="0 0, 1 0, 0.95 0.5, 1 1, 0 1, 0.05 0.5" />
                        </clipPath>
                    </defs>	
                </svg>
                <style>
                    .title1 h3 {
                        clip-path: url("#banner");
                        -webkit-clip-path: url("#banner");
                        }
                    .clip-svg{
                        position: absolute;
                        z-index:-99999;
                        }
                </style>
                <!-- end of hack -->
        
            <div class="about">
                    <p>GALLERY</p>
                    <p><a href="index.php">Home</a></p>
            </div>
        </header>
        <?php
        //define directory of saved presets
        $file = "presets.txt";
        //count how many presets have been saved
        $nbimg = file_get_contents($file);
        $nbimg = substr_count($nbimg, "\n");
        echo "<div class=\"count\">$nbimg images created since 2016-12-11</div>";
        ?>
        <div class="info_gal">
            <p>Click on images to open in modal and access edit mode !</p>
        </div>
        <div class="gallery">
        <?php
        //scan presets directory
        $ver = 0;
        $lines = file($file);
        foreach ($lines as $line_num => $line) {
            //get presets from file name
            $line = explode("_", $line);
            //set presets to session for each image
            $x=0;
            foreach($_SESSION[param_array] as $key => $value){
                $_SESSION[$key."_gal"][$ver] = $line[$x];
                $x++;
            }
            if(isset($line[20]) && $line[20] != "_"){$sign = $line[20];}
            else {$sign = "Anonymous";}
            //display images in gallery
            echo "
                <div class=\"itemgal\">
                    <a href=\"#\" data-toggle=\"modal\" data-target=\"#myModal".$ver."\">
                        <img src=\"model/grid_gal.php?ver=$ver\" class=\"imggal\">
                    </a>
                </div>
                <!--MODAL-->
                <div id=\"myModal".$ver."\" class=\"modal fade\" role=\"dialog\">
                    <div class=\"modal-dialog\">
                        <div class=\"modal-content\">
                            <div class=\"modal-header\">
                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                <h4 class=\"modal-title\">A generated image by $sign</h4>
                            </div>
                            <div class=\"modal-body\">
                                <img src=\"model/grid_gal.php?ver=$ver\">
                            </div>
                            <div class=\"modal-footer\">
                            <form action=\"edit.php\"  method=\"post\" id=\"editimg\">
                                <input type=\"hidden\" name=\"ver\" value=".$ver." />
                                <input type=\"submit\" value=\"Edit this image as new file\">
                            </form>
                                <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN MODAL-->
                ";
         $ver++;
        } 

        ?>
        </div>
        <footer>
            <p>Credit : Beno�t Ripoche - contact : <a href="mailto:contact@pochworld.com">contact@pochworld.com</a></p>
        </footer>
  
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/functions.js"></script>

    </body>
</html>



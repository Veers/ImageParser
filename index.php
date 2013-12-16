<?php

//function class_autoload($className)
//{
//
//    $substr_Model = "Model_";
//    $root = "/var/www/trol/data/www/punk.creativenative.ru/";
//    $pos = strpos($className, $substr_Model);
//    if ($pos !== false) {
//        // strlen("Model_") == 6
//        $filename = $root . "client/model/" . strtolower(substr($className, 6)) . ".php";
//        if (file_exists($filename)) {
//            require $filename;
//            echo $filename;
//        }
//    } else {
//        $filename = $root . "module/" . $className . ".php";
//        if (file_exists($filename)) {
//            require $filename;
//            echo $filename;
//        }
//    }
//}

//spl_autoload_register('class_autoload');


echo '<html><head><link type="text/css" href="css/style.css" </head><body>';
echo '<div id="content">';
echo '<form action="parser.php" method="post"><input name="data" type="text" size="40" onchange="this.form.submit()" ></form>';
echo '</div>';
echo '</body>';
//db::connect();
?>
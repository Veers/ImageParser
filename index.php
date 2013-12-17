<?php
require 'parser.php';
require 'db.php';

if (isset($_POST['data'])) {
    $login = 'punk';
    $pass = '11ctynz,hz';
    $parser = new Parser();
    $db = new db($login, $pass);
    $links = $parser->parseLinks($_POST['data']);
    $db->putLinksToBase($links);
    $inputData = $parser->printData($links);
}
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script type="text/javascript" src="lib/jquery_min_1.10.js"></script>
        <script type="text/javascript" src="js/inputHandlerJS.js"></script>
    </head>
    <body>
        <div id="content">
            <form method="post" action="index.php"">
                <input name="data" type="text" size="40">
            </form>
            <div id="context">
                <?php
                echo '<ul>';
                if (isset($inputData)) {
                    for ($i = 1; $i < count($inputData); $i++) {
                        echo '<li><a href=' . $inputData[$i] . '>' . $inputData[$i] . '</a></li>';
                    }
                }
                echo '</ul>';
                ?>
            </div>
        </div>

    </body>
</html>

<?php

    // Require the class
    require_once 'image2ascii.class.php';

    // Path to image file
    $filename = '/Users/Chris/php.jpg';

    // Create image object
    // The image2asii constructor takes two optional papameters to set the maximun hight and width.
    // The defualt is set to 640 x 480
    //  Example: $image2ascii = new image2ascii(1024, 768);
    $image2ascii = new image2ascii();
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        span {font-family: monospace; font-weight: bold;  padding: 0; margin: 0; line-height: 0.3em; }
    </style>
</head>
<body>
    <?php echo $image2ascii->getAsciiOutput($filename, 'jpeg'); ?>
</body>
</html>
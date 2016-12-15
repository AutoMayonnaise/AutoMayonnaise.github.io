<?php
// file name: call_python.php
    $fullPath = 'python led.py';
    exec($fullPath);
    echo '<HTML>';
    echo '<head>';
    echo '<title>Pythonのテスト</title>';
    echo '</head>';
    echo '<body>';
    echo '<PRE>';
    var_dump($fullPath);
    echo '<PRE>';
    echo '</body>';
    echo '</HTML>';
?>


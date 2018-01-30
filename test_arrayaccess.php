<?php
/**
 * Date: 2017/12/7
 * @author joker <tanlin@staff.weibo.com>
 */

$dir_iterator = new SplFileObject('func.php');
foreach ($dir_iterator as $line)
    echo "$line\n";

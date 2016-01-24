<?php
require_once("./sort_func.php");
function file_enumeration()
{ 
    $dir = opendir('./upload/');
    if ($dir = opendir('./upload/')) {
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                $info = new SplFileInfo($file);
                $temp = $info->getExtension();
                $color = 0;
                switch ($temp) {
              case 'html':
                $color = 1;
                break;
              case 'swift':
                $color = 2;
                break;
              case 'php':
                $color = 3;
                break;
              case 'c':
                $color = 4;
                break;
              case 'txt':
                $color = 5;
                break;
              case 'rb':
                $color = 6;
                break;
              case 'js':
                $color = 7;
                break;
              case 'css':
                $color = 8;
                break;
              case 'md':
                $color = 9;
                break;
              case 'py':
                $color = 10;
                break;
              case 'java':
                $color = 11;
                break;
            }
                echo '<div class="4u 12u$(medium)"><a><section class="box">
                <i class="icon big rounded color'.$color.' fa-cloud"></i>
                <p style="font-size: 18px;">'.$file.'</p></a>
                <input type="button" name="name" value="download">
                <button class="delete_btn"/>delete
                </section></div>';
            }
        }
        closedir($dir);
    }
}

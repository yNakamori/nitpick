<?php

if ($dir = opendir('../upload/')) {
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            unlink('../upload/'.$file);
        }
    }
    closedir($dir);
}

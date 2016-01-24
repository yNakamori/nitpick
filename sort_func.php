<?php
require_once("./file_data.php");
$colorDict = array(
    "html" => 1,
    "swift" => 2,
    "php" => 3,
    "c" => 4,
    "txt" => 5,
    "rb" => 6,
    "js" => 7,
    "css" => 8,
    "md" => 9,
    "py" => 10,
    "java" => 11,
);
     
function dispFileList($order) {
    $fileView = "";
//    if (isset($_POST["sort_type"]) && !empty($_POST["sort_type"])) {
        $order = htmlspecialchars(@$_POST["sort_type"]);

        // ソートをするためのファイル一覧を取得
        $basePath = opendir('./upload/');
        while (false!==($_items[] = readdir($basePath)));
        closedir($basePath);
        $items = natureSrot($_items, $order);
        // JavaScriptの高階関数のメソッドチェーンみたく
        $fileView = array_reduce(array_map("pushData", array_filter($items, "fileOnly")), "createBox");
        
//    }
    
    return $fileView;
}
function pushData($file)
{
    return new FileData($file, "./upload/" . $file);
}
function fileOnly($file)
{
    return is_file("./upload/" . $file);
}
function createBox($li, $data)
{ 
    global $colorDict;
    
     $info = new SplFileInfo($data->path);
                $extention = $info->getExtension();
        $li .= '<div class="4u 12u$(medium)"><a><section class="box">
                <i class="icon big rounded color'.$colorDict[$extention].' fa-cloud"></i>
                <p style="font-size: 18px;">'.$data->title.'</p></a>
                <input type="button" name="name" value="download">
                <button class="delete_btn"/>delete
                </section></div>';
    return $li;
}
function natureSrot($files, $order)
{
    natcasesort($files);
    if ($order === "asc") {
        return $files;
    } else {
        return array_reverse($files);
    }
}
//require_once("./index.php");

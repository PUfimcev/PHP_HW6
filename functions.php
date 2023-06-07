<?php 


function getList($data)
{
    if(!isset($data)) return;
    $name = basename($data);

    echo '<h3>Список папок и файлов</h3><h4>в директории: '.$name.'</h4>';
    echo "<div style=\"overflow-y: auto;\">";

    if (is_dir($data)) {
        if ($dh = opendir($data)) {
            while (($file = readdir($dh)) !== false) {
                if($file !== "." && $file !== ".."){
                    if(filetype($data.'/'.$file) == 'dir') {
                    echo "<div style=\"background-color: #ded; padding: 0px 0;\";><span>Директория: </span><a stylr=\"display: inlign-block;\" href=\"?dir_folder=$file\" alt=\"$file\">$file</a></div>";
                    } elseif(filetype($data.'/'.$file) == 'file') {

                        $dateCreate = date("d.m.Y H:i:s", filemtime($data.'/'.$file));
                        $fileSize = filesize($data.'/'.$file)/1000;
                        $pathFile = realpath($data.'/'.$file);

                        echo "<p style=\"background-color: #ccc;\">Файл: <strong>$file</strong> , путь файла <strong>$pathFile</strong>, размер <strong>$fileSize</strong> Кб, cоздан <strong>$dateCreate</strong></p>";
                    } 
                }
            }
            closedir($dh);
        }
    }
    echo "</div>";
} 

function getPath($data)
{
    if(!isset($data)) return;

    $data1 = $data["GoUp"] ?? null;
    $data2 = $data["Reset"] ?? null;
    $data4 = $data["dir_folder"] ?? null;
    $currentPath = null;

    if($data1 === null && $data2 === null  && $data4 === null) {
        
        $fd = fopen('./path.txt', 'r');
        $content = fgets($fd);
        if(empty($content)){
            chdir(__DIR__);
            $content = getcwd();
            $currentPath = $content;
        } else {
            $currentPath = $content;
        }
        fclose($fd);
    } else {
        $fd = fopen('./path.txt', 'r');
        $content = fgets($fd);
        $currentPath = $content;
        fclose($fd);
    }


    if($data1 === 'up') {
        $fd = fopen('./path.txt', 'w');
        if($content == '') {
            exit();
        } else {
            $currentPath = dirname($content);
        }
        fwrite($fd, "$currentPath");
        fclose($fd);
    } elseif($data2 === 'default_dir'){
        $fd = fopen('./path.txt', 'w');
        chdir(__DIR__);
        $currentPath = getcwd();
        fwrite($fd, "$currentPath");
        fclose($fd);
    } elseif(!empty($data["dir_folder"]) && $data4 !== null){

        $fd = fopen('./path.txt', 'w');

        $currentPath = $content.'/'.$data["dir_folder"];

        fwrite($fd, "$currentPath");
        fclose($fd);
    }


    return $currentPath;
}


function dirActions($data, $path)
{
    if(!isset($data)) return;

    $data1 = $data["make_dir"] ?? null;
    $data2 = $data["rename_olddir"] ?? null;
    $data3 = $data["name_newdir"] ?? null;
    $data4 = $data["del_dir"] ?? null;

    if($data1 === null && $data2 === null  && $data3 === null && $data4 === null) return;
    
    if(!empty($data1)){
        if(!file_exists($path.'/'.$data1)) mkdir($path.'/'.$data1);
        header("Refresh: 0");
    } elseif(!empty($data2)&& !empty($data3)){
        if(file_exists($path.'/'.$data2) && !file_exists($path.'/'.$data3)) rename($path.'/'.$data2, $path.'/'.$data3);
        header("Refresh: 0");
    } elseif(!empty($data4)){
        if(file_exists($path.'/'.$data4)) rmdir($path.'/'.$data4);
        header("Refresh: 0");
    } 
    // echo "<br>";
    // echo $path;

}

function fileActions($data, $path)
{
    if(!isset($data)) return;

    $data1 = $data["make_file"] ?? null;
    $data2 = $data["rename_oldfile"] ?? null;
    $data3 = $data["name_newfile"] ?? null;
    $data4 = $data["del_file"] ?? null;
    
    if($data1 === null && $data2 === null  && $data3 === null && $data4 === null) return;
    
    if(!empty($data1)){
        if(!file_exists($path.'/'.$data1) && !preg_match('/\w+\.exe$/',$data1)) fopen($path.'/'.$data1, 'w');
        header("Refresh: 0");
    } elseif(!empty($data2)&& !empty($data3)){
        if(file_exists($path.'/'.$data2) && !file_exists($path.'/'.$data3)) rename($path.'/'.$data2, $path.'/'.$data3);
        header("Refresh: 0");
    } elseif(!empty($data4)){
        if(file_exists($path.'/'.$data4)) unlink($path.'/'.$data4);
        header("Refresh: 0");
    } 
}


function fillFile($data, $path)
{
    if(!isset($data)) return;

    $data1 = $data["select_file"] ?? null;
    $data2 = $data["make_content"] ?? null;
    $data3 = $data["select_action"] ?? null;
    
    if($data1 === null && $data2 === null) return;
    if($data3 === '0') return;

    if(!empty($data1) && !preg_match('/\w+\.exe$/',$data1) && file_exists($path.'/'.$data1)){
        switch($data3){
            case 'start':
                $data2 = mb_convert_encoding($data2, 'UTF-8');
                $fd = fopen($path.'/'.$data1, 'w');
                fwrite($fd, $data2);
                fclose($fd);
                header("Refresh: 0");
            break;
            case 'add':
                $data2 = mb_convert_encoding($data2, 'UTF-8');
                $fd = fopen($path.'/'.$data1, 'a');
                fwrite($fd, $data2);
                fclose($fd);
                header("Refresh: 0");
            break;
            case 'del':
                $fd = fopen($path.'/'.$data1, 'w');
                fwrite($fd, '');
                fclose($fd);
                header("Refresh: 0");
            break;
            case 'edit':
                $fd = fopen($path.'/'.$data1, 'r+');

                if(filesize($path.'/'.$data1) > 0) $content = fread($fd, filesize($path.'/'.$data1));
                fclose($fd);
                return $content;
                header("Refresh: 0");
            break;
        }
    }
};

function uploadFile($path)
{
    if(!isset($path)) return;

    $data1 = $_REQUEST["select_dir"] ?? null;
    $data2 = $_FILES["uploaded_files"] ?? null;
    
    if(($data1 === null && $data2 === null) || !$_FILES["uploaded_files"]['name'][0]) return;

    $destinDir = null;
    if(!empty($data1) && file_exists($path.'/'.$data1)) {
        $destinDir = $path.'/'.$data1;
    } elseif(empty($data1) && !file_exists($path.'/upload')) {
        mkdir($path.'/upload');
        $destinDir = $path.'/upload';
    } elseif(empty($data1) && file_exists($path.'/upload')) {
        $destinDir = $path.'/upload';
    }

    $translit = function($str) 
    {
        $russian = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    
        $translit = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');

        return str_replace($russian, $translit, $str);
    };

    $allFiles = scandir($destinDir);

    foreach($_FILES["uploaded_files"]["tmp_name"] as $key => $val){
        if(file_exists($val)){
            $fileInfo = pathinfo($_FILES["uploaded_files"]["name"][$key]);
            $fileName = $translit($fileInfo['filename']);
            $fileName = preg_replace("/[\. \-\&\*\#\@\+\=\!\^]/im", '', $fileName);

            $findFiles = preg_grep("/^".$fileName."(.+)?\.".$fileInfo['extension']."$/",$allFiles);

            $fileUploadName = $fileName.((count($findFiles) > 0) ? '_'.((count($findFiles))+1) : '').'.'.$fileInfo['extension'];

            if(in_array($fileUploadName, $findFiles)) $fileUploadName = $fileName.'.'.$fileInfo['extension'];

            move_uploaded_file($val, $destinDir.'/'.$fileUploadName );
        }

    }
};
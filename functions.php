<?php

//funkcija koja stavlja u niz sve fajlove i dir
//format: 'ime dir' => [fajlovi]
function cleanPath($path) {
    // files////janko/mika

    while (strpos($path, "//") !== FALSE) {
        $path = str_replace("//", "/", $path);
    }

    return $path;
}

function load_arr($path = "files") {


    if (is_dir($path)) {
        $array = scandir($path);
        foreach ($array as $key => $value) {
            if ($value == '.' || $value == '..') {
                unset($array[$key]);
                continue;
            }
            if (is_dir($path . "/" . $value)) {
                $array[$path . "/" . $value] = $array[$key];
                unset($array[$key]);
                $array[$path . "/" . $value] = load_arr($path . "/" . $value);
            }
        }


        arsort($array);
        return $array;
    } else {
        return [];
    }
}

function folder_lists($string) {
    // files/dir/subdir/subsubdir
    //files//
    $n = substr_count($string, "/");
    $n1 = substr_count($string, "//");
    if ($n1 > 0) {
        return [];
    }
    $array = [];
    $string = substr($string, 0, strrpos($string, "/"));
    for ($i = 0; $i < $n; $i++) {
        $array[] = $string;
        $string = substr($string, 0, strrpos($string, "/"));
    }
    krsort($array);
    return $array;
}

// files/pera/majmun/zika
function print_dirs($path = "files") {

    $x = scandir($path);

    static $y = [];
    $subfolder = substr($path, 0, strrpos($path, "/"));
//    $y[] = $subfolder;

    foreach ($x as $key => $value) {

        if ($value == '.' || $value == '..') {
            unset($x[$key]);
            continue;
        }


        if (is_dir($path . "/" . $value)) {
            $y[$path][] = $path . "/" . $value;
          print_dirs($path . "/" . $value);
        }
    }

    return $y;
}

function print_files($path = "files") {
    $x = scandir($path);
    static $y = [];

    foreach ($x as $key => $value) {
        if ($value == '.' || $value == '..') {
            unset($x[$key]);
            continue;
        }
        if (is_file($path . "/" . $value)) {
            $y[] = $path . "/" . $value;
        } else {
            print_files($path . "/" . $value);
        }
    }
    return $y;
}

function print_files_and_dirs($path = "files") {
    $x = scandir($path);
    static $y = [];

    foreach ($x as $key => $value) {
        if ($value == '.' || $value == '..') {
            unset($x[$key]);
            continue;
        }
        $y[] = $path . "/" . $value;
        if (is_dir($path . "/" . $value)) {
            print_files_and_dirs($path . "/" . $value);
        }
    }
    return $y;
}

//function rcopy($oldpath,$newpath)
//{
//    
//    
//}
function dir_is_empty($dir) {
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            closedir($handle);
            return FALSE;
        }
    }
    closedir($handle);
    return TRUE;
}

/*
 * @param $string
 * return boolean
 */

function delete_subs($string) {
    $status = false;
    $niz = print_files_and_dirs($string);
    rsort($niz);
    foreach ($niz as $value) {
        if (is_dir($value)) {
            $status = rmdir($value) ? TRUE : FALSE;
        } else {

            $status = unlink($value) ? TRUE : FALSE;
        }
    }

    return $status;
}


function Pos_of_n_needle_occur($string, $n, $needle = "/") {
    $counter = 0;
    for ($i = 0; $i < strlen($string); $i++) {


        if ($string[$i] === $needle) {
            $counter++;
        }
        if ($n === $counter) {
            return $i;
        }
    }
}

function return_subfolders($path) {
    $array = [];
    //files/tambura/asddsa
    $n = substr_count($path, "/") + 1;
    for ($i = 1; $i <= $n; $i++) {
        if($i !== $n) {
          $array[] = substr($path, 0, Pos_of_n_needle_occur($path, $i));   
        } else {
       
          $array[] = $path;
        }
       
        
    }
    return $array;
}

function Number_of_selects ()
{ 
    $array = print_dirs();
    $max = 1;
    $int = 0;
    foreach ($array as $key => $value) {
        $int = substr_count($key, "/") + 1;
        if($int > $max) {
            $max = $int;
        }
        
    }
    
    
    
    return $max;
}




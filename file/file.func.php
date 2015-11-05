<?php

/**
 * Convert bytes to other units
 * @param unknown $size
 * @return string
 */
function tranBytes($size)
{
    // bytes/Kb/Mb/Tb/Eb
    $arr = array(
        "B",
        "KB",
        "MB",
        "GB",
        "TB",
        "EB"
    );
    $i = 0;
    while ($size >= 1024) {
        $size /= 1024;
        $i ++;
    }
    return round($size, 2) . $arr[$i];
}

function createFile($filename){
    //validate file name to be legable /,*,<,>,?,
    $pattern="/[\/,\\,\*,<>,\?,\|,:]/";
    if(!preg_match($pattern, basename($filename))){
        //check if file name exists in current path
        if(!file_exists($filename)){
            //touch($filename) to create new ile
            if(touch($filename)){
                return "Created file successfully";
            }else{
                return "Failed to create file";
            }
        }else{
            return "File you about to create already exists";
        }
    }else{
        return "Illegle file name";
    }
}
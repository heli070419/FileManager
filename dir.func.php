<?php

/**
 * Read path files, only read the most outside level files
 * @param the path of current file $path
 * @return Ambigous <unknown, string>
 */
function readDirectory($path)
{
    $handle = opendir($path);
    // make sure you are using !== not != since we could have 0.text in file folder.
    while (($item = readdir($handle)) !== false) {
        // . and .. two special directory
        if ($item != "." && $item != "..") {
            if (is_file($path . "/" . $item)) {
                $arr['file'][] = $item;
            }
            if (is_dir($path . "/" . $item)) {
                $arr['dir'][] = $item;
            }
        }
    }
    
    closedir($handle);
    return $arr;
}
<?php
// report all errors but notice error.
// error_reporting(E_ALL & ~E_NOTICE);
require_once 'dir.func.php';
require_once 'file.func.php';
require_once 'common.func.php';
$path = 'file';
isset($_REQUEST['filename']) ? $filename = $_REQUEST['filename'] : null;
isset($_REQUEST['act']) ? $act = $_REQUEST['act'] : null;
$info = readDirectory($path);
$redirect = "index.php?path={$path}";
if (isset($act)) {
    if ($act == "createFile") {
        // create file
        /*
         * echo $path,"---";
         * echo $filename;
         */
        $message = createFile($path . "/" . $filename);
        alertMes($message, $redirect);
    } elseif($act == "showContent") {
        // check the content of the file
        $content = file_get_contents($filename);
        if (strlen($content)) {
            // echo "<textarea readyonly='readonly' cols=100 rows=10>{$content}</textarea>";
            $newContent = highlight_string($content, true);
            // highlight_file($filename);
            $str = <<<EOF
              <table width='100%' bgcolor='#F0F0F0' cellpadding='5' cellspace='0'>
                <tr>
                    <td>{$newContent}</td>
                </tr>
              </table>
EOF;
            echo $str;
        }else{
            alertMes("No File Content Found", $redirect);
        }
    }elseif($act == "editContent"){
        $content = file_get_contents($filename);
        $str = <<<EOF
        <form action='index.php?act=doEdit' method='post'>
            <textarea name='content' cols='190' rows='10'>{$content}</textarea><br />
            <input type='hidden' name='filename' value='{$filename}'/>
            <input type='submit' value='Edit File'/>
        </form>
EOF;
        echo $str;
    }elseif($act == "doEdit"){
        $content = $_REQUEST['content'];
        if(file_put_contents($filename, $content)){
            $message = "Edit File Successfully";
        }else{
            $message = "Failed to edit file";
        }
        alertMes($message, $redirect);
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Online File Manager</title>

<link rel="stylesheet" href="css\cikonss.css" />
<link rel="stylesheet" href="css\common-css.css" />
<link rel="stylesheet" href="css\lightbox.css" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
	integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
	crossorigin="anonymous">
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/eventHandler.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"
	integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ=="
	crossorigin="anonymous"></script>

</head>
<h1>Online File Manager</h1>
<div id="top">
	<button onclick="location.href='index.php';" type="button"
		class="btn btn-default" aria-label="Center Align">
		<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
	</button>
	<button onclick="location.href='#';show('createFile');" type="button"
		class="btn btn-default" aria-label="Center Align">
		<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
	</button>
	<button onclick="location.href='#';show('createFolder')" type="button"
		class="btn btn-default" aria-label="Center Align">
		<span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
	</button>
	<button onclick="location.href='#';show('createFile')" type="button"
		class="btn btn-default" aria-label="Center Align">
		<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
	</button>
	<button onclick="location.href='#';show('createFile')" type="button"
		class="btn btn-default" aria-label="Center Align">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	</button>
</div>
</div>
<form action="index.php" method="post">
	<table class="table table-striped">
		<tr id="createFile" style="display: none;">
			<td>Enter file name</td>
			<td><input type="text" name="filename" /> <input type="hidden"
				name="path" value="<?php echo $path;?>" /> <input type="hidden"
				name="act" value="createFile" /> <input type="submit"
				value="New File" /></td>
		</tr>
		<tr id="createFolder" style="display: none;">
			<td>Enter folder name</td>
			<td><input type="text" name="dirname" /> <input type="submit"
				name="act" value="New Folder" /></td>
		</tr>
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Type</td>
			<td>Size</td>
			<td>Readable</td>
			<td>Writable</td>
			<td>Executable</td>
			<td>Date Created</td>
			<td>Date Modified</td>
			<td>Date Accessed</td>
			<td>Operation</td>
		</tr>
    <?php
    if ($info['file']) {
        $i = 1;
        foreach ($info['file'] as $val) {
            $p = $path . "/" . $val;
            ?>
           <tr>
			<td>
                <?php echo $i;?>
            </td>
			<td>
                <?php echo $val;?>
            </td>
			<td>
                <?php $src=  filetype($p) == "file" ? "file_ico.png" : "folder_ico.png";?><img
				alt="" title="file" src="<?php echo image/$src;?>" />
			</td>

			<td>
                <?php echo tranBytes(filesize($p));?>
            </td>
			<td>
                <?php $src = is_readable($p) ? "correct.png" : "error.png";?> <img
				alt="" src="<?php echo "images/$src"?>" />
			</td>
			<td>
                <?php $src = is_writable($p) ? "correct.png" : "error.png";?> <img
				alt="" src="<?php echo "images/$src"?>" />
			</td>
			<td>
                <?php $src = is_executable($p) ? "correct.png" : "error.png";?> <img
				alt="" src="<?php echo "images/$src"?>" />
			</td>
			<td>
                <?php echo date("y-m-d H:i:s", filectime($p));?>
            </td>
			<td>
                <?php echo date("y-m-d H:i:s", filemtime($p));?>
            </td>
			<td>
                <?php echo date("y-m-d H:i:s", fileatime($p));?>
            </td>

			<td>
			<?php 
                $ext = strtolower(end(explode(".", $val)));
                $imageExt = array(
                "gif",
                "jpg",
                "jpeg",
                "png"
                 );
                 if (in_array($ext, $imageExt)) {
                     ?>
                     <!-- trigger lightbox plugin to show image -->
                     <a href="<?php echo $p;?>" data-title="'<?php echo $val;?>'" rel="lightbox"><img alt="" src="images/show.png" /></a>
                <?php } else {?>
			     <a href="index.php?act=showContent&filename=<?php echo $p;?>"><img alt="" src="images/show.png" /></a>
			     <?php }?>
				 <a href="index.php?act=editContent&filename=<?php echo $p;?>"><img
					alt="" src="images/edit.png" /></a> <a href=""><img alt=""
					src="images/rename.png" /></a> <a href=""><img alt=""
					src="images/copy.png" /></a> <a href=""><img alt=""
					src="images/cut.png" /></a> <a href=""><img alt=""
					src="images/delete.png" /></a> <a href=""><img alt=""
					src="images/download.png" /></a>
			</td>
		</tr>
           <?php
            $i ++;
        }
    }
    ?>
</table>
</form>
<script type="text/javascript" src="js/lightbox.js"></script>
</html>
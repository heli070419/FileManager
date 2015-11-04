<?php
// report all errors but notice error.
//error_reporting(E_ALL & ~E_NOTICE);

require_once 'dir.func.php';
require_once 'file.func.php';
require_once 'common.func.php';
$path = 'file';
isset($_REQUEST['filename'])? $filename = $_REQUEST['filename'] : null;
isset($_REQUEST['act'])? $act = $_REQUEST['act'] : null;
$info = readDirectory($path);
$redirect = "index.php?path={$path}";

if(isset($act) && $act == "createFile"){
    //create file
   /*  echo $path,"---";
    echo $filename; */
  $message =  createFile($path."/".$filename);
  alertMes($message, $redirect);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<style type="text/css">
body, div, p, ul, ol, table, dl, dd, dt {
	margin: 0;
	padding: 0;
}

a {
	text-decoration: none;
}

ul, li {
	float: left;
	list-style: none;
}

#top {
	width: 100%;
	height: 18px;
	margin: 0 auto;
	background: #E2E2E2;
}

#navi a {
	display: block;
	width: 　48px;
	height: 18px;
}

#main {
	margin: 0 auto;
	border: 2px solid #ABCDEF;
}

img {
	width: 25px;
	height: 25px;
	border: 0;
}
</style>
<script type="text/javascript">
	function show(dis){
		document.getElementById(dis).style.display="block";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Online File Manager</title>
<link rel="stylesheet" href="cikonss.css" />
</head>
<h1>Online File Manager</h1>
<div id="top">
	<ul id="navi">
		<li><a href="index.php" title="main menu"><span
				style="margin-left: 8px; margin-top: 0px;" class="icon icon-small"><span
					class="icon-home"></span></span></a></li>
		<li><a href="#" onclick="show('createFile')" title="New File"><span
				style="margin-left: 8px; margin-top: 0px;" class="icon icon-small"><span
					class="icon-file"></span></span></a></li>
		<li><a href="#" onclick="show('createFolder')" title="New Folder"><span
				style="margin-left: 8px; margin-top: 0px;" class="icon icon-small"><span
					class="icon-folder"></span></span></a></li>
		<li><a href="#" onclick="show('updateFile')" title="Update File"><span
				style="margin-left: 8px; margin-top: 0px;" class="icon icon-small"><span
					class="icon-upload"></span></span></a></li>
		<li><a href="#" onclick="" title="Return"><span
				style="margin-left: 8px; margin-top: 0px;" class="icon icon-small"><span
					class="icon-arrowleft"></span></span></a></li>
	</ul>
</div>
<form action="index.php" method="post" >
<table width="100%" border="1" cellpadding="5" cellspacing="0"
	bgcolor="#ABCDEF" align="center">
	<tr id="createFile" style="display: none;">
	   <td>Enter file name
	   </td>
	   <td>
	       <input type="text" name="filename"/>
	       <input type="hidden" name="path" value="<?php echo $path;?>"/>
	       <input type="hidden" name="act" value="createFile"/>
	       <input type="submit" value="New File"/>
	   </td>
	</tr>
	<tr id="createFolder" style="display: none;">
	   <td>Enter folder name
	   </td>
	   <td>
	       <input type="text" name="dirname"/>
	        <input type="submit" name="act" value="New Folder"/>
	   </td>
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
		<td><a href=""><img alt="" src="images/show.png" /></a> 
		<a href=""><img alt=""
				src="images/edit.png" /></a> 
		<a href=""><img alt=""
				src="images/rename.png" /></a> 
		<a href=""><img alt=""
				src="images/copy.png" /></a> 
		<a href=""><img alt=""
				src="images/cut.png" /></a>
		<a href=""><img
				alt="" src="images/delete.png" /></a> 
		<a href=""><img
				alt="" src="images/download.png" /></a> 		
		</td>
	</tr>
           <?php
            $i ++;
        }
    }
    ?>
</table>
</form>
</html>
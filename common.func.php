<?php
/**
 * alert operation message,and redirect
 * @param string $message
 * @param string $url
 */
function alertMes($mes,$url){
	echo "<script type='text/javascript'>alert('{$mes}');location.href='{$url}';</script>";
}
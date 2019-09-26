<?php
namespace Kieran\Models;

if (!in_array(__FILE__, get_included_files()) || $_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	header('HTTP/1.1 404 Not found');
	exit;
}

/**
 * 
 * @author Kieran Anderson <kieran@andersons.bz>
 * @date 16:15 2019/9/26
 */ 
class Modal {

    // The number of occourences for the values
    public /* int */ $Frequency;

    // Values found
    public /* float[] */ $Values = [];

}
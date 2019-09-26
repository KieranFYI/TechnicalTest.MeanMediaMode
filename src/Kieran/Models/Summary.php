<?php
namespace Kieran\Models;

if (!in_array(__FILE__, get_included_files()) || $_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	header('HTTP/1.1 404 Not found');
	exit;
}

/**
 * Summary of all the sale data
 *
 * @author Kieran Anderson <kieran@andersons.bz>
 * @date 16:27 2019/9/26
 */ 
class Summary {

    // Total value of all sales
    public /* float */ $Total;

    // Average value of all sales
    public /* float */ $Mean;

    // Values that occour the most often
    public /* float[] */ $Modal = [];

    // The frequency of the modal
    public /* int */ $Frequency;

    // Median value of all sales
    public /* float */ $Median;

}
<?php
namespace Kieran\Models;

if (!in_array(__FILE__, get_included_files()) || $_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	header('HTTP/1.1 404 Not found');
	exit;
}

/**
 * Contains data for a sale
 *
 * @author Kieran Anderson <kieran@andersons.bz>
 * @date 16:15 2019/9/26
 */ 
class SaleRecord {

    // Id of the record
    public /* int */ $Record;

    // Value of the sale
    public /* float */ $SaleAmount;

}
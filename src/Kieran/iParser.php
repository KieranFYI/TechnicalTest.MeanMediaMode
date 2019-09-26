<?php
namespace Kieran;

if (!in_array(__FILE__, get_included_files()) || $_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	header('HTTP/1.1 404 Not found');
	exit;
}

/**
 * The interface required to be used by all prasers
 *
 * @author Kieran Anderson <kieran@andersons.bz>
 * @date 16:15 2019/9/26
 */ 
interface iParser {

    /**
     * Determine if this parser can handle the file type
     * 
	 * @param string   $fileExtension	The extensions of the file to be parsed
     * 
     * @author Kieran Anderson <kieran@andersons.bz>
     * @date 16:18 2019/9/26
     * @return bool
     */
    public function /* bool */ CanParse(string $fileExtension);

    /**
     * Parse the file and return 
     * 
	 * @param string   $fileToParse	The file that will be parsed
     * 
     * @author Kieran Anderson <kieran@andersons.bz>
     * @date 16:18 2019/9/26
     * @return SaleRecord[]
     */
    public function /* SaleRecord[] */ Parse(string $filePath);

}
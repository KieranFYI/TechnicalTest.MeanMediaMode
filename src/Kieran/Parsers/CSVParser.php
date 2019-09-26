<?php
namespace Kieran\Parsers;

if (!in_array(__FILE__, get_included_files()) || $_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	header('HTTP/1.1 404 Not found');
	exit;
}

use \Kieran\iParser;
use \Kieran\Models\SaleRecord;
/**
 * Handles parsing of CSV files
 *
 * @author Kieran Anderson <kieran@andersons.bz>
 * @date 17:02 2019/9/26
 */ 
class CSVParser implements iParser {

    /**
     * Determine if this parser can handle the file type
     * 
	 * @param string   $fileExtension	The extensions of the file to be parsed
     * 
     * @author Kieran Anderson <kieran@andersons.bz>
     * @date 17:02 2019/9/26
     * @return bool
     */
    public function /* bool */ CanParse(string $fileExtension) {
        return strcmp('csv', $fileExtension) === 0;
    }

    /**
     * Parse the file and return 
     * 
	 * @param string   $fileToParse	The file that will be parsed
     * 
     * @author Kieran Anderson <kieran@andersons.bz>
     * @date 17:02 2019/9/26
     * @return SaleRecord[]
     */
    public function /* SaleRecord[] */ Parse(string $filePath) {
        if (!file_exists($filePath)) {
            throw new \Exception('Unable to locate file - ' . $filePath);
        }

        /* SaleRecord[] */ $records = [];

        // Open the file for reading
        $file = fopen($filePath, 'r');
        $lineNum = 0;
        // Read the file line by line until no more lines are available
        while (($line = fgetcsv($file)) !== FALSE) {
            // If the value of the first column is not a string and it's the first line, skip as it could be headers
            if (!is_numeric($line[0]) && $lineNum == 0) {
                $lineNum++;
                continue;
            } else if (!is_numeric($line[0]) || !is_numeric($line[1])) {
                // As the expected data is numeric, throw an error if the data doesnt match
                throw new \Exception('Invalid data provided on line ' . $line);
            }
            
            // Create a SaleRecord to store the data for the line
            $record = new SaleRecord();
            $record->Record = $line[0];
            $record->SaleAmount = $line[1];

            // Store the record in the array for use later
            $records[] = $record;
            $lineNum++;
        }
        fclose($file);

        return $records;
    }

}
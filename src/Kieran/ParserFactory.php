<?php
namespace Kieran;

if (!in_array(__FILE__, get_included_files()) || $_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	header('HTTP/1.1 404 Not found');
	exit;
}

use \Kieran\iParser;

/**
 * Finds and creates the parser required for the file provided
 *
 * @author Kieran Anderson <kieran@andersons.bz>
 * @date 16:06 2019/9/26
 */ 
class ParserFactory {

	private static /* iParser */ $Parsers = [];

	/**
	 * Loads all the prasers
	 *
	 * @throws Exception	Thrown if the directory doesnt exist
	 * @author Kieran Anderson <kieran@andersons.bz>
	 * @date 16:11 2019/9/26
	 */ 
	public static function Load() { 
		$directory = SRC . 'Kieran/Parsers';
		if (!file_exists($directory)) {
            throw new \Exception('Unable to load parsers from directory - ' . $directory);
        }

		// Scan the directory and get all the files, removing . (current directory) and .. (up a directory)
        $files = array_diff(scandir($directory), array('..', '.'));
		foreach ($files as $file) {

			// Check the file is a php file
			if (stripos($file, '.php') != (strlen($file) - 4)) {
				continue;
			}

			// Get the name of the file without the extension
			$fileName = basename($file, '.php');

			// Build an instance of the class
			$parserClass = 'Kieran\\Parsers\\' . $fileName;
			$parser = new $parserClass();
			
			// Check to ensure the parser implements the type Kieran\iParser
			if (!isset(class_implements($parser)['Kieran\\iParser'])) {
				continue;
			}

			// Add the parser to the list of prasers available
			self::$Parsers[] = $parser;
		}
	}

	/**
	 * Returns a praser for the file required
	 *
	 * @param string   $fileToParse	The file that will be parsed
	 * 
	 * @throws Exception	Thrown if the we are unable to find a parser for the file provided
	 * @author Kieran Anderson <kieran@andersons.bz>
	 * @date 16:46 2019/9/26
     * @return iParser
	 */ 
	public static function /* iParser */ GetParser($fileToParse) {
		if (!count(self::$Parsers)) {
            throw new \Exception('No parsers currently loaded');
		}

		// Get the base name for the file and attempt to find the extension position
		$fileName = basename($fileToParse);
		$extensionPosition = strpos($fileName, '.');
		$fileExtension = null;
		// If the fileName doesnt contain '.' use the full filename for the extension
		// This might happen if someone passes in the required extension instead of the full file path
		if ($extensionPosition === false) {
			$fileExtension = $fileName;
		} else {
			$fileExtension = substr($fileName, $extensionPosition + 1);
			$fileExtension = trim(strtolower($fileExtension));
		}

		$parser = null;

		// Check the parsers until one that can handle the extension is found
		foreach(self::$Parsers as $_parser) {
			if (!$_parser->CanParse($fileExtension)) {
				continue;
			}

			$parser = $_parser;
			break;
		}

		// if we cant find a parser, throw an error indicating the issue
		if ($parser == null) {
            throw new \Exception('Unable to identify parser for extension - ' . $fileExtension);
		}

		return $parser;
	}


}
<?php
namespace Kieran;

if (!in_array(__FILE__, get_included_files()) || $_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	header('HTTP/1.1 404 Not found');
	exit;
}

/**
 * Simple auto loader
 * Handles auto loading of required files
 *
 * @author Kieran Anderson <kieran@andersons.bz>
 * @date 20:50 2018/3/27
 */ 
class AutoLoader {


	/**
	 * The location to use when attempting to load classes
	 *
	 * @author Kieran Anderson <kieran@andersons.bz>
	 * @date 21:15 2018/3/27
	 */ 
	private static $Directory = './';

	/**
	 * Set the directory to load classes from
	 *
	 * @param string   $directory	The directory to load from
	 *
	 * @author Kieran Anderson <kieran@andersons.bz>
	 * @date 21:16 2018/3/27
	 */ 
	public static function SetDirectory(string $directory) {
		$directory = realpath($directory);
		if ($directory[strlen($directory) - 1] != '/') {
			$directory .= '/';
		}

		self::$Directory = $directory;
	}

	/**
	 * Attemps to load a class
	 *
	 * @param string   $class	The class to load
	 * 
	 * @throws Exception	Thrown if no class can be found
	 * @author Kieran Anderson <kieran@andersons.bz>
	 * @date 20:51 2018/3/27
	 */ 
	public static function Load(string $class) {
		$filePath = self::$Directory . str_replace('\\', '/', $class) . '.php';
	
		if (file_exists($filePath)) {
			require_once($filePath);
		} else {
            throw new \Exception('Missing Import - ' . $filePath);
        }
	}
}
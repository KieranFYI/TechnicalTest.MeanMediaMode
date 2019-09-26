<?php
namespace Kieran\Math;

if (!in_array(__FILE__, get_included_files()) || $_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	header('HTTP/1.1 404 Not found');
	exit;
}

use \Kieran\Models\SalesRecord;
use \Kieran\Models\Modal;

/**
 * Math functions to help with calculations for sale records
 *
 * @author Kieran Anderson <kieran@andersons.bz>
 * @date 16:32 2019/9/26
 */ 
class SalesRecordMath {

	/**
     * Get the total from all the records
     * 
	 * @param SalesRecord[]   $records	The records to get the total of
     * 
     * @author Kieran Anderson <kieran@andersons.bz>
     * @date 17:29 2019/9/26
     * @return float
     */
    public static function /* float */ GetTotal(/* SalesRecord[] */ array $records) {
		$total = 0;

		foreach($records as $record) {
			$total += $record->SaleAmount;
		}

        return round($total, 2);
	}

	/**
     * Get the modal for the records
     * 
	 * @param SalesRecord[]   $records	The records to get the modal of
     * 
     * @author Kieran Anderson <kieran@andersons.bz>
     * @date 17:46 2019/9/26
     * @return Modal
     */
    public static function /* Modal */ GetModal(/* SalesRecord[] */ array $records) {
		$values = [];

		$highestFrequency = 0;

		// Calculate the highest frequency available in the array
		foreach($records as $record) {
			// Store the total count of each sale amount for use later
			if (isset($values[$record->SaleAmount])) {
				$values[$record->SaleAmount]++;
			} else {
				$values[$record->SaleAmount] = 1;
			}

			// If the frequency for the curreny sale is higher than the previous, replace it
			if ($highestFrequency < $values[$record->SaleAmount]) {
				$highestFrequency = $values[$record->SaleAmount];
			}
		}

		// Create the modal to return the data
		$modal = new Modal();
		// Assign the highest frequency we found
		$modal->Frequency = $highestFrequency;
		
		// Loop the stored values and frequencys and find all values that match the highest frequency
		foreach($values as $value => $frequency) {
			if ($frequency == $highestFrequency) {
				// Add the SaleAmount to the modal values
				$modal->Values[] = round($value, 2);
			}
		}
		
        return $modal;
	}

	/**
     * Get the median for the records
     * 
	 * @param SalesRecord[]   $records	The records to get the median of
     * 
     * @author Kieran Anderson <kieran@andersons.bz>
     * @date 17:55 2019/9/26
     * @return float
     */
    public static function /* float */ GetMedian(/* SalesRecord[] */array $records) {
		
		$recordsGrouped = [];

		// Loop all the records, grouping records by SaleAmount
		foreach($records as $record) {
			if (!isset($recordsGrouped[$record->SaleAmount])) {
				$recordsGrouped[$record->SaleAmount] = [];
			}

			$recordsGrouped[$record->SaleAmount][] = $record;
		}

		// Get the keys for the grouped records and order them
		$keys = array_keys($recordsGrouped);
		$totalKeys = count($recordsGrouped);
		for($i = 0; $i < $totalKeys; $i++) {
			for($x = $i; $x < $totalKeys; $x++) {
				if ($keys[$x] < $keys[$i]) {
					$oldKey = $keys[$i];
					$keys[$i] = $keys[$x];
					$keys[$x] = $oldKey;
				}
			}
		}

		// Using the order of the keys, group the records back into a single array
		$records = [];
		foreach($keys as $key) {
			foreach($recordsGrouped[$key] as $record) {
				$records[] = $record;
			}
		}
		
		$totalRecords = count($records);
		if (($totalRecords % 2) == 0) {
			// If the total records is even, get the middle two values and find the mean of them
			$i = floor($totalRecords / 2);
			$value = $records[$i - 1]->SaleAmount + $records[$i]->SaleAmount;
			return round($value / 2, 2);
		} else {
			// Return the middle value of the array
			$i = floor($totalRecords / 2) - 1;
			return round($records[$i]->SaleAmount, 2);
		}
	}
}
<?php
/* * *******************************************************************************
 * The content of this file is subject to the PDF Maker license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

class PDFMaker_Field_Model extends Vtiger_Field_Model {
    /**
	 * Function to get all the supported advanced filter operations
	 * @return <Array>
	 */
	public static function getAdvancedFilterOptions() {
		return array(
			'is' => 'is',
			'contains' => 'contains',
			'does not contain' => 'does not contain',
			'starts with' => 'starts with',
			'ends with' => 'ends with',
			'is empty' => 'is empty',
			'is not empty' => 'is not empty',
			'less than' => 'less than',
			'greater than' => 'greater than',
			'does not equal' => 'does not equal',
			'less than or equal to' => 'less than or equal to',
			'greater than or equal to' => 'greater than or equal to',
			'before' => 'before',
			'after' => 'after',
			'between' => 'between',
		);
	}

	/**
	 * Function to get the advanced filter option names by Field type
	 * @return <Array>
	 */
	public static function getAdvancedFilterOpsByFieldType() {
		return array(
			'string' => array('is', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'salutation' => array('is', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'text' => array('is', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'url' => array('is', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'email' => array('is', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'phone' => array('is', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'integer' => array('equal to', 'less than', 'greater than', 'does not equal', 'less than or equal to', 'greater than or equal to'),
			'double' => array('equal to', 'less than', 'greater than', 'does not equal', 'less than or equal to', 'greater than or equal to'),
			'currency' => array('equal to', 'less than', 'greater than', 'does not equal', 'less than or equal to', 'greater than or equal to', 'is not empty'),
			'picklist' => array('is', 'is not', 'is empty', 'is not empty'),
			'multipicklist' => array('is', 'is not'),
			'datetime' => array('is', 'is not', 'less than hours before', 'less than hours later', 'more than hours before', 'more than hours later'),
			'time' => array('is', 'is not', 'is not empty'),
			'date' => array('is', 'is not', 'between', 'before', 'after', 'is today', 'less than days ago', 'more than days ago', 'in less than', 'in more than', 'days ago', 'days later', 'is not empty'),
			'boolean' => array('is', 'is not'),
			'reference' => array('is', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'owner' => array('is', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'recurrence' => array('is', 'is not'),
			'comment' => array('is'),
                        'image' => array('is', 'is not', 'contains', 'does not contain', 'starts with', 'ends with', 'is empty', 'is not empty'),
			'percentage' => array('equal to', 'less than', 'greater than', 'does not equal', 'less than or equal to', 'greater than or equal to', 'is not empty'),
                        'documentsFolder' => array('is', 'contains', 'does not contain', 'starts with', 'ends with'),
		);
	}
}
<?php	
class Quickbooks {
 	
 	/**
	* Invoked when special actions are performed on the module.
	* @param String Module name
	* @param String Event Type
	*/
 	function vtlib_handler($moduleName, $eventType) {
 					
		 	
		global $adb;
 		
 		if($eventType == 'module.postinstall') {			
			# TODO Handle actions when this module is disabled.
			
			#copy the file from temp to root 
			$this->copy_r( 'modules/Quickbooks/temp/root/cron/modules/', 'cron/modules/' );
			$this->copy_r( 'modules/Quickbooks/temp/root/quickbooks/', 'quickbooks/' );			
			
			#Inserting Querys for Qb Field Settings
			$querys = $this->getQuerys();
			foreach($querys as $key=>$query){
				$adb->query($query);
			}		 
			
			
		} else if($eventType == 'module.disabled') {
			// TODO Handle actions when this module is disabled.
		} else if($eventType == 'module.enabled') {
			// TODO Handle actions when this module is enabled.
		} else if($eventType == 'module.preuninstall') {
			// TODO Handle actions when this module is about to be deleted.
		} else if($eventType == 'module.preupdate') {
			// TODO Handle actions before this module is updated.
		} else if($eventType == 'module.postupdate') {
			# TODO Handle actions after this module is updated.
			
			#copy the file from temp to root 
			$this->copy_r( 'modules/Quickbooks/temp/root/cron/modules/', 'cron/modules/' );
			$this->copy_r( 'modules/Quickbooks/temp/root/quickbooks/', 'quickbooks/' );			
			
			#Inserting Querys for Qb Field Settings
			$querys = $this->getQuerys();
			foreach($querys as $key=>$query){
				$adb->query($query);
			} 
			

		}
 	}

	public function getQuerys(){
		$q[] = "INSERT INTO quickbooks_fields (id, qb_field_name, module, vtiger_field, flag) VALUES
		(1, 'First Name', 'Contacts', 'First Name', 1),
		(2, 'Last Name', 'Contacts', 'Last Name', 1),
		(3, 'Company Name', 'Contacts', 'Account Name', 1),
		(4, 'Phone', 'Contacts', 'Home Phone', 1),
		(5, 'Mobile', 'Contacts', 'Mobile', 1),
		(6, 'Other Phone', 'Contacts', 'Other Phone', 1),
		(7, 'Fax', 'Contacts', 'Fax', 1),
		(8, 'Email', 'Contacts', 'Email', 1),
		(9, 'Street', 'Contacts', 'Mailing Street', 1),
		(10, 'City', 'Contacts', 'Mailing City', 1),
		(11, 'State', 'Contacts', 'Mailing State', 1),
		(12, 'Zip', 'Contacts', 'Mailing Zip', 1),
		(13, 'Country', 'Contacts', 'Mailing Country', 1),
		(14, 'Notes', 'Contacts', 'Description', 1),
		(15, 'Customer Name', 'Invoice', 'Contact Name', 1),
		(16, 'Invoice No', 'Invoice', 'Invoice No', 1),
		(17, 'Invoice Date', 'Invoice', 'Invoice Date', 1),
		(18, 'Invoice Due Date', 'Invoice', 'Due Date', 1),
		(19, 'Bill Address', 'Invoice', 'Billing Address', 1),
		(20, 'Ship Address', 'Invoice', 'Shipping Address', 1),
		(21, 'Products', 'Invoice', 'Item Name', 1),
		(22, 'Quantity', 'Invoice', 'Quantity', 1),
		(23, 'List Price', 'Invoice', 'List Price', 1),
		(24, 'Tax', 'Invoice', 'S&H Amount', 1),
		(25, 'Discount', 'Invoice', 'Discount Amount', 1),
		(26, 'Shipping', 'Invoice', 'Shipping Address', 1),
		(27, 'Shipping Address', 'Invoice', 'Shipping Address', 1),
		(28, 'Name', 'Products', 'Product Name', 1),
		(29, 'Price', 'Products', 'Usage Unit', 1),
		(30, 'Description', 'Products', 'Description', 1),
		(31, 'Name', 'Services', 'Service Name', 1),
		(32, 'Price', 'Services', 'Price', 1),
		(33, 'Description', 'Services', 'Description', 1),
		(34, 'Name', 'Vendors', 'Vendor Name', 1),
		(35, 'Email', 'Vendors', 'Email', 1),
		(36, 'Phone', 'Vendors', 'Phone', 1),
		(37, 'Website', 'Vendors', 'Website', 1),
		(38, 'Street', 'Vendors', 'Street', 1),
		(39, 'City', 'Vendors', 'City', 1),
		(40, 'State', 'Vendors', 'State', 1),
		(41, 'Zip', 'Vendors', 'Postal Code', 1),
		(42, 'Inventory Start Date', 'Services', 'Sales Start Date', 1),
		(43, 'Inventory Start Date', 'Products', 'Sales Start Date', 1),
		(44, 'Qty in Stock', 'Products', 'Qty In Stock', 1)";
		
		#Quickbooks sync History table
		$q[] = "CREATE TABLE IF NOT EXISTS quickbooks_sync_history (
						id int(11) unsigned NOT NULL AUTO_INCREMENT,
						module varchar(255) NOT NULL,
						type varchar(255) NOT NULL,
						records varchar(50) NOT NULL,
						date datetime NOT NULL,
						PRIMARY KEY (id)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

		#add quickbooks id for every module which is used
		$q[] ="ALTER TABLE  vtiger_contactdetails ADD  quickbook_id VARCHAR( 50 ) NULL AFTER  isconvertedfromlead";
		$q[] ="ALTER TABLE  vtiger_account ADD  quickbook_id VARCHAR( 50 ) NULL AFTER  isconvertedfromlead";
		$q[] ="ALTER TABLE  vtiger_service ADD  quickbook_id VARCHAR( 50 ) NULL AFTER  commissionrate";
		$q[] ="ALTER TABLE  vtiger_products ADD  quickbook_id VARCHAR( 50 ) NULL AFTER  currency_id";
		$q[] ="ALTER TABLE  vtiger_vendor ADD  quickbook_id VARCHAR( 50 ) NULL AFTER  description";
		$q[] ="ALTER TABLE  vtiger_invoice ADD  quickbook_id VARCHAR( 50 ) NULL AFTER  s_h_percent";
		
		#add fields to vtiger_fields table
		$q[] = "INSERT INTO vtiger_field (tabid, columnname, tablename, generatedtype, uitype, fieldname, fieldlabel, readonly, presence, defaultvalue, maximumlength, sequence, block, displaytype, typeofdata, quickcreate, quickcreatesequence, info_type, masseditable, helpinfo, summaryfield) VALUES
				(4,'quickbook_id', 'vtiger_contactdetails', 2, '1', 'quickbook_id', 'Quickbook id', 1, 2, '', 100, 2, 73, 1, 'V~O~LE~50', 1, NULL, 'BAS', 1, '', 0),
				(6, 'quickbook_id', 'vtiger_account', 2, '1', 'quickbook_id', 'Quickbook id', 1, 2, '', 100, 2, 12, 1, 'V~O~LE~50', 1, NULL, 'BAS', 1, '', 0),
				(14, 'quickbook_id', 'vtiger_products', 2, '1', 'quickbook_id', 'Quickbook id', 1, 2, '', 100, 2, 36, 1, 'V~O~LE~50', 1, NULL, 'BAS', 1, '', 0),
				(34, 'quickbook_id', 'vtiger_service', 2, '1', 'quickbook_id', 'Quickbook id', 1, 2, '', 100, 2, 93, 1, 'V~O~LE~50', 1, NULL, 'BAS', 1, '', 0),
				(18, 'quickbook_id', 'vtiger_vendor', 2, '1', 'quickbook_id', 'Quickbook id', 1, 2, '', 100, 2, 45, 1, 'V~O~LE~50', 1, NULL, 'BAS', 1, '', 0),
				(23, 'quickbook_id', 'vtiger_invoice', 2, '1', 'quickbook_id', 'Quickbook id', 1, 2, '', 100, 16, 67, 1, 'V~O~LE~50', 3, 2, 'BAS', 1, '', 0)";
		#update vtiger_field_seq table
		$q[] = "update vtiger_field_seq set id=id+6 ";

		return $q;
	}
		
	function copy_r( $path, $dest ) {
        if( is_dir($path) ) {
            //@mkdir( $dest );
            @mkdir( $dest ,0777,true);
            $objects = scandir($path);
            if( sizeof($objects) > 0 ) {
                foreach( $objects as $file ) {
                    if( $file == "." || $file == ".." )
                        continue;
                    // go on
                    if( is_dir( $path.DIRECTORY_SEPARATOR.$file ) ) {
                        $this->copy_r( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
                    }
                    else {
						// TODO Must save existing script copies for rollback
						//$this->vtFileCopy($dest.DIRECTORY_SEPARATOR.$file);
                        $crslt = copy( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
						/*if ($crslt) {
							//echo "Copied ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file."<br>";
							$this->copiedFiles[] = "Copied ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file;
						}
						else {
							$this->failedCopies[] = "Could not copy ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file;
						}*/
                    }
                }
            }
           // return true;
        }
        elseif( is_file($path) ) {
			$crslt = copy($path, $dest);
			if ($crslt)
			{
				//echo "Copied ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file."<br>";
				//$this->copiedFiles[] = "Copied ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file;
			}
			else {
				//echo "<font color=red>Could not copy ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file."</font><br>";
				//$this->failedCopies[] = "Could not copy ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file;
			}
           // return $crslt;
        }
        else {
            //return false;
        }
    } 
}
?>

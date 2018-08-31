<?php
/* ********************************************************************************
 * The content of this file is subject to the Related Record Update(Workflow) ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** */
class SumField_VTELicense_Model {
    var $module = "";
    var $cypher = "VTE is encrypting its files to prevent unauthorized distribution";
    var $result = "";
    var $message = "";
    var $valid = false;
    var $file = "";
    var $site_url = "";
    var $license = "";


    function  __construct($module="") {
        global $_REQUEST,$currentModule,$root_directory,$site_URL;

        if(substr($site_URL,-1) != "/") {
            $site_URL.="/";
        }
        $this->site_url = $site_URL;
        if($module!="") { $this->module = $module; }
        if($this->module == "") { $this->module = $currentModule; }
        if($this->file == "") {
            if(substr($root_directory,-1) != "/" && substr($root_directory,-1) != "\\") { $root_directory.="/"; }
            $this->file = $root_directory."test/".$this->module.".vte";
        }
    }

    function getLicenseInfo() {
        global $root_directory, $site_URL;
        if(substr($site_URL,-1) != "/") {
            $site_URL.="/";
        }
        $input = $this->decrypt(file_get_contents($this->file));
        $module = $this->gssX($input,"<module>","</module>");
        $site_url = $this->gssX($input,"<site_url>","</site_url>");
        $license = $this->gssX($input,"<license>","</license>");
        $expiration_date = $this->gssX($input,"<expiration_date>","</expiration_date>");
        $date_created = $this->gssX($input,"<date_created>","</date_created>");
        if(substr($root_directory,-1) != "/" && substr($root_directory,-1) != "\\") {
            $root_directory.="/";
        }
        if(strtolower($module) != strtolower($this->module) || $this->urlClean(strtolower($site_url)) != $this->urlClean(strtolower($this->site_url))) {
            return false;
        }else {
            return array(
                'module' => $module,
                'site_url' => $site_url,
                'license' => $license,
                'expiration_date' => $expiration_date,
                'date_created' => $date_created,
            );
        }
        return false;
    }

    function readLicenseFile() {
        global $root_directory, $site_URL;
        if(substr($site_URL,-1) != "/") {
            $site_URL.="/";
        }
        $input = $this->decrypt(file_get_contents($this->file));
        $module = $this->gssX($input,"<module>","</module>");
        $site_url = $this->gssX($input,"<site_url>","</site_url>");
        $license = $this->gssX($input,"<license>","</license>");
//echo $license;
        if(substr($root_directory,-1) != "/" && substr($root_directory,-1) != "\\") {
            $root_directory.="/";
        }
        if(strtolower($module) != strtolower($this->module) || $this->urlClean(strtolower($site_url)) != $this->urlClean(strtolower($this->site_url))) {
            return false;
        }else{
            try {
                $data = "<data>
                <license>$license</license>
                <site_url>$site_url</site_url>
                <module>$module</module>
                <uri>{$_SERVER['REQUEST_URI']}</uri>
                </data>";
                $client = new SoapClient("http://license.vtexperts.com/license/soap.php?wsdl",array('trace' => 1,'exceptions' => 0,'cache_wsdl' => WSDL_CACHE_NONE));
                $arr = $client->validate($data);

                $this->result = $arr["result"];
                $this->message = $arr["message"];
                $this->expiration_date = $arr["expiration_date"];
                $this->date_created = $arr["date_created"];

                $this->createVTEFile($module, $site_url, $license);
            }
            catch(Exception $exception) {
                $this->result = "bad";
                $this->message = "Unable to connect to licensing service. Please either check the server's internet connection, or proceed with offline licensing.<br>";
            }

            if($this->message != "") { $errormsg = "License Failed with message: ".$this->message."<br>"; }
            else { $errormsg = "Invalid License<br>"; }
            $errormsg .="Please try again or contact <a href='http://www.vtexperts.com/' target='_new'>vTiger Experts</a> for assistance.";
            $this->message=$errormsg;

            if($this->result == "ok" || $this->result == "valid") {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
    function validate() {
        if(file_exists($this->file)) {
            $this->readLicenseFile();
        } else {
            $this->checkValidate();
        }
        if($this->result == "ok" || $this->result == "valid") {
            return true;
        } else {
            global $adb;
            $adb->pquery("DELETE FROM `vte_modules` WHERE module=?;",array('SumField'));
            $adb->pquery("INSERT INTO `vte_modules` (`module`, `valid`) VALUES (?, ?);",array('SumField','0'));
            return false;
        }
    }

    function releaseLicense($info) {
        $license=$info['license'];
        $site_url=$info['site_url'];
        $module=$info['module'];
        try {
            $data = "<data>
                <license>$license</license>
                <site_url>$site_url</site_url>
                <module>$module</module>
                <uri>{$_SERVER['REQUEST_URI']}</uri>
                </data>";
            $client = new SoapClient("http://license.vtexperts.com/license/soap.php?wsdl",array('trace' => 1,'exceptions' => 0,'cache_wsdl' => WSDL_CACHE_NONE));
            $arr = $client->releaseLicense($data);

            if(file_exists($this->file)) {
                unlink($this->file);
            }
            global $adb;
            $adb->pquery("DELETE FROM `vte_modules` WHERE module=?;",array('SumField'));
            $adb->pquery("INSERT INTO `vte_modules` (`module`, `valid`) VALUES (?, ?);",array('SumField','0'));
            return true;
        }
        catch(Exception $exception) {
            return false;
        }
    }

    function activateLicense($data) {
        global $_POST, $root_directory, $site_URL;
        $site_url = $data["site_url"];
        $license = $data["license"];
        $this->site_url = $site_url;
        $this->license = $license;

        $this->checkValidate();
        if($this->result == "bad" || $this->result == "invalid") {
            if($this->message != "") { $errormsg = "License Failed with message: ".$this->message."<br>"; }
            else { $errormsg = "Invalid License<br>"; }
            $errormsg .="Please try again or contact <a href='http://www.vtexperts.com/' target='_new'>vTiger Experts</a> for assistance.";
            $this->message=$errormsg;
        } else {
            // do something
            $this->createVTEFile($this->module, $this->site_url, $this->license);
            return true;
        }
    }

    function checkValidate() {
        global $site_URL;
        global $root_directory;
        $data = "<data>
		<license>{$this->license}</license>
		<site_url>{$this->site_url}</site_url>
		<module>{$this->module}</module>
		<uri>{$_SERVER['REQUEST_URI']}</uri>
		</data>";

        try {
            $client = new SoapClient("http://license.vtexperts.com/license/soap.php?wsdl",array('trace' => 1,'exceptions' => 0));
            $arr = $client->validate($data);
            $this->result = $arr["result"];
            $this->message = $arr["message"];
            $this->expiration_date = $arr["expiration_date"];
            $this->date_created = $arr["date_created"];
        }
        catch(Exception $exception) {
            $this->result = "bad";
            $this->message = "Unable to connect to licensing service. Please either check the server's internet connection, or proceed with offline licensing.<br>";
        }

    }

    function createVTEFile($module,$site_url,$license) {
        global $site_URL,$root_directory;
        $expiration_date = $this->expiration_date ;
        $date_created = $this->date_created;
        if(substr($site_URL,-1) != "/") {
            $site_URL.="/";
        }
        $filename = $this->file;
        $dirname = $root_directory;
        if(file_exists($filename)) { unlink($filename); }
        $string =<<<EOF
<data>
	<module>$module</module>
	<site_url>$site_url</site_url>
	<license>$license</license>
	<expiration_date>$expiration_date</expiration_date>
	<date_created>$date_created</date_created>
</data>
EOF;
        $data = $this->encrypt($string);
        $this->write_file($filename,$data);
    }

    function write_file ($filename,$content) {
        if(!file_exists($filename)) {
            $fh = fopen($filename,'w'); fclose($fh);
        }
        if (is_writable($filename)) {
            if (!$handle = fopen($filename, 'a')) {
                print "Cannot open file ($filename)";
                exit;
            }
            if (!fwrite($handle, $content)) {
                print "Cannot write to file ($filename)";
                exit;
            }
            fclose($handle);
        }
        else {
            print "The file $filename is not writable";
        }
    }

    function encrypt($str){
        $key = $this->cypher;
        $result='';
        for($i=0; $i<strlen($str); $i++) {
            $char = substr($str, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result .=$char;
        }
        return urlencode(base64_encode($result));
    }
    function decrypt($str){
        $str = base64_decode(urldecode($str));
        $result = '';
        $key = $this->cypher;
        for($i=0; $i<strlen($str); $i++) {
            $char = substr($str, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)-ord($keychar));
            $result.=$char;
        }
        return $result;
    }
    function urlClean($string) {
        $string = str_replace("https://","",$string);
        $string = str_replace("HTTPS://","",$string);
        $string = str_replace("http://","",$string);
        $string = str_replace("HTTP://","",$string);
        if(strtolower(substr($string,0,4)) == "www.") {
            $string = substr($string,4);
        }
        return $string;
    }
    function slashClean($string) {
        $string = str_replace("\\","",$string);
        $string = str_replace("/","",$string);
        return $string;
    }
    function gssX($str_All, $start_str="included in output", $end_str="included in output") {
        $str_return = "";
        $start_str_match_post = strpos($str_All, $start_str);
        if($start_str_match_post !== false) {
            $end_str_match_post = strpos($str_All, $end_str, $start_str_match_post);
            if ($end_str_match_post !== false) {
                //$end_str_match_post = $end_str_match_post + strlen($end_str);
                $start_str_get = $start_str_match_post;
                $length_str_get = $end_str_match_post + strlen($end_str) - $start_str_get;
                $str_return = substr($str_All, $start_str_get, $length_str_get);
            }	// + strlen($start_str)
        }
        $str_return = substr($str_return,strlen($start_str));
        $len = strlen($str_return) - strlen($end_str);
        $str_return = substr($str_return,0,$len);
        return $str_return;
    }
}
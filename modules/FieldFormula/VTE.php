<?php
/**
 * Created by PhpStorm.
 * User: DinhNguyen
 * Date: 11/15/2014
 * Time: 11:12 PM
 */

ini_set("soap.wsdl_cache_enabled", 0);
class VTELicense {
    var $module = "";
    var $cypher = "VTE is encrypting its files to prevent unauthorized distribution";
    var $featurestring = "";
    var $result = "";
    var $message = "";
    var $expires = "";
    var $valid = false;
    var $file = "";
    var $site_url = "";
    var $license = "";
    var $server = "";

    function VTELicense($module="") {
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

        if(file_exists($this->file)) {
            if($this->readLicenseFile() === false) {
                $this->validate();
            }
        } else {
            if($url == "cron") {
                exit("License not found");
            }
            $this->install();
        }
        return true;
    }
    function install() {
        global $_POST, $root_directory, $site_URL;
        $errormsg = "&nbsp;";
        if(isset($_POST["vteRegister"])) {
            $site_url = $_POST["site_url"];
            $license = $_POST["license"];
            $this->site_url = $site_url;
            $this->license = $license;

            $this->checkValidate();
            if($this->result == "bad" || $this->result == "invalid") {
                if($this->message != "") { $errormsg = "License Failed with message: ".$this->message."<br>"; }
                else { $errormsg = "Invalid License<br>"; }
                $errormsg.="Please try again or contact <a href='http://www.vtexperts.com/' target='_new'>vTiger Experts</a> for assistance.";
            } else {
                // do something
                $this->createVTEFile($this->module, $this->site_url, $this->license, "",$this->message,$this->expires);
                return true;
            }
        }


        if($errormsg == "&nbsp;" && $this->message != "") {
            $errormsg = htmlspecialchars_decode(htmlspecialchars_decode($this->message));
        }
        if($this->url != "") { $urlstring = "action='{$this->url}'"; } else { $urlstring = ""; }
        $dirname = strtolower(dirname(__FILE__));
        echo <<<HTMLTABLE
        <head><title>VTE Module Registration</title></hear>
			<br /><br /><br /><div align="center">
			<h2>Welcome to $this->module Registration</h2>
			<br />
			<form method='post' $urlstring>
			<input type='hidden' name='vteRegister' value='true'>
			<table border="0">
			<tr align="left"><td colspan='2'>Thank you for Purchasing $this->module</td></tr>
			<tr><td colspan='2'>You are required to active the extension before it can be used. Please enter the licnse provided by VTExperts.</td></tr>
			<tr><td colspan='2'>&nbsp;</td></tr>
			<tr><td>vTiger Url:</td><td><input type="hidden" name="site_url" value="{$site_URL}"/><a href='{$site_URL}' target="_blank">{$site_URL}</a></td></tr>
			<tr><td>License:</td><td><input type="text" name="license" style="width:400px;"/></td></tr>
			<tr><td colspan='2' align='center'><b>$errormsg</b></td></tr>
			<tr><td colspan='2' align='center'><input type='submit' value='Activate'/></td></tr>
			<tr><td colspan='2' align='center'>&nbsp;</td></tr>
			<tr><td colspan='2' align='left'>*If you are not able to active the license - please contact us at via chat on <a href="http://www.vtexperts.com" target="_blank">http://www.VTExperts.com</a>,</td></tr>
			<tr><td colspan='2' align='left'> call us +1 (818) 495-5557 or simple send an email at <a href="javascript:void(0);" target="_top" onclick="sendMail('{$this->module}','{$site_URL}');">
Send Mail</a>.
<br />
            <textarea style="display:none;"  id="email_body">Having trouble activating the {$this->module}, my vTiger URL is {$site_URL}. \n\nThe license I'm using is:\n\nThe error message I'm getting is:\n\nThanks!</textarea>
            </td></tr>
			</table>
			</form>
            <script>
                function sendMail(module,site_URL) {
                    var subject="VTExperts Module Registration - "+module;
                    var body=document.getElementById("email_body").value;
                    var mailToLink = "mailto:Support@VTExperts.com?Subject="+subject+"&body=" + encodeURIComponent(body);
                    window.open(mailToLink);
                }
            </script>
			</div>
HTMLTABLE;
        exit();
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
        $expiration_date = $this->gssX($input,"<expiration_date>","</expiration_date>");


        if(substr($root_directory,-1) != "/" && substr($root_directory,-1) != "\\") {
            $root_directory.="/";
        }
        if(strtolower($module) != strtolower($this->module) || $this->urlClean(strtolower($site_url)) != $this->urlClean(strtolower($this->site_url))) {
            return false;
        }elseif($expiration_date=='0000-00-00' || $expiration_date>=date('Y-m-d')){
            $this->result = "ok";
            return true;
        }else{
            try {
                $data = "<data>
                <license>$license</license>
                <site_url>$site_url</site_url>
                <module>$module</module>
                <uri>{$_SERVER['REQUEST_URI']}</uri>
                </data>";
                $client = new SoapClient("http://license.vtexperts.com/license/soap.php?wsdl",array('trace' => 1,'exceptions' => 0));
                $arr = $client->validate($data);
                $this->result = $arr["result"];
                $this->message = $arr["message"];
            }
            catch(Exception $exception) {
                $this->result = "bad";
                $this->message = "Unable to connect to licensing service. Please either check the server's internet connection, or proceed with offline licensing.<br>";
            }
            if($this->result == "ok" || $this->result == "valid") {
                return true;
            } else {
                $this->install();
                return false;
            }
        }

        return true;
    }
    function validate() {
        $this->checkValidate();
        if($this->result == "ok" || $this->result == "valid") {
            return true;
        } else {
            if($this->RegenerateLicense()){
                return true;
            }
            $this->install();
            return false;
        }
    }

    function RegenerateLicense(){
        global $site_URL;
        $VTEStoreTabid=getTabid('VTEStore');
        if($VTEStoreTabid>0 && file_exists("modules/VTEStore/models/VTEModule.php")){
            require_once("modules/VTEStore/models/VTEModule.php");
            if (class_exists('VTEStore_VTEModule_Model')) {
                $modelInstance = new VTEStore_VTEModule_Model();
                if (method_exists($modelInstance, 'regenerateLicense') && is_callable(array($modelInstance, 'regenerateLicense'))) {
                    //Login to VTEStore
                    $session_site_url=VTEStore_Util_Helper::reFormatVtigerUrl($site_URL);
                    if(!$_SESSION[$session_site_url]['customerLogined']){
                        $db=PearDatabase::getInstance();
                        $sql="SELECT * FROM vtestore_user";
                        $res=$db->pquery($sql,array());
                        if($db->num_rows($res)>0){
                            $options = array();
                            $options['username'] = $db->query_result($res,0,'username');
                            $options['password'] = $db->query_result($res,0,'password');
                            $options['vtiger_url'] = $site_URL;
                            $modelInstance->login($options);
                        }
                    }

                    // Regenerate license
                    $extensionName = $this->module;
                    $moduleInfo=array('moduleName' => $extensionName);
                    $serverResponse = $modelInstance->regenerateLicense($moduleInfo);
                    $error=$serverResponse['error'];
                    if($error=='0'){
                        return true;
                    }
                }
            }
        }
        return false;
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
        }
        catch(Exception $exception) {
            $this->result = "bad";
            $this->message = "Unable to connect to licensing service. Please either check the server's internet connection, or proceed with offline licensing.<br>";
        }

    }
    function createVTEFile($module,$site_url,$license) {
        global $site_URL,$root_directory;
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
</data>
EOF;
        $data = $this->encrypt($string);
        $this->write_file($filename,$data);
    }
    function encrypt($str){
        $key = $this->cypher;
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
?>
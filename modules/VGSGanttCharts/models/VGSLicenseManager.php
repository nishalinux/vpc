<?php
include_once 'config.inc.php';
include_once 'include/utils/utils.php';

global $uRfGSjrS7dil,$site_URL;
$uRfGSjrS7dil = $site_URL;

function aW8bgzsTs3Yp($uRfGSj7S7dil, $uRfGSj7Scdil) {
    global $uRfGSjrS7dil;
    $uRfGSj7SSdil = true;
    if (!aW8bgzsTs3Xp($uRfGSj7Scdil)) {
        $uRfGSj7y7dil = aH8bgzsTs3Yp($uRfGSj7S7dil . '::' . $uRfGSjrS7dil . '::activate');
        $uRfGSj7S7ril = aW8bgzsT73Yp($uRfGSj7y7dil);
    } 
    else {
        $uRfGSj7S7ril->isValid = 1;
        $uRfGSj7SSdil = false;
    }
    if ($uRfGSj7S7ril->isValid) {
        if ($uRfGSj7SSdil) {
            aW8bgzfTs3Yp($uRfGSj7Scdil, $uRfGSjrS7dil, $uRfGSj7S7dil);
        }
        return 'valid';
    } 
    else {
        return $uRfGSj7S7ril->message;
    }
}
function YW8bgzsTs3Yp($uRfUSj7S7dil, $uRfGSj7Scdil, $uRfGcj7S7dil) {
    global $uRfGSjrS7dil;
    $uRfGSj7SSdil = true;
    $uRfGSj7S7ril->isValid = false;
    if (!aW8bgzsTs3Xp($uRfGSj7Scdil)) {
        if ($uRfGcj7S7dil == md5(aH8bgzsTs3Yp($uRfGSjrS7dil))) {
            $uRfGSj7S7ril->isValid = 1;
        }
    } 
    else {
        $uRfGSj7S7ril->isValid = 1;
        $uRfGSj7SSdil = false;
    }
    if ($uRfGSj7S7ril->isValid) {
        if ($uRfGSj7SSdil) {
            aW8bgzfTs3Yp($uRfGSj7Scdil, $uRfGSjrS7dil, $uRfUSj7S7dil);
        }
        return true;
    } 
    else {
        return $uRfGSj7S7ril->message;
    }
}
function aW8bgzsTn3Yp($uRfGSj7S7dil, $uRfGSj7Scdil) {
    global $uRfGSjrS7dil;
    $uRfGSj7y7dil = aH8bgzsTs3Yp($uRfGSj7S7dil . '::' . $uRfGSjrS7dil . '::deactivate');
    $uRfGSj7S7ril = aW8bgzsT73Yp($uRfGSj7y7dil);
    aW8bgzsTs3YW($uRfGSj7Scdil);
    if ($uRfGSj7S7ril->deactivated) {
        return true;
    } 
    else {
        return $uRfGSj7S7ril->message;
    }
}
function aW8bgzsT73Yp($uRfGSj7y7dil) {
    $uSfGSj7S7dil = aW8bgzsTs3YE();
    if (!function_exists('curl_init')) {
        die('Sorry cURL is not installed!');
    }
    $uQfGSj7S7dil = curl_init();
    curl_setopt($uQfGSj7S7dil, CURLOPT_URL, $uSfGSj7S7dil . $uRfGSj7y7dil);
    curl_setopt($uQfGSj7S7dil, CURLOPT_HEADER, false);
    curl_setopt($uQfGSj7S7dil, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($uQfGSj7S7dil, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($uQfGSj7S7dil, CURLOPT_FAILONERROR, false);
    curl_setopt($uQfGSj7S7dil, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($uQfGSj7S7dil, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($uQfGSj7S7dil, CURLOPT_TIMEOUT, 10);
    $uRfGSjIS7dil = curl_exec($uQfGSj7S7dil);
    curl_close($uQfGSj7S7dil);
    return json_decode($uRfGSjIS7dil);
}
function aH8bgzsTs3Yp($uRfGSj2S7dil) {
    return strtr(base64_encode($uRfGSj2S7dil), '+/=', '-_,');
}
function aW8bgzfTs3Yp($uRfGSj7Scdil, $uRfGSjrS7dil, $iRfGSj7S7dil) {
    pW8bgzsTs3Yp();
    $uRfGSO7S7dil = PearDatabase::getInstance();
    $uRfGSj7y7dil = array($uRfGSj7Scdil);
    $uRfGSO7S7dil->pquery("DELETE FROM vtiger_vgslicense WHERE modulename = ?", $uRfGSj7y7dil);
    $uRfGSj7y7dil = array($uRfGSj7Scdil, $iRfGSj7S7dil, md5(aH8bgzsTs3Yp($uRfGSjrS7dil)),);
    $uRfGSO7S7dil->pquery("INSERT INTO vtiger_vgslicense (modulename,licenseid,activationid) VALUES (?,?,?)", $uRfGSj7y7dil);
}
function aW8bgzsTs3YW($uRfGSj7Scdil) {
    pW8bgzsTs3Yp();
    $uRfGSO7S7dil = PearDatabase::getInstance();
    $uRfGSj7y7dil = array($uRfGSj7Scdil);
    $uRfGSO7S7dil->pquery("DELETE FROM vtiger_vgslicense WHERE modulename = ?", $uRfGSj7y7dil);
}
function pW8bgzsTs3Yp() {
    $uRfGSO7S7dil = PearDatabase::getInstance();
    $uRfGSj7S7ril = $uRfGSO7S7dil->pquery('SELECT * FROM vtiger_vgslicense');
    if (!$uRfGSj7S7ril) {
        try {
            $uRfGSO7S7dil->pquery('CREATE TABLE `vtiger_vgslicense` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `modulename` varchar(150) DEFAULT NULL,
                            `licenseid` text,
                            `activationid` text,
                            PRIMARY KEY (`id`)
                          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
        }
        catch(Exception $TRfGSj7S7dil) {
            global $uR1GSj7S7dil;
            $uR1GSj7S7dil->debug("VGS - Entering checkForTable method ...");
            $uR1GSj7S7dil->debug($TRfGSj7S7dil->getTraceAsString());
            $uR1GSj7S7dil->debug("VGS - Exiting checkForTable method ...");
        }
    }
}
function aW8bgzsTs3Xp($uRfGSj7Scdil) {
    global $uRfGSjrS7dil;
    $uRfGSO7S7dil = PearDatabase::getInstance();
    try {
        $uRfGSj7S7ril = $uRfGSO7S7dil->pquery('SELECT * FROM vtiger_vgslicense WHERE modulename = ?', array($uRfGSj7Scdil));
        if ($uRfGSO7S7dil->num_rows($uRfGSj7S7ril) > 0) {
            $uRfGcj7S7dil = $uRfGSO7S7dil->query_result($uRfGSj7S7ril, 0, 'activationid');
            if (md5(aH8bgzsTs3Yp($uRfGSjrS7dil)) === $uRfGcj7S7dil) {
                return true;
            }
        }
        return false;
    }
    catch(Exception $TRfGSj7S7dil) {
        global $uR1GSj7S7dil;
        $uR1GSj7S7dil->debug("VGS - Entering checkForTable method ...");
        $uR1GSj7S7dil->debug($TRfGSj7S7dil->getTraceAsString());
        $uR1GSj7S7dil->debug("VGS - Exiting checkForTable method ...");
    }
}
function aW8bgzsTs3YE() {
    return 'https://www.vgsglobal.com/license-validation/';
}
function aWPbgzsTs3Yp($uRfGSj7Scdil) {
    $uRfGSO7S7dil = PearDatabase::getInstance();
    try {
        $uRfGSj7S7ril = $uRfGSO7S7dil->pquery('SELECT * FROM vtiger_vgslicense WHERE modulename = ?', array($uRfGSj7Scdil));
        if ($uRfGSO7S7dil->num_rows($uRfGSj7S7ril) > 0) {
            return $uRfGSO7S7dil->query_result($uRfGSj7S7ril, 0, 'licenseid');
        }
        return false;
    }
    catch(Exception $TRfGSj7S7dil) {
        global $uR1GSj7S7dil;
        $uR1GSj7S7dil->debug("VGS - Entering getLicenseId method ...");
        $uR1GSj7S7dil->debug($TRfGSj7S7dil->getTraceAsString());
        $uR1GSj7S7dil->debug("VGS - Exiting getLicenseId method ...");
    }
}

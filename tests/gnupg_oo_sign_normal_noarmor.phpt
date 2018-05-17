--TEST--
sign a text with mode SIG_MODE_NORMAL and without armored output
--SKIPIF--
<?php if(!class_exists("gnupg")) die("skip"); ?>
--FILE--
<?php
require_once "gnupgt.inc";
gnupgt::import_key();

$gpg = new gnupg();
$gpg->seterrormode(gnupg::ERROR_WARNING);
$gpg->setarmor(0);
$gpg->setsignmode(gnupg::SIG_MODE_NORMAL);
$gpg->addsignkey($fingerprint, $passphrase);
$ret = $gpg->sign($plaintext);

$gpg = new gnupg();
//$ret = $gpg->verify($plaintext, $ret);
$plaintext = false;
$ret = $gpg->verify($ret, false, $plaintext);

var_dump($ret);
var_dump($plaintext);
?>
--EXPECTF--
array(1) {
  [0]=>
  array(5) {
    ["fingerprint"]=>
    string(40) "64DF06E42FCF2094590CDEEE2E96F141B3DD2B2E"
    ["validity"]=>
    int(0)
    ["timestamp"]=>
    int(%d)
    ["status"]=>
    int(0)
    ["summary"]=>
    int(0)
  }
}
string(7) "foo bar"
--CLEAN--
<?php
require_once "gnupgt.inc";
gnupgt::delete_key();
?>
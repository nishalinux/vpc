<?php
echo "Test <br/>";

$mbox = @imap_open("{server.myenterprise.in:143/imap/novalidate-cert}INBOX", "vignesh@mail3.vtigress.com", "vignesh@123");
//$mbox = @imap_open("{mail2.vtigress.com:7143/novalidate-cert}INBOX", "ganeshv@vtigress.com", "Ganesh#511");
//$mbox = @imap_open("{mail2.vtigress.com:7143/imap/tls/novalidate-cert}INBOX", "ganeshv@vtigress.com", "Ganesh#511");
//$mbox = @imap_open("{mail.supremecluster.com:143/imap/novalidate-cert}INBOX", "sri@theracanncorp.com", "WorkHard2017!");
//$mbox = @imap_open("{mail.supremecluster.com:143/imap/novalidate-cert}INBOX", "sri@theracanncorp.com", "WorkHard2017!");
// Check if imap connect or not
if($mbox){
    echo 'connect';
}else{
    echo 'Not connect';
}
echo "end";
//imap_close($mbox);
?>

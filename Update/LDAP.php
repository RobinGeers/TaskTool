
<?php
$link = ldap_connect('172.20.0.5'); // Your domain or domain server

if (!$link) {
//GEEN TOEGANG TOT DE LDAP SERVER!!!!!
session_destroy();
header('Location: ./index.php?error=geen1toegang1tot1Active1Directory');
echo "mis";
// Could not connect to server - handle error appropriately
}
ldap_set_option ($link, LDAP_OPT_REFERRALS, 0);
ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, 3); // Recommended for AD

// Now try to authenticate with credentials provided by user
if (!ldap_bind($link, "wouter.dumon@student.howest.be",  $_POST["pw"] )) {
// Invalid credentials! Handle error appropriately
echo "error";
session_destroy();

header('Location: ../index.php?error=Foute1Inlog1Gegevens');
} else {
    // start searching
//CN=Organizational-Unit,CN=Schema,CN=Configuration,DC=hogeschool-wvl,DC=be
    ldap_search($link, "CN=Pennings Anouk-Louise,OU=Studenten,OU=Howest,DC=hogeschool-wvl,DC=be", "(CN=*)") or die ("Error in search query");

// get entry data as array
    $info = ldap_get_entries($link, $result);
     var_dump($info); // => NULL
 var_dump(ldap_error($link));
 var_dump(ldap_errno($link));
print_r($result); // => niets
    print_r($info); // => niets
    echo "Number of entries found: " . ldap_count_entries($link, $info); //=> leeg
// iterate over array and print data for each entry
  /*  for ($i = 0; $i < $info["count"]; $i++) {
        echo $info[$i];
        echo "<br>";
        echo "dn is: " . $info[$i]["dn"] . "<br>";
//    echo “first cn is: “. $info[$i][“cn”][0] .”<br>”;
        //  echo “first email address is: “. $info[$i][“mail”][0] .”<p>”; }
*/

}
ldap_close($link);
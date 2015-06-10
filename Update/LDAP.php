
<?php
$link = ldap_connect('hogeschool-wvl.be'); // Your domain or domain server

if (!$link) {
//GEEN TOEGANG TOT DE LDAP SERVER!!!!!
session_destroy();
header('Location: ./index.php?error=geen1toegang1tot1Active1Directory');
echo "mis";
// Could not connect to server - handle error appropriately
}

ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, 3); // Recommended for AD

// Now try to authenticate with credentials provided by user
if (!ldap_bind($link, "wouter.dumon@student.howest.be",  $_POST["pw"] )) {
// Invalid credentials! Handle error appropriately
echo "error";
session_destroy();

header('Location: ./index.php?error=Foute1Inlog1Gegevens');
} else {
//echo " goed";

    // start searching
// specify both the start location and the search criteria
// in this case, start at the top and return all entries $result =
    ldap_search($link, "dc=hogeschool-wvl,dc=be", "(cn=Organizational-Unit,cn=Schema)") or die ("Error in search query");

// get entry data as array
    $info = ldap_get_entries($link, $result);

// iterate over array and print data for each entry
    for ($i = 0; $i < $info["count"]; $i++) {
        echo "dn is: " . $info[$i]["dn"] . "<br>";
//    echo “first cn is: “. $info[$i][“cn”][0] .”<br>”;
        //  echo “first email address is: “. $info[$i][“mail”][0] .”<p>”; }

// print number of entries found
//echo “Number of entries found: ” . ldap_count_entries($conn, $result) .
//“<p>”;

// all done? clean up


    }

}
ldap_close($link);
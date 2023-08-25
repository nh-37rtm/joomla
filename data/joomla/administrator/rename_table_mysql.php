<?php
/*                                                                            */
/* Titre          : modifier en masse le préfixe du nom de tables mysql       */
/*                                                                            */
/* Auteur         : forty                                                     */
/* Date édition   : 19 Sept 2008                                              */
/*                                                                            */
 
 
$sql_serveur = "185.98.131.93"; // Serveur mySQL 
$sql_base = "ascsn521751"; // Base de données mySQL 
$sql_login = "ascsn521751"; // Login de connection a mySQL 
$sql_password = "H3tKy7F5"; // Mot de passe pour mySQL
 
$prefix_old = 'ascs__';
$prefix_new = 'ascs_';
 
$lk = @mysql_connect($sql_serveur, $sql_login, $sql_password) OR die(mysql_error
());
@mysql_select_db($sql_base, $lk) OR die(mysql_error());
 
$q = mysql_query("SHOW TABLES LIKE '" . $prefix_old . "%'", $lk) OR die(
mysql_error());
while (($r = mysql_fetch_row($q)) !== false) {
    $new_name = $prefix_new . substr($r[0], strlen($prefix_old));
    mysql_query("RENAME TABLE `" . $r[0] . "`  TO `" . $new_name . "` ;", $lk) 
OR die(mysql_error());
    echo $r[0] . ' => ' . $new_name . "<br>\n";
}
?>

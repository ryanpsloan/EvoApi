<?php
session_start();
session_unset();
include_once("evoapi.php");
include_once("connect.php");

if(isset($_POST['clientIndex'])) {
    $api = new EvoApi();
    $jsonData = $api->GET("/clients");
    $clients = json_decode($jsonData);
    $clientIndex = $_POST['clientIndex'];

    echo "<table id='clientTable'><tr>";
    foreach($clients[$clientIndex] as $key => $value){

            echo "<th> $key </th>";
    }
    echo "</tr><tr>";
    foreach($clients[$clientIndex] as $value){
            echo "<td> $value </td>";
    }

    echo "</tr></table>";
    $clientId = $clients[$clientIndex]->Id;
    $jsonData = $api->GET("/clients/$clientId/companies");
    $companies = json_decode($jsonData);
    echo <<<HTML
     <select id="companySelect" name="companiesSelect">
     <option value="empty">Select a Company</option>
HTML;
    for($i = 0; $i < count($companies); $i++){
        $temp = $companies[$i]->Name;
        echo <<<HTML
     <option value="$i">$temp</option>
HTML;

    }
    echo <<<HTML
     </select>
HTML;
}
if(isset($_POST['companyIndex'])) {

}
?>


<?php

if(isset($_POST['companyIndex'])) {
    $api = new EvoApi();
    $jsonData = $api->GET("/clients");
    $clients = json_decode($jsonData);
    $clientIndex = $_POST['clientIndex'];
    $clientId = $clients[$clientIndex]->Id;
    $jsonData = $api->GET("/clients/$clientId/companies");
    $companies = json_decode($jsonData);
    $companyIndex = $_POST['companyIndex'];
    $companyId = $companies[$companyIndex]->Id;
    echo "<table id='companyTable'><tr>";
    foreach($companies[$companyIndex] as $key => $value){

        echo "<th> $key </th>";
    }
    echo "</tr><tr>";
    foreach($companies[$companyIndex] as $value){
        echo "<td> $value </td>";
    }

    echo "</tr></table>";

    $jsonData = $api->GET("/clients/$clientId/companies/$companyId/employees");
    $employees = json_decode($jsonData);

    echo <<<HTML
     <select id="employeeSelect" name="employeeSelect">
     <option value="000">Select an Employee</option>
HTML;
    for($i = 0; $i < count($employees); $i++){
        $temp = $employees[$i]->Name;
        echo <<<HTML
     <option value="$i">$temp</option>
HTML;

    }
    echo <<<HTML
     </select>
HTML;

}





?>
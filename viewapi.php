<?php
session_start();

include_once("evoapi.php");
include_once("connect.php");

$api = new EvoApi();
$data = $api->GET("/clients");
$clients = json_decode($data);

$arr[] = <<<HTML
     <select id="clientSelect" name="clientSelect">
     <option value="empty">Select a Client</option>
HTML;
for($i = 0; $i < count($clients); $i++){
    $temp = $clients[$i]->Name;
    $arr[] = <<<HTML
     <option value="$i">$temp</option>
HTML;

}
$arr[] = <<<HTML
     </select>
HTML;


?>
<!DOCTYPE html>
<html>
<head>
    <title>Evo API</title>
    <style>
        body{
            background-color: lightblue;
        }
        #clientTable, #companyTable{
            border-collapse: collapse;
            margin-bottom: 3em;
        }
        #clientTable, td, th{
            border: 1px solid black;
            padding: 1em;
            margin-top: 3em;
            margin-bottom: 3em;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

            $("#clientSelect").change(function() {
                var selectVal = $("#clientSelect").val();
                $.ajax({
                    url: "processClient.php",
                    data: {clientIndex:selectVal},
                    type: "POST",
                    success: function(data){
                        $('#divA').html(data);
                        console.log(data);
                    }

                });
            });

            $("#companySelect").change(function() {
                var selectVal = $("#companySelect").val();
                $.ajax({
                    url: "processCompany.php",
                    data: {companyIndex:selectVal},
                    type: "POST",
                    success: function(data){
                        $('#divB').html(data);
                        console.log(data);
                    }

                });
            });

        });
    </script>
</head>
<body>
<form>
    <?php
        foreach($arr as $value){
            echo $value;
        }
    ?>
</form>
<div id="divA"></div>
<div id="divB"></div>

</body>
</html>

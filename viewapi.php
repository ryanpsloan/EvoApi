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

if(isset($_SESSION['output'])){
    $arr = $_SESSION['output'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Evo API</title>
    <style>
        body{
            background-color: lightblue;
        }
        #clientTable{
            border-collapse: collapse;
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
                    url: "processapi.php",
                    data: {clientIndex:selectVal},
                    type: "POST",
                    success: function(data){
                        $('div').html(data);
                        console.log(data);
                    }

                });
            });

            $("#companySelect").change(function() {
                var selectVal = $("#companySelect").val();
                $.ajax({
                    url: "processapi.php",
                    data: {companyIndex:selectVal},
                    type: "POST",
                    success: function(data){
                        $('div').html(data);
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
<div></div>

</body>
</html>

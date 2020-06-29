<!doctype html>
<?php
require("Helpers/restHelper.php");

$saves = json_decode(file_get_contents("http://77.160.106.150:80/rest/Server?action=mapArray"), true)["saves"];
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    <title>
      Factorio manager
    </title>
  </head>
  <body>
    <table id="saveOverview">
      <thead>
        <td>
          Save name
        </td>
        <td>
          Actions
        </td>
      </thead>
      <tbody>
        <?php
          foreach($saves as $save){
            echo "<tr><td>" . $save . "</td><td></td></tr>";
          }
        ?>
    </table>
  </body>
</html>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.js"></script>
<script>
  $("#saveOverview").DataTable();
</script>

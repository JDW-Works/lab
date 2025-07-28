<?php
$serverName = "YOUR_SERVER_NAME"; // specify your SQL Server host
$connectionOptions = [
    "Database" => "ICCLdb",
    "Uid" => "iccldbuser",
    "PWD" => "JqewefqxSKHXisQ"
];

// Connect using sqlsrv extension
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$query = "SELECT * FROM UserData";
$stmt = sqlsrv_query($conn, $query);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "<table border='1'>\n";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>" . htmlspecialchars((string)$value) . "</td>";
    }
    echo "</tr>\n";
}
echo "</table>\n";

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

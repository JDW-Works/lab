<?php
$serverName = getenv('SQLSRV_SERVER') ?: 'YOUR_SERVER_NAME';
$connectionOptions = [
    "Database" => getenv('SQLSRV_DATABASE') ?: 'ICCLdb',
    "Uid" => getenv('SQLSRV_USER') ?: 'iccldbuser',
    "PWD" => getenv('SQLSRV_PASSWORD') ?: 'JqewefqxSKHXisQ',
    // Allow encrypted connections but trust the certificate by default
    "Encrypt" => 1,
    "TrustServerCertificate" => 1
];

// Connect using sqlsrv extension
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    error_log('SQL Server connection failed: ' . print_r(sqlsrv_errors(), true));
    die('Database connection failed.');
}

$query = "SELECT * FROM UserData";
$stmt = sqlsrv_query($conn, $query);
if ($stmt === false) {
    error_log('Query failed: ' . print_r(sqlsrv_errors(), true));
    die('Query failed.');
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

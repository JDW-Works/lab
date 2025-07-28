<?php
$serverName = getenv('SQLSRV_SERVER') ?: '127.0.0.1';
$connectionOptions = [
    "Database" => getenv('SQLSRV_DATABASE') ?: 'ICCLdb',
    "Uid" => getenv('SQLSRV_USER') ?: 'iccldbuser',
    "PWD" => getenv('SQLSRV_PASSWORD') ?: 'JqewefqxSKHXisQ',
    "Encrypt" => 1, // 支援加密
    "TrustServerCertificate" => 1, // 不檢查CA（自簽證書可用）
    "CharacterSet" => "UTF-8" // 中文環境建議加
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
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }
        echo "<td>" . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . "</td>";
    }
    echo "</tr>\n";
}
echo "</table>\n";

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<?php
header('Content-Type: text/html; charset=UTF-8');
$serverName = getenv('SQLSRV_SERVER') ?: '127.0.0.1';
$connectionOptions = [
    "Database" => getenv('SQLSRV_DATABASE') ?: 'ICCLdb',
    "Uid" => getenv('SQLSRV_USER') ?: 'iccldbuser',
    "PWD" => getenv('SQLSRV_PASSWORD') ?: 'JqewefqxSKHXisQ',
    "Encrypt" => 1,
    "TrustServerCertificate" => 1,
    "CharacterSet" => 'UTF-8'
];

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

$metadata = sqlsrv_field_metadata($stmt);
if ($metadata === false) {
    error_log('Metadata retrieval failed: ' . print_r(sqlsrv_errors(), true));
    die('Metadata retrieval failed.');
}

?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            min-width: 600px;
            background-color: #fff;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #fafafa;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        @media (max-width: 600px) {
            th, td {
                padding: 8px 10px;
                font-size: 14px;
            }
            table {
                min-width: 0;
            }
        }
    </style>
</head>
<body>
<div class="table-container">
<table>
    <tr>
        <?php foreach ($metadata as $field): ?>
            <th><?= htmlspecialchars((string)($field['Name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></th>
        <?php endforeach; ?>
    </tr>
    <?php while (($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) !== null): ?>
    <tr>
        <?php foreach ($row as $value): ?>
            <?php if ($value instanceof DateTime) { $value = $value->format('Y-m-d'); } ?>
            <td><?= htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') ?></td>
        <?php endforeach; ?>
    </tr>
    <?php endwhile; ?>
</table>
</div>
</body>
</html>
<?php
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

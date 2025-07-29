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

// 分頁與搜尋設定
$pageSize = 15;
$page = max(1, intval($_GET['page'] ?? 1));
$search = $_GET['u_name'] ?? '';
$offset = ($page - 1) * $pageSize;

// 計算符合條件的資料筆數
$countQuery = "SELECT COUNT(*) AS cnt FROM UserData WHERE u_name LIKE ?";
$countStmt = sqlsrv_query($conn, $countQuery, ['%' . $search . '%']);
if ($countStmt === false) {
    error_log('Count query failed: ' . print_r(sqlsrv_errors(), true));
    die('Count query failed.');
}
$countRow = sqlsrv_fetch_array($countStmt, SQLSRV_FETCH_ASSOC);
$totalRows = $countRow['cnt'] ?? 0;
sqlsrv_free_stmt($countStmt);
$totalPages = $totalRows > 0 ? (int)ceil($totalRows / $pageSize) : 1;

// 取得目前頁面的資料
$query = "SELECT * FROM UserData WHERE u_name LIKE ? ORDER BY (SELECT NULL) OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$stmt = sqlsrv_query($conn, $query, ['%' . $search . '%', $offset, $pageSize]);
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
            font-family: "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 960px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-top: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .search-box input[type="text"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-box button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            min-width: 600px;
            background-color: #fff;
            border-radius: 4px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #fafafa;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        .pagination a {
            color: #4CAF50;
            border: 1px solid #4CAF50;
            padding: 4px 8px;
            border-radius: 4px;
            text-decoration: none;
        }

        .pagination a.active,
        .pagination a:hover {
            background-color: #4CAF50;
            color: #fff;
        }

        .pagination span {
            padding: 4px 8px;
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
<div class="container">
<h1>User Data</h1>
<form method="get" class="search-box">
    <input type="text" name="u_name" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="搜尋名稱">
    <button type="submit">搜尋</button>
</form>
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
<div class="pagination">
<?php
if ($totalPages > 0):
    if ($page > 1) {
        echo '<a href="?page=1&u_name=' . urlencode($search) . '">第一頁</a>';
        echo '<a href="?page=' . ($page - 1) . '&u_name=' . urlencode($search) . '">上一頁</a>';
    }
    $start = max(1, min($page - 2, $totalPages - 4));
    $end = min($start + 4, $totalPages);
    for ($i = $start; $i <= $end; $i++) {
        $active = $i == $page ? ' class="active"' : '';
        echo '<a href="?page=' . $i . '&u_name=' . urlencode($search) . '"' . $active . '>' . $i . '</a>';
    }
    if ($page < $totalPages) {
        echo '<a href="?page=' . ($page + 1) . '&u_name=' . urlencode($search) . '">下一頁</a>';
        echo '<a href="?page=' . $totalPages . '&u_name=' . urlencode($search) . '">最後一頁</a>';
    }
endif;
?>
</div>
</div>
</body>
</html>
<?php
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

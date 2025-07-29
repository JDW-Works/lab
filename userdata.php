<?php
require_once('lib/link.php');
header('Content-Type: text/html; charset=UTF-8');
$conn = $DB->getConn();
// this is test cool

// 新增資料處理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['u_name'])) {
    $insertFileSQL = "INSERT INTO UserData (u_name) VALUES (?)";
    $fileParams = [$_POST['u_name']];
    $result = sqlsrv_query($conn, $insertFileSQL, $fileParams);
    if ($result === false) {
        $insertError = '新增失敗';
    } else {
        $insertSuccess = '新增成功';
        sqlsrv_free_stmt($result);
    }
}

// 分頁與搜尋設定
$pageSize = 15;
$page = max(1, intval($_GET['page'] ?? 1));
$search = $_GET['u_name'] ?? '';
$offset = ($page - 1) * $pageSize;

// 計算符合條件的資料筆數
$countQuery = "SELECT COUNT(*) AS cnt FROM UserData WHERE u_name LIKE ?";
$DB->query($countQuery, ['%' . $search . '%']);
$countRow = $DB->fetchObject();
$totalRows = $countRow->cnt ?? 0;
$DB->free();
$totalPages = $totalRows > 0 ? (int)ceil($totalRows / $pageSize) : 1;

// 取得目前頁面的資料
$query = "SELECT * FROM UserData WHERE u_name LIKE ? ORDER BY (SELECT NULL) OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$DB->query($query, ['%' . $search . '%', $offset, $pageSize]);
$stmt = $DB->stmt;
if ($stmt === false) {
    die('Query failed.');
}
$metadata = $DB->fieldMetadata();
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
        .content-wrapper {
            background-color: #fff;
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        .add-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .add-box input[type="text"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .add-box button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #2196F3;
            color: #fff;
            cursor: pointer;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
        }
        .pagination a,
        .pagination span {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: #fff;
        }
        .pagination a:hover {
            background-color: #45a049;
        }
        .pagination .active {
            background-color: #2e7d32;
            font-weight: bold;
        }
        .pagination .disabled {
            background-color: #9e9e9e;
            pointer-events: none;
        }
        .pagination .ellipsis {
            background-color: transparent;
            color: #555;
            padding: 0 5px;
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
<div class="content-wrapper">
<form method="get" class="search-box">
    <input type="text" name="u_name" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="搜尋名稱">
    <button type="submit">搜尋</button>
</form>
<?php if (!empty($insertError)): ?>
<p style="color:red;"><?= htmlspecialchars($insertError, ENT_QUOTES, 'UTF-8') ?></p>
<?php elseif (!empty($insertSuccess)): ?>
<p style="color:green;"><?= htmlspecialchars($insertSuccess, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<form method="post" class="add-box">
    <input type="text" name="u_name" required placeholder="新增名稱">
    <button type="submit">新增</button>
</form>
<div class="table-container">
<table>
    <tr>
        <?php foreach ($metadata as $field): ?>
            <th><?= htmlspecialchars((string)($field['Name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></th>
        <?php endforeach; ?>
    </tr>
    <?php while (($row = $DB->fetchObject()) !== false): ?>
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
        echo '<a href="?page=' . ($page - 1) . '&u_name=' . urlencode($search) . '" class="prev">&laquo; 上一頁</a>';
    } else {
        echo '<span class="disabled prev">&laquo; 上一頁</span>';
    }

    $start = max(1, min($page - 1, $totalPages - 3));
    $end = min($start + 3, $totalPages);
    if ($start > 1) {
        echo '<span class="ellipsis">...</span>';
    }
    for ($i = $start; $i <= $end; $i++) {
        $active = $i == $page ? ' class="active"' : '';
        echo '<a href="?page=' . $i . '&u_name=' . urlencode($search) . '"' . $active . '>' . $i . '</a>';
    }
    if ($end < $totalPages) {
        echo '<span class="ellipsis">...</span>';
    }

    if ($page < $totalPages) {
        echo '<a href="?page=' . ($page + 1) . '&u_name=' . urlencode($search) . '" class="next">下一頁 &raquo;</a>';
    } else {
        echo '<span class="disabled next">下一頁 &raquo;</span>';
    }
endif;
?>
</div>
</div>
</body>
</html>
<?php
$DB->free();
$DB->close();
?>

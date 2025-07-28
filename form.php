<?php
// 簡單的使用者表單介面，暫不處理表單資料
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>聯絡我們</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 40px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>聯絡我們</h1>
        <form method="post" action="#">
            <label for="name">姓名</label>
            <input type="text" id="name" name="name" required>

            <label for="email">電子郵件</label>
            <input type="email" id="email" name="email" required>

            <label for="message">訊息</label>
            <textarea id="message" name="message" rows="4"></textarea>

            <button type="submit">送出</button>
        </form>
    </div>
</body>
</html>

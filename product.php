<?php
// 彩妝產品介紹網頁
$products = [
    [
        'name' => '夢幻彩妝',
        'tagline' => '打造五彩繽紛的魅力',
        'description' => '這款化妝品融合了多種色彩元素，帶給你獨特又亮麗的妝容。質地柔滑，持久服貼，讓你在各種場合都能散發自信光彩。',
        'price' => 'NT$1,200'
    ],
    [
        'name' => '魅力口紅',
        'tagline' => '讓唇色更加迷人',
        'description' => '高飽和色澤搭配滋潤配方，綻放迷人魅力。',
        'price' => 'NT$800'
    ],
    [
        'name' => '璀璨眼影',
        'tagline' => '閃耀你的雙眸',
        'description' => '細緻粉末與飽和色彩，完美勾勒魅力眼神。',
        'price' => 'NT$900'
    ],
    [
        'name' => '絲滑粉底',
        'tagline' => '打造無瑕底妝',
        'description' => '輕透質地與高遮瑕力，讓妝容自然服貼。',
        'price' => 'NT$1,000'
    ],
    [
        'name' => '珍珠腮紅',
        'tagline' => '展現自然好氣色',
        'description' => '細緻光澤打造健康紅潤臉頰。',
        'price' => 'NT$750'
    ],
    [
        'name' => '魅惑睫毛膏',
        'tagline' => '纖長濃密的秘密',
        'description' => '特殊刷頭讓睫毛根根分明，持久不暈染。',
        'price' => 'NT$850'
    ],
    [
        'name' => '水潤唇膏',
        'tagline' => '滋潤保濕更顯色',
        'description' => '添加保濕成分，讓雙唇持續柔嫩。',
        'price' => 'NT$680'
    ],
    [
        'name' => '極光指甲油',
        'tagline' => '指尖也能耀眼奪目',
        'description' => '亮麗色彩與快速乾燥配方，讓指尖持久閃耀。',
        'price' => 'NT$320'
    ],
    [
        'name' => '清新香水',
        'tagline' => '散發迷人香氣',
        'description' => '清新花果香調，帶來舒適愉悅的氛圍。',
        'price' => 'NT$1,500'
    ],
    [
        'name' => '亮采遮瑕',
        'tagline' => '告別瑕疵煩惱',
        'description' => '高度遮瑕力與自然光澤，展現完美膚質。',
        'price' => 'NT$680'
    ],
    [
        'name' => '柔膚蜜粉',
        'tagline' => '定妝同時柔焦',
        'description' => '細緻粉末控制油光，長效維持妝容。',
        'price' => 'NT$700'
    ],
    [
        'name' => '滋潤唇蜜',
        'tagline' => '晶透光澤立現',
        'description' => '柔潤質地帶來水亮唇妝，散發迷人光彩。',
        'price' => 'NT$580'
    ],
    [
        'name' => '閃耀亮片',
        'tagline' => '派對必備單品',
        'description' => '細緻亮片可用於眼影或臉部裝飾，增添閃耀效果。',
        'price' => 'NT$450'
    ],
    [
        'name' => '淨透卸妝',
        'tagline' => '溫和卸除彩妝',
        'description' => '不刺激配方，輕鬆帶走全臉彩妝與油脂。',
        'price' => 'NT$650'
    ],
    [
        'name' => '零油光蜜粉',
        'tagline' => '長效控油不卡粉',
        'description' => '清爽配方維持肌膚乾爽，讓妝容更持久。',
        'price' => 'NT$720'
    ],
    [
        'name' => '持久眉筆',
        'tagline' => '塑造立體眉形',
        'description' => '順滑筆芯勾勒眉型，耐汗耐油不易脫妝。',
        'price' => 'NT$520'
    ],
    [
        'name' => '奢華護膚霜',
        'tagline' => '深層滋養鎖水',
        'description' => '多重保濕精華，改善乾燥細紋。',
        'price' => 'NT$2,000'
    ],
    [
        'name' => '光感打亮',
        'tagline' => '提亮臉部輪廓',
        'description' => '細緻珠光營造立體光澤。',
        'price' => 'NT$680'
    ],
    [
        'name' => '柔焦妝前乳',
        'tagline' => '平滑毛孔好幫手',
        'description' => '修飾膚質並提升後續妝容服貼度。',
        'price' => 'NT$780'
    ],
    [
        'name' => '全效隔離霜',
        'tagline' => '防曬潤色一次完成',
        'description' => '兼具防曬與校色功能，全天候保護肌膚。',
        'price' => 'NT$950'
    ]
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>化妝品介紹</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #FFCDD2, #F8BBD0, #E1BEE7, #C5CAE9, #B2EBF2);
            color: #333;
            text-align: center;
            padding: 40px;
        }
        .product {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
        }
        .banner {
            background: linear-gradient(90deg, #ffc107, #ff5722);
            color: #fff;
            padding: 30px;
            font-size: 32px;
            margin-bottom: 40px;
        }
        h1 {
            color: #e91e63;
        }
        h2 {
            color: #9c27b0;
        }
        .description {
            color: #3f51b5;
        }
        .price {
            color: #009688;
            font-size: 24px;
        }
        .buy-button {
            display: inline-block;
            background: linear-gradient(90deg, #ff4081, #ff9800);
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="banner">超值優惠！全部商品第二件八折</div>
    <?php foreach ($products as $item): ?>
    <div class="product">
        <h1><?= htmlspecialchars($item['name']) ?></h1>
        <h2><?= htmlspecialchars($item['tagline']) ?></h2>
        <p class="description"><?= htmlspecialchars($item['description']) ?></p>
        <p class="price">價格：<?= htmlspecialchars($item['price']) ?></p>
        <a href="#" class="buy-button">立即購買</a>
    </div>
    <?php endforeach; ?>
</body>
</html>

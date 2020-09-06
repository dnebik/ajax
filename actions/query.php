<?php

/* @var $conect PDO */

if (count($_GET) > 0) {
    session_start();
    require_once "../db/db.php";

    foreach ($_GET as $key => $value) {
        $curentKey = $key;
        $curentValue = $value;
    }

    $_SESSION[$curentKey] = $curentValue;
}

$query = "SELECT p.title, c.cat, col.color, w.weight FROM products AS p
          JOIN cats AS c ON c.id = p.id_cats
          JOIN colors as col ON col.id = p.id_color
          JOIN weights as w ON w.id = p.id_weight          
          WHERE";

foreach ($_SESSION as $key => $value) {
    if (!in_array($key, ["color", "cat", "weight"])) {
        continue;
    }

    if ($value != 'all') {
        $query .= " $key = '$value' AND";
    }
}

$query = trim($query, "WHERE");
$query = trim($query, "AND");

error_log($query);

$products = $conect->prepare($query);
$products->execute();
$products = $products->fetchAll(PDO::FETCH_ASSOC);

?>

<?
if (!$products) {
    ?>
        <div class="null-res container text-sm-center">
            <h2>Товаров не найдено</h2>
        </div>
<? } else {
    foreach ($products as $product) {
        ?>
        <div class="col-3">
            <div class="card">
                <div class="card-title"><?= $product['title'] ?></div>
                <div class="card-body">
                    <p class="lead">Категория: <?= $product['cat'] ?></p>
                    <p class="lead">Цвет: <?= $product['color'] ?></p>
                    <p class="lead">Вес: <?= $product['weight'] ?></p>
                </div>
            </div>
        </div>
    <? }
} ?>
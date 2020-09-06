<?php
session_start();
require_once ("db/db.php");

/* @var $conect PDO */

if (!$_SESSION["cat"]){
    $_SESSION["cat"] = "all";
}
if (!$_SESSION["color"]){
    $_SESSION["color"] = "all";
}
if (!$_SESSION["weight"]){
    $_SESSION["weight"] = "all";
}

$query = "SELECT p.title, c.cat, col.color, w.weight FROM products AS p
          JOIN cats AS c ON c.id = p.id_cats
          JOIN colors as col ON col.id = p.id_color
          JOIN weights as w ON w.id = p.id_weight
          ORDER BY c.cat, col.color, w.weight";
$products = $conect->prepare($query);
$products->execute();
$products = $products->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM cats";
$cats = $conect->prepare($query);
$cats->execute();
$cats = $cats->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM colors";
$colors = $conect->prepare($query);
$colors->execute();
$colors = $colors->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM weights";
$weights = $conect->prepare($query);
$weights->execute();
$weights = $weights->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajax</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>
<body class="body">
    <div class="container">
        <div class="selecting">
            <select name="cat" id="cat">
                <option value="all">Все категории</option>
                <?
                foreach ($cats as $cat) {
                ?>
                <option <?= $_SESSION['cat'] == $cat["cat"] ? "selected" : "" ?> value="<?=$cat["cat"]?>"><?=$cat["cat"]?></option>
                <? } ?>
            </select>

            <select name="color" id="color">
                <option value="all">Все цвета</option>
                <?
                foreach ($colors as $color) {
                    ?>
                    <option <?= $_SESSION['color'] == $color["color"] ? "selected" : "" ?> value="<?=$color["color"]?>"><?=$color["color"]?></option>
                <? } ?>
            </select>

            <select name="weight" id="weight">
                <option value="all">Любой вес</option>
                <?
                foreach ($weights as $weight) {
                    ?>
                    <option <?= ($_SESSION['weights'] == $weight["weight"]) ? "selected" : "" ?> value="<?=$weight["weight"]?>"><?=$weight["weight"]?></option>
                <? } ?>
            </select>
        </div>
        <div class="row cards-block">
            <?
                require_once ("actions/query.php");
            ?>
        </div>
    </div>
</body>


<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/ajax.js"></script>
</html>

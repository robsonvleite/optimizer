<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php
    require __DIR__ . "/../vendor/autoload.php";

    $op = new \CoffeeCode\Optimizer\Optimizer();
    echo $op
        ->optimize(
            "Optimizer Happy and @CoffeeCode",
            "Is a compact and easy-to-use tag creator to optimize your site",
            "https://www.upinside.com.br/coffeecode/optimizer/example/",
            "https://www.upinside.com.br/uploads/images/2017/11/curso-de-html5-preparando-ambiente-de-trabalho-aula-02-1511276983.jpg"
        )
        ->publisher(
            "upinside",
            "robsonvleite",
            "107305124528362639842",
            "103958419096641225872"
        )
        ->twitterCard(
            "@robsonvleite",
            "@robsonvleite",
            "upinside.com.br",
            "summary_large_image"
        )
        ->openGraph(
            "upinside",
            "pt_BR",
            "article"
        )
        ->facebook("626590460695980")//->facebook(null, [9283729732123, 912837192372, 73642734723])
        ->render();
    ?>
</head>
<body>

<h1><?= $op->title; ?></h1>
<p><?= $op->description; ?></p>

<?php
echo "<pre>", print_r($op->data(), true), "</pre>";
echo "<pre>", print_r(array_map("htmlspecialchars", $op->debug()), true), "</pre>";
?>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="<?= \Config::$host . 'css/dashboard/vendor/bootstrap/css/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= \Config::$host . 'css/dashboard/vendor/font-awesome/css/font-awesome.min.css' ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="<?= \Config::$host . 'css/dashboard/style.default.css' ?>">
    <link rel="stylesheet" href="<?= \Config::$host . 'css/dashboard/custom.css' ?>">
    <link rel="icon" href="/img/favicon.png" />
    <?php if(!empty($data['styles'])) :
        foreach($data['styles'] as $style) : ?>
            <link rel="stylesheet" href="<?= \Config::$host . $style . '?v=' . \Config::$version  ?>">
        <?php endforeach;?>
    <?php endif;?>
</head>
<body>
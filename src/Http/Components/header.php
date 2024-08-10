<?php

use Catif\Dofus\HTTP\Controller\BaseController;

$title = BaseController::$title;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= $title ?></title>

  <?= BaseController::importCSS() ?>
</head>

<body>
  <?php require BaseController::FOLDER_COMPONENTS . '/navbar.php'; ?>
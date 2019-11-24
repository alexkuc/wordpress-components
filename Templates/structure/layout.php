<!DOCTYPE html>
<html>
<?= $view->render('structure/head') ?>
<body>
<?= $view->render('structure/header') ?>
<?php $view['slots']->output('_content') ?>
</body>
<?= $view->render('structure/footer') ?>
</html>

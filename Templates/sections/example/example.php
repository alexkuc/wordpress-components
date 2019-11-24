<?php

$view->extend('structure/layout');

echo $view->render('sections/example/snippet');

echo $view->render('sections/example/snippet', ['beans' => 'red beans!']);

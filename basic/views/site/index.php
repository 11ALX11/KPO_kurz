<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = Yii::$app->name;

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Welcome!</h1>

        <p class="lead">You have opened student accounting application.</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['site/students']) ?>">Get started with app</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Github</h2>

                <p>I have an open repository on github.com, it also includes this project. So you can test how link down here works. Check it out!</p>

                <p><a class="btn btn-outline-secondary" href="https://github.com/11ALX11/">Github.com &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Docker</h2>

                <p>I did suffer while trying to learn docker. Now I somehow can build containers with it! And its amazing!
                    Docker takes away repetitive, mundane configuration tasks and is used throughout the development lifecycle 
                    for fast, easy and portable application development.</p>

                <p><a class="btn btn-outline-secondary" href="https://www.docker.com/">Docker &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>About</h2>

                <p>To build and run web site such as this insn't particulary hard nor its easy.
                    Right choice while considering tools to use, also your expierence with them is what defines time and difficulty.</p>

                <p><a class="btn btn-outline-secondary" href="<?= Url::to('site/about') ?>">About &raquo;</a></p>
            </div>
        </div>

    </div>
</div>

<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use Yii;

$this->title = Yii::$app->name . ' - About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>To build and run web site such as this insn't particulary hard nor its easy.
        Right choice while considering tools to use, also your expierence with them is what defines time and difficulty.</p>
    
    <p>This project uses yii2, a php framework and project's main rod.
        I use Docker for it's amazing capabilities in portability.
        And, at last I use PostgreSQL relational database! Very powerfull and most advanced open source relational database.
        In fact, for this project its probably overkill. I should have considered MySQL.</p>

</div>

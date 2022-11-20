<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use Yii;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <h2>PHP extensions</h2>

    <p style="word-wrap: break-word;">
        <output><?= json_encode(get_loaded_extensions()); ?></output>
    </p>

    <h3>'SELECT * FROM pg_database;' example</h3>
    <p>
        <output><?= json_encode(Yii::$app->db->createCommand('SELECT * FROM pg_database')->queryAll()); ?></output>
    </p>

    <p>
        Hash for 'admin' is <output><?= app\models\Users::createHash('admin'); ?></output>
    </p>
    <p>
        Hash for 'user' is <output><?= app\models\Users::createHash('user'); ?></output>
    </p>

    <p>
        User id is <?= Yii::$app->user->getId() ?>
    </p>

    <code><?= __FILE__ ?></code>
</div>

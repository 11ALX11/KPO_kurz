<?php
/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Student\'s debts';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['students/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

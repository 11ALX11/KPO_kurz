<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$model = $data['student'];

$this->title = 'Add new student';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['students/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    This is student creation page. Create new one!
</p>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'add-form']); ?>

            <?= $form->field($model, 'group') ?>

            <?= $form->field($model, 'name') ?>

            <?php for ($it = 1; $it <= 5; $it++) {
                echo $form->field($model, 'credit'.$it)->checkbox();
            } ?>

            <?php for ($it = 1; $it <= 5; $it++) {
                echo $form->field($model, 'exam'.$it);
            } ?>

            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

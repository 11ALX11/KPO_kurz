<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$model = $data['student'];

$this->title = 'Edit student data';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['students/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'edit-form']); ?>

            <?= $form->field($model, 'group') ?>
    
            <?= $form->field($model, 'name') ?>
            
            <?php for ($it = 1; $it <= 5; $it++) {
                echo $form->field($model, 'credit'.$it)->checkbox();
            } ?>
            
            <?php for ($it = 1; $it <= 5; $it++) {
                echo $form->field($model, 'exam'.$it);
            } ?>

            <div class="form-group">
                <?= Html::submitButton('Edit', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

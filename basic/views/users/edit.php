<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

use app\models\Users;

$model = $data['user'];

$this->title = 'Edit user data';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['users/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    This is editing page. Change and fix 'em!
</p>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'edit-form']); ?>

            <?= $form->field($model, 'name')->label('Username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password_hash', ['enableClientValidation' => false])->label("New password")->passwordInput() ?>

            <?= $form->field($model, 'role')->dropDownList(Users::getRoleDropDownListData()) ?>

            <div class="form-group">
                <?= Html::submitButton('Edit', ['class' => 'btn btn-primary', 'name' => 'edit-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

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
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'name')->label('Username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password_hash', ['enableClientValidation' => false])->label("New password") ?>

            <?= $form->field($model, 'role')->dropDownList(Users::getRoleDropDownListData()) ?>

            <div class="form-group">
                <?= Html::submitButton('Edit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

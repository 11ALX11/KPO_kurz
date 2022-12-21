<?php
/** @var yii\web\View $this */
/** @var array $data */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

$this->title = 'Student\'s debts';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['students/index']];
$this->params['breadcrumbs'][] = $this->title;
$model = $data['search_model']; //search model
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    This is student's debts page. Here you can oversee debts!
</p>

<?php if (!empty($data['errors'])) { ?>
  <div class="alert alert-danger">
      <?php foreach ($data['errors'] as $error) {
          echo '<div>'.nl2br(Html::encode($error)).'</div>';
      } ?>
  </div>
<?php } ?>

<div class="above-table-btn-grp">
    <button type="submit" form="search-form" class="btn btn-outline-success btn-search">Search</button>
</div>

<table class="table table-light table-hover">
  <thead>
    <tr>
      <th scope="col" class="col-sm-1">Group №</th>
      <th scope="col" class="col-3">Name</th>
      <th scope="col" class="col">Debts</th>
      <th scope="col" class="col">Avr. score</th>
      <th scope="col" class="col">Avr. group score</th>
    </tr>
  </thead>
  <thead>
    <?php $form = ActiveForm::begin([
      'id' => 'search-form',
      'method' => 'get',
      'action' => [Url::to('students/debts')],
      'fieldConfig' => [
        'template' => '{input}'
      ],
    ]) ?>
    <tr>
      <th scope="col"><?= $form->field($model, 'group') ?></th>
      <th scope="col"><?= $form->field($model, 'name') ?></th>
      <th scope="col"><?= $form->field($model, 'debts') ?></th>
      <th scope="col"><?= $form->field($model, 'avr_score') ?></th>
      <th scope="col"><?= $form->field($model, 'avr_group_score') ?></th>
    </tr>
    <?php ActiveForm::end() ?>
  </thead>
  <tbody>
    <?php foreach ($data['students'] as $student) { ?>
    <tr>
      <th scope="row"><?= $student->group ?></th>
      <td><?= Html::encode($student->name); ?></td>
      <td><?= $student->debts; ?></td>
      <td><?= $student->avr_score; ?></td>
      <td><?= $student->avr_group_score; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?= LinkPager::widget([
    'pagination' => $data['pagination'],
]);
?>
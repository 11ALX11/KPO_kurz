<?php
/** @var yii\web\View $this */
/** @var array $data */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\StudentsSearchForm;

$is_admin = app\models\Users::findIdentity(Yii::$app->user->getId())->isAmdin();

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
$model = $data['search_model']; //search model
$search_dropdown_list = StudentsSearchForm::getSearchCreditDropDownListData();
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    This is students page. Here you can oversee each of them!
</p>

<?php if (Yii::$app->session->hasFlash('studentsAlert')) { ?>
  <div class="alert alert-success">
      <?= nl2br(Html::encode( Yii::$app->session->getFlash('studentsAlert') )); ?>
  </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('studentsRemoveAlert')) { ?>
  <div class="alert alert-warning">
      <?= nl2br(Html::encode( Yii::$app->session->getFlash('studentsRemoveAlert') )); ?>
  </div>
<?php } ?>

<?php if (!empty($data['errors'])) { ?>
  <div class="alert alert-danger">
      <?php foreach ($data['errors'] as $error) {
          echo '<div>'.nl2br(Html::encode($error)).'</div>';
      } ?>
  </div>
<?php } ?>

<div class="above-table-btn-grp">
    <button type="submit" form="search-form" class="btn btn-outline-success btn-search">Search</button>
    <a class="btn btn-outline-dark" href="<?= Url::to(['students/debts']) ?>">Student's debts</a>
    <?php if ($is_admin) { ?><a class="btn btn-outline-primary" href="<?= Url::to(['students/add']) ?>">Add new student</a><?php } ?>
</div>

<table class="table table-light table-hover">
  <thead>
    <tr>
      <th scope="col" class="col-sm-1"><?= $data['sort']->link('group', ['label' => 'Group №']) ?></th>
      <th scope="col" class="col-3"><?= $data['sort']->link('name') ?></th>
      <?php for ($it = 1; $it <= 5; $it++) { ?><th scope="col" class="<?= ($it == 1) ? 'col-1' : 'col' ?>"><?= $data['sort']->link('credit'.$it, ['label' => (($it==1 ? 'Credit ' : '').'№'.$it)]) ?></th><?php } ?>
      <?php for ($it = 1; $it <= 5; $it++) { ?><th scope="col" class="<?= ($it == 1) ? 'col-1' : 'col' ?>"><?= $data['sort']->link('exam'.$it, ['label' => (($it==1 ? 'Exam ' : '').'№'.$it)]) ?></th><?php } ?>
      <?php if ($is_admin) { ?><th scope="col" class="col-1">Actions</th><?php } ?>
    </tr>
  </thead>
  <thead>
    <?php $form = ActiveForm::begin([
      'id' => 'search-form',
      'method' => 'get',
      'action' => [Url::to('students/index')],
      'fieldConfig' => [
        'template' => '{input}'
      ],
    ]) ?>
    <tr>
      <th scope="col"><?= $form->field($model, 'group') ?></th>
      <th scope="col"><?= $form->field($model, 'name') ?></th>
      <?php for ($it = 1; $it <= 5; $it++) { ?><th scope="col"><?= $form->field($model, 'credit'.$it, ['options' => ['class' => 'min-width-field']])->dropDownList($search_dropdown_list) ?></th><?php } ?>
      <?php for ($it = 1; $it <= 5; $it++) { ?><th scope="col"><?= $form->field($model, 'exam'.$it) ?></th><?php } ?>
      <?php if ($is_admin) { ?><th scope="col"></th><?php } ?>
    </tr>
    <?php ActiveForm::end() ?>
  </thead>
  <tbody>
    <?php foreach ($data['students'] as $student) { ?>
    <tr>
      <th scope="row"><?= $student->group ?></th>
      <td><?= Html::encode($student->name); ?></td>
      <td><?= ($student->credit1) ? 'Yes' : 'No'; ?></td>
      <td><?= ($student->credit2) ? 'Yes' : 'No'; ?></td>
      <td><?= ($student->credit3) ? 'Yes' : 'No'; ?></td>
      <td><?= ($student->credit4) ? 'Yes' : 'No'; ?></td>
      <td><?= ($student->credit5) ? 'Yes' : 'No'; ?></td>
      <td><?= $student->exam1; ?></td>
      <td><?= $student->exam2; ?></td>
      <td><?= $student->exam3; ?></td>
      <td><?= $student->exam4; ?></td>
      <td><?= $student->exam5; ?></td>
      <?php if ($is_admin) { ?>
        <td class='table-actions'>
            <a href="<?= Url::to(['students/edit/'.$student->id]) ?>">Edit</a>
            <button 
              class="table-actions-btn table-actions-remove-btn btn-link" 
              type="button" 
              data-bs-toggle="modal" 
              data-bs-target="#RemoveModal" 
              data-action=<?= Url::to(['students/remove/'.$student->id]) ?>
              >Remove
            </button>
        </td>
      <?php } ?>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?= LinkPager::widget([
    'pagination' => $data['pagination'],
]);
?>

<?php if ($is_admin) { ?>
  <div class="modal fade" id="RemoveModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">Warning!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          You are going to delete student, are you sure?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <?= Html::beginForm([
                      Url::to(['students/remove']),
                  ])
                      . Html::submitButton(
                          'Yes',
                          ['class' => 'btn btn-danger']
                      )
                      . Html::endForm()
              ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
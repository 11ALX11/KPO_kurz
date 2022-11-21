<?php
/** @var yii\web\View $this */
/** @var array $data */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$is_admin = app\models\Users::findIdentity(Yii::$app->user->getId())->isAmdin();

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
    This is students page. Here you can oversee each of them!
</p>

<div class="above-table-btn-grp">
    <a class="btn btn-outline-dark" href="<?= Url::to(['students/debts']) ?>">Student's debts</a>
    <?php if ($is_admin) { ?><a class="btn btn-outline-primary" href="<?= Url::to(['students/add']) ?>">Add new student</a><?php } ?>
</div>

<table class="table table-light table-hover">
  <thead>
    <tr>
      <th scope="col" class="col">Group №</th>
      <th scope="col" class="col-2">Name</th>
      <?php for ($it = 1; $it <= 5; $it++) { ?><th scope="col" class="col">Credit №<?= $it ?></th><?php } ?>
      <?php for ($it = 1; $it <= 5; $it++) { ?><th scope="col" class="col">Exam №<?= $it ?></th><?php } ?>
      <?php if ($is_admin) { ?><th scope="col" class="col-1">Actions</th><?php } ?>
    </tr>
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
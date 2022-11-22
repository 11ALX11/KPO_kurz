<?php
/** @var yii\web\View $this */
/** @var array $data */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Users;
use app\models\UsersSearchForm;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

$dropdown_list = Users::getRoleDropDownListData();
$model = $data['search_model']
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
  This is users page. Here you can see every admin and user!
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
    <a class="btn btn-outline-primary" href="<?= Url::to(['users/add']) ?>">Add new user</a>
</div>

<table class="table table-light table-hover">
  <thead>
    <tr>
      <th scope="col" class="col-1"><?= $data['sort']->link('id', ['label' => 'Id']) ?></th>
      <th scope="col"><?= $data['sort']->link('name', ['label' => 'Username']) ?></th>
      <th scope="col"><?= $data['sort']->link('role') ?></th>
      <th scope="col" class="col-3">Actions</th>
    </tr>
  </thead>
  <thead>
    <?php $form = ActiveForm::begin([
      'id' => 'search-form',
      'method' => 'get',
      'action' => [Url::to('users/index')],
      'fieldConfig' => [
        'template' => '{input}'
      ],
    ]) ?>
    <tr>
      <th scope="col"><?= $form->field($model, 'id') ?></th>
      <th scope="col"><?= $form->field($model, 'name') ?></th>
      <th scope="col"><?= $form->field($model, 'role')->dropDownList(UsersSearchForm::getSearchRoleDropDownListData()) ?></th>
      <th scope="col"></th>
    </tr>
  <?php ActiveForm::end() ?>
  </thead>
  <tbody>
    <?php foreach ($data['users'] as $user) { ?>
    <tr>
      <th scope="row"><?= $user->id ?></th>
      <td><?= Html::encode($user->name); ?></td>
      <td><?= $dropdown_list[$user->role]; ?></td>
      <td class='table-actions'>
            <a href="<?= Url::to(['users/edit/'.$user->id]) ?>">Edit</a>
            <button 
              class="table-actions-btn table-actions-remove-btn btn-link" 
              type="button" 
              data-bs-toggle="modal" 
              data-bs-target="#RemoveModal" 
              data-action=<?= Url::to(['users/remove/'.$user->id]) ?>
              >Remove
            </button>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?= LinkPager::widget([
    'pagination' => $data['pagination'],
]);
?>

<div class="modal fade" id="RemoveModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Warning!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        You are going to delete user, are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <?= Html::beginForm([
                    Url::to(['users/remove']),
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
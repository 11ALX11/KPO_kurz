<?php
/** @var yii\web\View $this */
/** @var array $data */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>
  This is users page. Here you can see every admin and user!
</p>

<div class="above-table-btn-grp">
    <a class="btn btn-outline-primary" href="<?= Url::to(['users/add']) ?>">Add new user</a>
</div>

<table class="table table-light table-hover">
  <thead>
    <tr>
      <th scope="col" class="col-1">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Role</th>
      <th scope="col" class="col-3">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data['users'] as $user) { ?>
    <tr>
      <th scope="row"><?= $user->id ?></th>
      <td><?= Html::encode($user->name); ?></td>
      <td><?= $user->role; ?></td>
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
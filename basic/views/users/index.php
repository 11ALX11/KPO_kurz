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
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<a href="<?= Url::to(['users/add']) ?>">Add new user</a>
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
            <?= Html::beginForm([
                    Url::to(['users/remove/'.$user->id]),
                ])
                    . Html::submitButton(
                        'Remove',
                        ['class' => 'table-actions-btn btn-link']
                    )
                    . Html::endForm()
            ?>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?= LinkPager::widget([
    'pagination' => $data['pagination'],
]);
?>
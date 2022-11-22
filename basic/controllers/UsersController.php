<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Users;
use app\models\UsersSearchForm;
use yii\data\ActiveDataProvider;

class UsersController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->isGuest) {
                                return false;
                            }
                            if (Users::findIdentity(Yii::$app->user->getId())->isAmdin()) {
                                return true;
                            }
                            return false;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'remove' => ['post'],
                ],
            ],
        ];
    }

    public function actionAdd()
    {
        $user = new Users();
        if ($user->load(Yii::$app->request->post())) {
            if ($user->password_hash != '') {
                $user->password_hash = Users::createHash($user->password_hash);
                
                if ($user->validate() && $user->save()) {
                    return $this->redirect('/users/index');
                }
                else {
                    return $this->render('@app/views/site/error', [
                        'name' => 'Error saving record',
                        'message' => implode(', ', $user->getErrorSummary(true)),
                    ]);
                }
            }
        }

        $user->password_hash = '';
        $data['user'] = $user;
        return $this->render('add', [
            'data' => $data,
        ]);
    }

    public function actionEdit($id)
    {
        $user = Users::findIdentity($id);

        if ($user == null) {
            return $this->render('@app/views/site/error', [
                'name' => 'Error finding record',
                'message' => 'Failed to find user with id = '.$id.' from table.',
            ]);
        }

        $old_password = $user->password_hash;

        if ($user->load(Yii::$app->request->post())) {
            if ($user->password_hash != '') {
                $user->password_hash = Users::createHash($user->password_hash);
            }
            else {
                $user->password_hash = $old_password;
            }
            
            if ($user->validate() && $user->save()) {
                return $this->redirect('/users/index');
            }
            else {
                return $this->render('@app/views/site/error', [
                    'name' => 'Error saving record',
                    'message' => implode(', ', $user->getErrorSummary(true)),
                ]);
            }
        }

        $user->password_hash = '';
        $data['user'] = $user;
        return $this->render('edit', [
            'data' => $data,
        ]);
    }

    public function actionIndex()
    {
        $query = Users::find()->where(['record_status' => 'ACTIVE']);

        $search_model = new UsersSearchForm();
        if ($search_model->load(Yii::$app->request->get())) {

            if (isset($search_model->id) && !is_null($search_model->id)) {
                if ($search_model->id != '' && $search_model->validate('id')) {
                    $query = $query->andWhere(['id' => $search_model->id]);
                }
            }

            if (isset($search_model->name) && !is_null($search_model->name)) {
                if ($search_model->name != '' && $search_model->validate('name')) {
                    $query = $query->andWhere('name ILIKE \'%'.$search_model->name.'%\'');
                }
            }

            if (isset($search_model->role) && !is_null($search_model->role)) {
                if (array_key_exists($search_model->role, Users::getRoleDropDownListData()) && $search_model->validate('role')) {
                    $query = $query->andWhere(['role' => $search_model->role]);
                }
            }

        }
        $search_model->validate();

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
            ],
            'sort' => [
                'attributes' => [
                    'id',
                    'name',
                    'role',
                ],
            ],
        ]);

        $data['users'] = $provider->getModels();
        $data['pagination'] = $provider->getPagination();
        $data['sort'] = $provider->getSort();
        $data['search_model'] = $search_model;
        $data['errors'] = $search_model->getErrorSummary(true);

        return $this->render('index', [
            'data' => $data,
        ]);
    }

    public function actionRemove($id)
    {
        if (Users::findIdentity($id)->delete()) {
            return $this->redirect('/users/index');
        }

        return $this->render('@app/views/site/error', [
            'name' => 'Error deleting record',
            'message' => 'Failed to remove user with id = '.$id.' from table.',
        ]);
    }

}

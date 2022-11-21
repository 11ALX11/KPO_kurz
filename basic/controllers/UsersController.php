<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Users;
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
                
                if ($user->save()) {
                    return $this->redirect('index');
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

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            return $this->redirect(Yii::$app->user->returnUrl);
        }

        $data['user'] = $user;
        return $this->render('edit', [
            'data' => $data,
        ]);
    }

    public function actionIndex()
    {
        $query = Users::find()->where(['record_status' => 'ACTIVE']);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
            ],
            /*'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC, 
                ]
            ],*/
        ]);

        $data['users'] = $provider->getModels();
        $data['pagination'] = $provider->getPagination();

        return $this->render('index', [
            'data' => $data,
        ]);
    }

    public function actionRemove($id)
    {
        if (Users::findIdentity($id)->delete()) {
            return $this->redirect(Yii::$app->user->returnUrl);
        }

        return $this->render('@app/views/site/error', [
            'name' => 'Error deleting record',
            'message' => 'Failed to remove user with id = '.$id.' from table.',
        ]);
    }

}

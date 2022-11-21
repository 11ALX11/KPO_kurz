<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Users;
use Exception;
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
        return $this->render('add');
    }

    public function actionEdit($id)
    {
        return $this->render('edit');
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

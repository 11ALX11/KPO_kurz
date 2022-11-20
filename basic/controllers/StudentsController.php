<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Users;

class StudentsController extends \yii\web\Controller
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
                        'allow' => 'true',
                        'actions' => ['index', 'debts', 'sort-by-field', 'search-by-field'],
                        'roles' => ['@'],
                    ],
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
                    'sort-by-field' => ['post'],
                    'search-by-field' => ['post'],
                ],
            ],
        ];
    }

    public function actionAdd()
    {
        return $this->render('add');
    }

    public function actionDebts()
    {
        return $this->render('debts');
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRemove()
    {
        return $this->redirect('students/index');
    }

    public function actionSearchByField()
    {
        return $this->redirect('students/index');
    }

    public function actionSortByField()
    {
        return $this->redirect('students/index');
    }

}

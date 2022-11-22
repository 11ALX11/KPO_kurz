<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Users;
use app\models\Students;
use app\models\StudentsSearchForm;
use yii\data\ActiveDataProvider;

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
        $student = new Students();
        if ($student->load(Yii::$app->request->post())) {
            if ($student->validate() && $student->save()) {
                Yii::$app->session->setFlash('studentsAlert', 'You have successfully added new student!');
                return $this->redirect('/students/index');
            }
            else {
                return $this->render('@app/views/site/error', [
                    'name' => 'Error saving record',
                    'message' => implode(', ', $student->getErrorSummary(true)),
                ]);
            }
        }

        $data['student'] = $student;
        return $this->render('add', [
            'data' => $data,
        ]);
    }

    public function actionDebts()
    {
        return $this->render('debts');
    }

    public function actionEdit($id)
    {
        $student = Students::findOne($id);

        if ($student == null) {
            return $this->render('@app/views/site/error', [
                'name' => 'Error finding record',
                'message' => 'Failed to find student with id = '.$id.' from table.',
            ]);
        }

        if ($student->load(Yii::$app->request->post())) {
            if ($student->validate() && $student->save()) {
                Yii::$app->session->setFlash('studentsAlert', 'You have successfully edited student!');
                return $this->redirect('/students/index');
            }
            else {
                return $this->render('@app/views/site/error', [
                    'name' => 'Error saving record',
                    'message' => implode(', ', $student->getErrorSummary(true)),
                ]);
            }
        }

        $data['student'] = $student;
        return $this->render('edit', [
            'data' => $data,
        ]);
    }

    public function actionIndex()
    {
        $query = Students::find()->where(['record_status' => 'ACTIVE']);

        $search_model = new StudentsSearchForm();
        if ($search_model->load(Yii::$app->request->get())) {

            if (isset($search_model->group) && !is_null($search_model->group)) {
                if (!empty($search_model->group) && $search_model->validate('group')) {
                    $query = $query->andWhere(['group' => $search_model->group]);
                }
            }

            if (isset($search_model->name) && !is_null($search_model->name)) {
                if (!empty($search_model->name) && $search_model->validate('name')) {
                    $query = $query->andWhere('name ILIKE \'%'.$search_model->name.'%\'');
                }
            }

            for ($it = 1; $it <= 5; $it++) {
                
                if (isset($search_model['credit'.$it]) && !is_null($search_model['credit'.$it])) {
                    if (!empty($search_model['credit'.$it]) && $search_model->validate('credit'.$it)) {
                        $query = $query->andWhere(['credit'.$it => $search_model['credit'.$it]]);
                    }
                }

                if (isset($search_model['exam'.$it]) && !is_null($search_model['exam'.$it])) {
                    if (!empty($search_model['exam'.$it]) && $search_model->validate('exam'.$it)) {
                        $query = $query->andWhere(['exam'.$it => $search_model['exam'.$it]]);
                    }
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
                    'group',
                    'name',
                    'credit1',
                    'credit2',
                    'credit3',
                    'credit4',
                    'credit5',
                    'exam1',
                    'exam2',
                    'exam3',
                    'exam4',
                    'exam5',
                ],
            ],
        ]);

        $data['students'] = $provider->getModels();
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
        if (Students::findOne($id)->delete()) {
            Yii::$app->session->setFlash('studentsRemoveAlert', 'You have successfully removed student!');
            return $this->redirect('/students/index');
        }

        return $this->render('@app/views/site/error', [
            'name' => 'Error deleting record',
            'message' => 'Failed to remove student with id = '.$id.' from table.',
        ]);
    }

}

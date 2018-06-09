<?php

namespace backend\modules\editor\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class ArticleController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Debit models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

}

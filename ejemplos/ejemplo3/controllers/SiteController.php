<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Catalogo;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionInicio()
    {
        return $this->render('index');
    }
    
    public function actionCatalogo()
    {
        
        //select * from catalogo
        $dataProvider = new \yii\data\ActiveDataProvider(['query'=> \app\models\Catalogo::find()]);
        return $this->render('Catalogo',["datos"=>$dataProvider,]);
    }
    
    public function actionRecomendar(){
    $model= Catalogo::find()
            ->offset(random_int(0,Catalogo::find()->count()-1)
                    )
            ->limit(1)
            ->one();
    return $this->render('recomendar', ["dato"=>$model]);
    }
}

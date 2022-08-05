<?php

namespace app\controllers;

use app\models\Checker;
use app\models\Url;
use app\models\UrlForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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

    public function actionIndex()
    {
        $model = new UrlForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->timeRefresh = 0;
            $model->error = 0;
            $model->save();
            return $this->render('index', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('index', ['model' => $model]);
        }
    }

    public static function isSiteAvailible($url) {

        // Инициализация cURL
        $curlInit = curl_init($url);

        // Установка параметров запроса
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

        // Получение ответа
        $response = curl_exec($curlInit);
        $httpcode = curl_getinfo($curlInit, CURLINFO_HTTP_CODE);
        // закрываем CURL
        curl_close($curlInit);

        return $response ? true : false;
    }

    public static function SiteHttpCode($url) {

        // Инициализация cURL
        $curlInit = curl_init($url);

        // Установка параметров запроса
        curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curlInit,CURLOPT_HEADER,true);
        curl_setopt($curlInit,CURLOPT_NOBODY,true);
        curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
        curl_exec($curlInit);
        $httpcode = curl_getinfo($curlInit, CURLINFO_HTTP_CODE);
        // закрываем CURL
        curl_close($curlInit);

        return $httpcode;
    }
    public function actionAdmin(){
        $dataProvider = new ActiveDataProvider([
            'query' => UrlForm::find(),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);
        $request = Yii::$app->request;
        $dataProvider2 = new ActiveDataProvider([
            'query' => Checker::find()->where(['url_id' => $request->get('id')]),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        if (!$request->get('id')) {
            return $this->render('admin', ['dataProvider' => $dataProvider]);
        } else {
            $url_name = UrlForm::Find()->where(['id' => $request->get('id')])->one()->url;
            return $this->render('admin', ['dataProvider' => $dataProvider2, 'url_name' => $url_name]);
        }
    }
}

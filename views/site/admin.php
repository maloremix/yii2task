<?php

use app\controllers\SiteController;
use app\models\Checker;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var ActiveDataProvider $dataProvider */
/** @var array $arr */
/** @var string $url_name */
$request = Yii::$app->request;
if (!$request->get('id')) {
    echo GridView::widget(array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'url',
            'frequency',
            'replays',
            'date',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{admin}',
                'buttons' => [
                    'admin' => function ($url, $model, $key) {
                        return Html::a('Проверки', $url);
                    }
                ]
            ],
        ),
    ));
} else {
    echo GridView::widget(array(
        'dataProvider' => $dataProvider,
        'columns' => array(
            'date',
            'http',
            'number',
            [
                'attribute'=>'url_name',
                'label'=>'url',
                'content'=>function() use ($url_name) {
                    return $url_name;
                }
            ],
        ),
    ));
}

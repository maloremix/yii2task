<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\controllers\SiteController;
use app\models\UrlForm;
use app\models\Checker;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Query;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UrlController extends Controller
{
    public function actionIndex()
    {
        $urls = UrlForm::find()->all();
        foreach ($urls as $url) {
            $checker = new Checker();
            $checker->url_id = $url->id;
            $checker->http = SiteController::SiteHttpCode($url->url);
            $flag = false;
            if (!$url->error) {
                $checker->number = 1;
            } else {
                $lastId = Checker::find()->andWhere(['url_ud' =>$url->id])->andWhere(['number' => 1])->max('id');
                $number = Checker::find()->andWhere(['url_id' => $url->id])->andWhere('>=', 'id', $lastId)->max('number');
                if ($number == $url->replays - 1){ # если последняя попытка
                    $flag = true;
                }
                $checker->number = ++$number;
            }
            if (SiteController::isSiteAvailible($url->url) || $flag){
                $url->error = 0;
            } else {
                $url->error = 1;
            }
            if (!$url->timeRefresh){
                $url->timeRefresh = $url->frequency;
            } else {
                $url->timeRefresh--;
            }
            if ($url->error || !$url->timeRefresh || $flag) {
                $checker->save();
            }
            $url->save();
        }
    }
}

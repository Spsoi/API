<?php
// app/controllers
// ищем 
<?php

namespace app\controllers;

use app\models\Characteristic;
use app\models\forms\Price;
use app\models\forms\Request;
use app\models\forms\RequestCalcualtion;
use app\models\forms\Section;
use app\models\forms\TestDrive;
use app\models\forms\TestDriveCity;
use app\models\Organization;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;
use app\services\AmoCrmService;

class AjaxController extends Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionFindValuesByGroup()
    {
        return Characteristic::find()->tech()->map();
    }

    public function actionTestDrive()
    {
        $post = ArrayHelper::htmlEncode(Yii::$app->request->post());
        $req = new AmoCrmService();// <- включаем свой класс
        $req->funCurl($post);// <- включаем свой класс
        $model = new TestDrive();
        if($model->load($post, '') && $model->validate() && $model->send()) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false,
                'errors' => $model->errors
            ];
        }
    }

    public function actionRequestCalculation()
    {
        $post = ArrayHelper::htmlEncode(Yii::$app->request->post());
        $req = new AmoCrmService();// <- включаем свой класс
        $req->funCurl($post);// <- включаем свой класс
        $model = new RequestCalcualtion();
        if($model->load($post, '') && $model->validate() && $model->send()) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false,
                'errors' => $model->errors
            ];
        }
    }

    public function actionRequest()
    {
        $post = ArrayHelper::htmlEncode(Yii::$app->request->post());
        $req = new AmoCrmService();// <- включаем свой класс
        $req->funCurl($post);// <- включаем свой класс
        $model = new Request();
        if($model->load($post, '') && $model->validate() && $model->send()) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false,
                'errors' => $model->errors
            ];
        }
    }

    public function actionPrice()
    {
        $post = ArrayHelper::htmlEncode(Yii::$app->request->post());
        $req = new AmoCrmService();// <- включаем свой класс
        $req->funCurl($post); // <- включаем свой класс
        $model = new Price();
        if($model->load($post, '') && $model->validate() && $model->send()) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false,
                'errors' => $model->errors
            ];
        }
    }

    public function actionOrganizations()
    {
        $post = ArrayHelper::htmlEncode(Yii::$app->request->post());
        $req = new AmoCrmService();// <- включаем свой класс
        $req->funCurl($post);// <- включаем свой класс
        if(empty($post['city'])) {
            throw new NotFoundHttpException();
        } else {
            return Organization::find()->select(['organizations.name'])->joinWith('cities', false)->andWhere([
                'cities.name' => $post['city']
            ])->column();
        }
    }

    public function actionTestDriveCity()
    {
        $post = ArrayHelper::htmlEncode(Yii::$app->request->post());
        $req = new AmoCrmService();// <- включаем свой класс
        $req->funCurl($post);// <- включаем свой класс
        $model = new TestDriveCity();
        if($model->load($post, '') && $model->validate() && $model->send()) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false,
                'errors' => $model->errors
            ];
        }
    }


    public function actionSection()
    {
        $post = ArrayHelper::htmlEncode(Yii::$app->request->post());
        $req = new AmoCrmService();// <- включаем свой класс
        $req->funCurl($post);// <- включаем свой класс
        $model = new Section();
        if($model->load($post, '') && $model->validate() && $model->send()) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false,
                'errors' => $model->errors
            ];
        }
    }
}

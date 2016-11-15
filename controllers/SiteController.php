<?php

namespace app\controllers;

use app\models\Page;
use Yii;
use app\models\form\ContactForm;
use yii\web\Controller;

/**
 * Default controller for the `main` module
 */
class SiteController extends Controller
{
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        Page::viewPage('index');

        return $this->render('index');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        Page::viewPage('about');

        return $this->render('about');
    }

    public function actionLeaderboards()
    {
        Page::viewPage('leaderboards');

        return $this->render('leaderboards');
    }

    public function actionFaq()
    {
        Page::viewPage('faq');

        return $this->render('faq');
    }
}

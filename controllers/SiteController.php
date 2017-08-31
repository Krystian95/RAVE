<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use app\models\SignupForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\PostListGenerator;
use app\models\MainCategory;

/*
 * Controller class for the entire site.
 */
class SiteController extends Controller {

    public function behaviors() {
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

    public function actions() {
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

    /*
     * Renders the home page.
     */
    public function actionIndex() {

        $main_category = new MainCategory();
        $category = $main_category->getMainCategory();

        $model = new PostListGenerator($category);
        $postByCategory = $model->getPostsList();

        return $this->render('index', [
                    'category' => $category,
                    'posts' => $postByCategory
        ]);
    }

    /*
     * Renders the login page.
     */
    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /*
     * Redirect in case of logout.
     */
    public function actionLogout() {

        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /*
     * Renders the credits page.
     */
    public function actionCredits() {

        return $this->render('credits');
    }
    
    /*
     * Renders the charts page.
     */
    public function actionCharts() {

        return $this->render('charts');
    }

    /*
     * Renders the register page.
     */
    public function actionSignup() {

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

}

<?php

namespace app\controllers;

use app\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\Cookie;



class UserController extends Controller
{
    public function actionIndex()
    {
        $existUser = self::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        return $this->render('cabinet', ['role' => $existUser['role']]);
    }

    static public function checkLogin()
    {
//        $auth_key = $_COOKIE['auth_key'];

        $cookies = Yii::$app->request->cookies;
        $auth_key = $cookies->getValue('auth_key');

        //CHECK ROOT
        $exist = Users::getUser(['auth_key' => $auth_key], 'check_login');

        if(!$exist)
        {
            $exist = Users::find()->where(['auth_key' => $auth_key])->asArray()->one();
        }

        return $exist;

    }

    public function actionLogin()
    {
        $model = new Users();

        if($model->load(Yii::$app->request->post()))
        {
            $email = Yii::$app->request->post('Users')['email'];
            $password = Yii::$app->request->post('Users')['password'];

            $exist = Users::getUser(['email' => $email, 'password' => $password], 'login');

            if($exist) {
                $this->successLogin($exist['auth_key']);
            }
            else
            {
                $exist = Users::find()->where(['email' => $email, 'password' => md5($password)])->one();

                if($exist)
                {
                    $auth_key = md5($email . Date('d.m.H.i.s'));

                    $exist->auth_key = $auth_key;

                    if($exist->save())
                    {
                        $this->successLogin($auth_key);
                    }
                }
                else
                {
                    $err = 'Incorrect login or password';
                }
            }
        }

        return $this->render('login', ['model' => $model, 'err' => $err]);
    }

    public function actionLogout()
    {
        setcookie('auth_key', null, -1);
        $this->goBack('/web/user/login');
    }

    public function successLogin($auth_key)
    {
        $cookies = Yii::$app->response->cookies;

        $cookies->add(new Cookie([
            'name' => 'auth_key',
            'value' => $auth_key,
            'expire' => time() + 3600,
        ]));

        //setcookie('auth_key', $auth_key, time() + 3600);

        $this->goBack('/web/user');
    }


    public function actionRegister()
    {
        $model = new Users();

        if($model->load(Yii::$app->request->post()))
        {
            if(Yii::$app->request->post('Users')['password'] != Yii::$app->request->post('r_password'))
                $err = 'Repeat password incorrect';
            else if(!Users::find()->where(['email' => Yii::$app->request->post('Users')['email']])->one())
            {
                $model->reg_date = Date('d.m.Y - H:i');
                $model->role = 'user';
                $model->password = md5($model->password);

                if($model->save())
                {
                    $model->password = '';
                    $success = 'Register success';
                }

            }
            else
                $err = 'This email is already';
        }


        return $this->render('register', ['model' => $model, 'success' => $success, 'err' => $err]);
    }

    public function actionAccounts()
    {
        $existUser = self::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');
        else if($existUser['role'] == 'user')
            $this->goBack('/web/user/');


        $users = Users::find()->asArray()->all();

        if(Yii::$app->request->post())
        {
            $user = Users::find()->where(['u_id' => Yii::$app->request->post('u_id')])->one();

            if($user->delete())
                $this->goBack($_SERVER['REQUEST_URI']);
        }

        return $this->render('accounts', ['users' => $users]);
    }

    public function actionEdit()
    {
       $model = Users::find()->where(['u_id' => Yii::$app->request->get('id')])->one();

        if($model->load(Yii::$app->request->post())) {

            if(!Users::find()->where(['email' => Yii::$app->request->post('Users')['email']])->andWhere(['!=', 'u_id', Yii::$app->request->get('id')])->one())
            {
                $model->role = Yii::$app->request->post('Users')['role'];

                if($model->save())
                    $this->goBack('/web/user/accounts');
            }
            else
                $err = 'This email is already';

        }

        return $this->render('edit', ['model' => $model, 'err' => $err]);
    }
}


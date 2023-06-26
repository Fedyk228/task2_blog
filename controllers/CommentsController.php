<?php

namespace app\controllers;

use app\models\Comments;
use app\models\Posts;
use Yii;
use yii\web\Controller;


class CommentsController extends Controller
{
    public function actionIndex()
    {
        $existUser = UserController::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        $comments = Comments::find()->select('*')->innerJoin(Posts::tableName(), Comments::tableName() . '.post_id = ' . Posts::tableName() . '.p_id')->where([Comments::tableName() . '.author_id' => $existUser['u_id']])->asArray()->all();


        if(Yii::$app->request->post())
        {
            $post = Comments::find()->where(['comment_id' => Yii::$app->request->post('comment_id')])->one();

            if($post->delete())
                $this->goBack($_SERVER['REQUEST_URI']);
        }



        return $this->render('comments', ['comments' => $comments]);
    }

    public function actionEdit()
    {
        $existUser = UserController::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        $model = Comments::find()->where(['comment_id' => Yii::$app->request->get('id')])->one();

        if($model && $model->load(Yii::$app->request->post()))
        {

            if($model->save())
                return $this->goBack('/web/comments');

        }

        return $this->render('edit', ['model' => $model]);
    }



}


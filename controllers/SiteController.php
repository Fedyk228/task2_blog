<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Posts;
use app\models\Users;
use app\models\Comments;



class SiteController extends Controller
{

    public function actionIndex()
    {

        if(Yii::$app->request->get('category'))
        {
            $posts = Posts::find()->where(['category_id' => Yii::$app->request->get('category'), 'status' => 3])->asArray()->all();
        }
        else if(Yii::$app->request->get('tag'))
        {
            $posts = Posts::find()->where(['like', 'tags', '%' . Yii::$app->request->get('tag') . '%', false])->andWhere(['status' => 3])->asArray()->all();
        }
        else
        {
            $posts = Posts::find()->where(['status' => 3])->asArray()->all();
        }




        return $this->render('index', ['posts' => $posts]);
    }

    public function actionPost()
    {
        $existUser = UserController::checkLogin();

        $post = Posts::find()->select('*')->innerJoin(Users::tableName(), Posts::tableName() . '.author_id = ' . Users::tableName() . '.u_id')->where(['p_id' => Yii::$app->request->get('id')])->asArray()->one();

        $comments = Comments::find()->select('*')->innerJoin(Users::tableName(), Comments::tableName() . '.author_id = ' . Users::tableName() . '.u_id')->where(['post_id' => Yii::$app->request->get('id')])->asArray()->all();

        $model = new Comments();

        if($existUser && $model->load(Yii::$app->request->post())) {

            $model->post_id = Yii::$app->request->get('id');
            $model->author_id = $existUser['u_id'];

            if($model->save())
                $this->goBack($_SERVER['REQUEST_URI']);

        }

        return $this->render('post', ['post' => $post, 'comments' => $comments, 'model' => $model, 'login' => $existUser]);
    }


    public function actionAbout()
    {
        return $this->render('about');
    }
}

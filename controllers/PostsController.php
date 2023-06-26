<?php

namespace app\controllers;

use app\models\Comments;
use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use app\models\Posts;
use app\models\Categories;
use app\models\Users;







class PostsController extends Controller
{
    public function actionIndex()
    {
        $existUser = UserController::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        if($existUser['role'] == 'admin')
            $posts = Posts::find()->select('*')->innerJoin(Users::tableName(), Posts::tableName() . '.author_id = ' . Users::tableName() . '.u_id')->asArray()->all();
        else
            $posts = Posts::find()->where(['author_id' => $existUser['u_id']])->asArray()->all();

        if(Yii::$app->request->post())
        {
            $post = Posts::find()->where(['p_id' => Yii::$app->request->post('p_id'), 'author_id' => $existUser['u_id']])->one();

            if($post->delete())
                $this->goBack($_SERVER['REQUEST_URI']);
        }

        return $this->render('posts', ['posts' => $posts]);
    }

    public static function getAllCategories()
    {
        return Categories::find()->asArray()->all();
    }


    public static function getAllTags()
    {
        $Tags = Posts::find()->select('tags')->asArray()->all();

        foreach ($Tags as $tag)
        {
            $tag_str .= $tag['tags'] . ', ';
        }

        $tags_list = array_unique(explode(',', $tag_str));

        array_pop($tags_list);

        return $tags_list;
    }


    public function actionCategories()
    {
        $existUser = UserController::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        $categories = self::getAllCategories();

        if(Yii::$app->request->post())
        {
            $post = Categories::find()->where(['c_id' => Yii::$app->request->post('c_id')])->one();

            if($post->delete())
                $this->goBack($_SERVER['REQUEST_URI']);
        }



        return $this->render('categories', ['categories' => $categories]);
    }

    public function actionCategoryAdd()
    {
        $existUser = UserController::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        $model = new Categories();

        if($model->load(Yii::$app->request->post()))
        {
            if($model->save())
                return $this->goBack('/web/posts/categories');

        }

        return $this->render('category-add', ['model' => $model]);
    }

    public function actionCategoryEdit()
    {
        $existUser = UserController::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        $model = Categories::find()->where(['c_id' => Yii::$app->request->get('id')])->one();

        if($model && $model->load(Yii::$app->request->post()))
        {
            if($model->save())
                return $this->goBack('/web/posts/categories');

        }

        return $this->render('category-edit', ['model' => $model]);
    }

    public function getCategories()
    {
        $categories = Categories::find()->asArray()->all();

        foreach ($categories as $category)
        {
            $result[$category['c_id']] = $category['c_title'];
        }

        return $result;
    }

    public function actionAdd()
    {
        $existUser = UserController::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        $model = new Posts();
        $result = $this->getCategories();

        if($model->load(Yii::$app->request->post()))
        {
            $model->picture = UploadedFile::getInstance($model, 'picture');

            if($model->picture) {
                $picture = md5(time() . $model->picture->baseName) . '.' . $model->picture->extension;
                $model->picture->saveAs('upload/' . $picture);
                $model->picture = $picture;
            }
            else
                $model->picture = '';

            $model->pub_date = Date('d.m.Y - H:i');
            $model->author_id = $existUser['u_id'];

            if(!$model->status)
                $model->status = 1;

            if($model->save())
                return $this->goBack('/web/posts');

        }

        return $this->render('add', ['model' => $model, 'categories' => $result, 'role' => $existUser['role']]);
    }

    public function actionEdit()
    {
        $existUser = UserController::checkLogin();

        if(!$existUser)
            $this->goBack('/web/user/login');

        if($existUser['role'] == 'admin')
            $model = Posts::find()->where(['p_id' => Yii::$app->request->get('id')])->one();
        else
            $model = Posts::find()->where(['p_id' => Yii::$app->request->get('id'), 'author_id' => $existUser['u_id']])->one();

        $result = $this->getCategories();

        if($model && $model->load(Yii::$app->request->post()))
        {
            if(!$model->status)
                $model->status = 1;

            $model->picture = UploadedFile::getInstance($model, 'picture');

            if($model->picture) {
                $picture = md5(time() . $model->picture->baseName) . '.' . $model->picture->extension;
                $model->picture->saveAs('upload/' . $picture);
                $model->picture = $picture;
            }
            else
                unset($model->picture);


            if($model->save())
                return $this->goBack('/web/posts');

        }

        return $this->render('edit', ['model' => $model, 'categories' => $result, 'role' => $existUser['role']]);
    }



}


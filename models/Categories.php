<?php

namespace app\models;

use yii\db\ActiveRecord;



class Categories extends ActiveRecord
{
    static public function tableName()
    {
        return 'categories';
    }

    public function rules()
    {
        return [
            [['c_title'], 'required', 'message' => 'Title field required']
        ];
    }

}




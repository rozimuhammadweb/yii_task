<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;


class OutcomeGroups extends ActiveRecord
{

    public static function tableName()
    {
        return 'outcome_groups';
    }


    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}

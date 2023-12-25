<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outcome_groups".
 *
 * @property int $id
 * @property string $name
 *
 * @property Outcome[] $outcomes
 */
class OutcomeGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outcome_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[Outcomes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOutcomes()
    {
        return $this->hasMany(Outcome::class, ['outcome_group_id' => 'id']);
    }
}

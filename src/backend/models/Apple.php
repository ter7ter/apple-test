<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property string $date_create
 * @property string|null $date_fall
 * @property int $fallen
 * @property float $size
 */
class Apple extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_fall'], 'default', 'value' => null],
            [['fallen'], 'default', 'value' => 0],
            [['size'], 'default', 'value' => 1],
            [['color', 'date_create'], 'required'],
            [['date_create', 'date_fall'], 'safe'],
            [['fallen'], 'integer'],
            [['size'], 'number'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'date_create' => 'Date Create',
            'date_fall' => 'Date Fall',
            'fallen' => 'Fallen',
            'size' => 'Size',
        ];
    }

}

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
            [['size'], 'default', 'value' => 1],
            [['color', 'date_create'], 'required'],
            [['date_create', 'date_fall'], 'safe'],
            [['size'], 'number'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    const COLORS = ['red', 'green', 'yellow'];

    public function __construct() {
        parent::__construct();
        $this->date_create = date('Y-m-d H:i:s', time() - rand(0, Yii::$app->params['appleGenerateMaxTime']));
        $this->color = self::COLORS[array_rand(self::COLORS)];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'date_create' => 'Дата появления',
            'date_fall' => 'Дата падения',
            'size' => 'Осталось яблока',
        ];
    }

    public function eat(int $amount) {
        if (!$this->isFallen()) {
            throw new \Exception('Cъесть нельзя, яблоко ещё не упало');
        }
        if ($this->isRotten()) {
            throw new \Exception('Cъесть нельзя, яблоко сгнило');
        }
        $decSize = $amount / 100;
        if ($this->size < $decSize) {
            throw new \Exception('Нельзя съесть больше чем есть яблока');
        }
        $this->size -= $decSize;
        if ($this->size == 0) {
            $this->delete();
        } else {
            $this->save();
        }
    }

    public function fallToGround() {
        if ($this->isFallen()) {
            throw new \Exception('Яблоко уже упало');
        } else {
            $this->date_fall = date('Y-m-d H:i:s');
        }
    }

    public function isRotten() {
        if ($this->isFallen() && time() - strtotime($this->date_fall) > Yii::$app->params['appleRotTime']) {
            return true;
        } else {
            return false;
        }
    }

    public function isFallen() {
        if (is_null($this->date_fall)) {
            return false;
        } else {
            return true;
        }
    }

    public function status() {
        if (!$this->date_fall) {
            return 'На дереве';
        } elseif ($this->isRotten()) {
            return 'Сгнило';
        } else {
            return 'Упало';
        }
    }

}

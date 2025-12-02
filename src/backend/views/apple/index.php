<?php

use backend\models\Apple;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
body { background-color: #2c2e50; color: #ecf0f1; }
.table { background-color: #34495e; color: #ecf0f1; }
.table th, .table td { border-color: #7f8c8d; }
.btn { border-color: #7f8c8d; }
</style>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Сгенерировать яблоки', ['generate'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'color',
                'format' => 'raw',
                'value' => function($model) {
                    return '<span style="color:' . $model->color . ';">' . $model->color . '</span>';
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'value' => function($model) {
                    return $model->status();
                }
            ],
            'attribute' => 'date_create',
            [
                'attribute' => 'date_fall',
                'value' => function($model) {
                    if ($model->date_fall) {
                        return $model->date_fall;
                    } else {
                        return 'Не упало';
                    }
                }
            ],
            [
                'attribute' => 'size',
                'value' => function ($model) {
                    return $model->size * 100 . ' %';

                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{fall} {eat}',
                'buttons' => [
                    'fall' => function ($url, $model, $key) {
                        if (!$model->isFallen()) {
                            return Html::a('Упасть', ['fall', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']);
                        } else {
                            return '';
                        }
                    },
                    'eat' => function ($url, $model, $key) {
                        if ($model->isFallen() && !$model->isRotten()) {
                            return Html::beginForm(['eat', 'id' => $model->id], 'post', ['style' => 'display:inline;']) .
                                Html::input('number', 'percent', 10, ['min' => 1, 'max' => 100, 'style' => 'width:50px;']) . ' ' .
                                Html::submitButton('Съесть', ['class' => 'btn btn-success btn-sm']) .
                                Html::endForm();
                        } else {
                            return '';
                        }
                    },
                ],
            ],
        ],
    ]); ?>


</div>

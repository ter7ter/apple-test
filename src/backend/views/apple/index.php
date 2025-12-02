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
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Apple', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сгенерировать яблоки', ['generate'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'color',
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
                        return date('Y-m-d H:i:s', $this->date_fall);
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
                'urlCreator' => function ($action, Apple $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>

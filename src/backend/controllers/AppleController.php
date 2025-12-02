<?php

namespace backend\controllers;

use backend\models\Apple;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Apple models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Apple::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Generates random apples.
     *
     * @return \yii\web\Response
     */
    public function actionGenerate()
    {
        $count = rand(1, Yii::$app->params['appleGenerateMaxCount']);
        for ($i = 0; $i < $count; $i++) {
            $apple = new Apple();
            $apple->save();
        }
        return $this->redirect(['index']);
    }

    /**
     * Makes an apple fall to ground.
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionFall($id)
    {
        $model = $this->findModel($id);
        try {
            $model->fallToGround();
            $model->save();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * Eats a percentage of the apple.
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEat($id)
    {
        $model = $this->findModel($id);
        $percent = Yii::$app->request->post('percent', 10);
        if ($percent < 0 || $percent > 100) {
            Yii::$app->session->setFlash('error', 'Неверное значение процента');
        } else {
            try {
                $model->eat($percent);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

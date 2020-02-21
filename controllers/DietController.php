<?php

namespace app\controllers;

use Yii;
use app\models\Diet;
use app\models\DietSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * DietController implements the CRUD actions for Diet model.
 */
class DietController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Diet models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->can("manageDiet")){
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
            
        }
        $searchModel = new DietSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Diet model.
     * @param integer $diet_row
     * @param integer $diet_col
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($diet_row, $diet_col)
    {
        if(!Yii::$app->user->can("manageDiet")){
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
            
        }
        return $this->render('view', [
            'model' => $this->findModel($diet_row, $diet_col),
        ]);
    }

    /**
     * Creates a new Diet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can("manageDiet")){
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
            
        }
        $model = new Diet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'diet_row' => $model->diet_row, 'diet_col' => $model->diet_col]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Diet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $diet_row
     * @param integer $diet_col
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($diet_row, $diet_col)
    {
        if(!Yii::$app->user->can("manageDiet")){
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
            
        }
        $model = $this->findModel($diet_row, $diet_col);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'diet_row' => $model->diet_row, 'diet_col' => $model->diet_col]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Diet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $diet_row
     * @param integer $diet_col
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($diet_row, $diet_col)
    {
        if(!Yii::$app->user->can("manageDiet")){
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
            
        }
        $this->findModel($diet_row, $diet_col)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Diet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $diet_row
     * @param integer $diet_col
     * @return Diet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($diet_row, $diet_col)
    {
        if (($model = Diet::findOne(['diet_row' => $diet_row, 'diet_col' => $diet_col])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace frontend\controllers;

use common\models\Outcome;
use common\models\OutcomeSearch;
use common\models\Product;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


class OutcomeController extends Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionIndex()
    {
        $searchModel = new OutcomeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Outcome();
        $products = Product::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }
    public function actionSaveSelectedProducts()
    {
        $model = new Outcome();

        if ($model->load(Yii::$app->request->post())) {
            $model->total_sum = Yii::$app->request->post('Outcome')['total_sum'];
            $model->product_count = Yii::$app->request->post('Outcome')['product_count'];
            $model->date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'success');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'fail');
            }
        }

        $products = Product::find()->all();

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }


    public function actionAjaxGetPrice($productId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $product = Product::findOne($productId);

        if ($product) {
            return [
                'price' => $product->price,
                'quantity' => $product->quantity,
            ];
        } else {
            return ['error' => 'Product not found'];
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Outcome::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
?>


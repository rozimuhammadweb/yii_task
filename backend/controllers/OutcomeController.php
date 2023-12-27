<?php

namespace backend\controllers;

use common\models\Outcome;
use common\models\OutcomeSearch;
use common\models\Product;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OutcomeController implements the CRUD actions for Outcome model.
 */
class OutcomeController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all Outcome models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OutcomeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Outcome model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Outcome model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
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

    public function actionSaveSelectedProducts()
    {
        $model = new Outcome();

        if ($model->load(Yii::$app->request->post())) {
            $model->total_sum = Yii::$app->request->post('Outcome')['total_sum'];
            $model->product_count = Yii::$app->request->post('Outcome')['product_count'];
            $model->date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Success');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to save the outcome.');
            }
        }

        $products = Product::find()->all();

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    public function actionSaveToSession()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $selectedProducts = Yii::$app->request->post('selectedProducts');

        echo "<pre>";
        print_r($selectedProducts);
        echo "</pre>";
        exit();
        return ['success' => true];
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

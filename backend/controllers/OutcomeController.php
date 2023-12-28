<?php

namespace backend\controllers;

use common\models\Outcome;
use common\models\OutcomeSearch;
use common\models\Product;
use common\models\ProductList;
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
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new ProductList();
        $products = Product::find()->all();
        $selectedProducts = ProductList::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->post('submit-button') === 'add-to-list') {
                $selectedProduct = new ProductList();
                $selectedProduct->product_id = $model->product_id;
                $selectedProduct->quantity = Yii::$app->request->post('ProductList')['quantity']; // Set quantity explicitly

                if ($selectedProduct->save()) {
                    $selectedProducts = ProductList::find()->all();
                }
            } elseif ($model->save()) {
//                $selectedProducts = ProductList::find()->all();
                return $this->redirect(['index']);

            }
        }

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
            'selectedProducts' => $selectedProducts,
        ]);
    }

    public function actionTest()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new ProductList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $lists = ProductList::find()->all();
            $view = $this->renderAjax('table', ['lists' => $lists]);
            return [
                'success' => true,
                'view' => $view
            ];
        }
    }


    public function actionAjaxGetPrice($productId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $product = Product::findOne($productId);
        if ($product) {
            $quantity = Yii::$app->request->get('quantity', 1);
            $price = $product->price ?? 0;

            $quantity = intval($quantity);
            $price = floatval($price);

            return [
                'price' => $price,
                'totalSum' => $price * $quantity,
            ];
        } else {
            return ['error' => 'Product topilmadi'];
        }
    }
    public function actionDeleteProductList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $productId = Yii::$app->request->post('id');
        $model = ProductList::findOne($productId);

        if (!$model) {
            return ['success' => false, 'message' => 'Product topilmadi.'];
        }

        if ($model->delete()) {
            $lists = ProductList::find()->all();
            $view = $this->renderPartial('table', ['lists' => $lists]);
            return ['success' => true, 'view' => $view];
        } else {
            return ['success' => false, 'message' => 'Error deleting product.'];
        }
    }


    public function actionSaveSelectedProducts()
    {
        $selectedProducts = Yii::$app->request->post('selectedProducts');

        foreach ($selectedProducts as $selectedProduct) {
            $productId = $selectedProduct['product_id'];
            $quantity = $selectedProduct['count'];


            $product = Product::findOne($productId);
            if (!$product || $product->quantity < $quantity) {
                $response = ['success' => false, 'message' => 'Mahsulot soni bazada yetarli emas: ' . $productId];
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $response;
            }


            $model = new Outcome();
            $model->attributes = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'outcome_group_id' => $selectedProduct['outcome_group_id'],
            ];


            if (!$model->save()) {
                $response = ['success' => false, 'message' => 'Xatolik outcome saqlashda'];
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $response;
            }

            $product->quantity -= $quantity;
            $product->save();
        }

        $response = ['success' => true];
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }


    public function actionSaveToList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $productId = Yii::$app->request->post('product_id');
        $quantity = Yii::$app->request->post('quantity');


        $productList = new ProductList();
        $productList->product_id = $productId;
        $productList->quantity = $quantity;
        $productList->save();

        return ['success' => true];
    }

    public function actionGetSelectedProducts()
    {
        $lists = ProductList::find()->all();
        return $this->renderPartial('table', ['lists' => $lists]);
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

<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\OrderList;
use app\models\Payment;
use app\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Da\QrCode\QrCode;
use yii\base\Security;
use yii\web\ForbiddenHttpException;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can("booking")) {
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
        }

        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can("booking")) {
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
        }

        $checkUser = new Orders();
        $model = $this->findModel($id);
        $modelPay = $this->findModelPay($id);
        if ($model->status == $checkUser::STATUS_YES)
            $this->activeQr($id);

        $OrderList = OrderList::find()->where(['id' => $model->id])->all();


        return $this->render('view', [
            'model' => $model,
            'modelPay' => $modelPay,
            'OrderList' => $OrderList,
        ]);
    }


    public function actionCheckorder()
    {
        
        $sql = "SELECT orders.*,orders.id AS id FROM `orders` 
        LEFT OUTER JOIN payment 
        ON orders.id = payment.id 
        WHERE CURTIME() > DATE_ADD(created_at,INTERVAL 1 DAY) AND status='0'; ";

        $params = [];
        $order = new Orders();

        $kw = Yii::$app->db->createCommand($sql, $params)->queryAll();

        $countCHK = count($kw);

        if ($kw !== NULL) {
            for ($i = 0; $i < count($kw); $i++) {
                $order->id = $kw[$i]['id'];

                Yii::$app->db->createCommand()
                    ->delete('orders', ['id' => $kw[$i]['id']])
                    ->execute();

                Yii::$app->db->createCommand()
                    ->delete('order_list', ['id' => $kw[$i]['id']])
                    ->execute();
            }
        }
        if ($countCHK > 0) {
            $status = 'success';
        }
        json_encode($status);
    }


    public function actionDelete($id)
    {
        if (!Yii::$app->user->can("booking")) {
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
        }
        $this->findModel($id)->delete();
        Yii::$app->db->createCommand()
            ->delete('order_list', ['id' => $id])
            ->execute();

        Yii::$app->db->createCommand()
            ->delete('payment', ['id' => $id])
            ->execute();

        return $this->redirect(['index']);
    }

    public function actionActive($id)
    {
        if (!Yii::$app->user->can("booking")) {
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
        }

        if ($id == NULL)
            throw new NotFoundHttpException('ไม่พบหน้า');
        $model = $this->findModel($id);
        $model->status = Orders::STATUS_YES;
        $model->update();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDownload($id)
    {
        $path = Yii::getAlias('@webroot') . '/img/';
        $file = $path . md5($id) . ".jpg";

        if (file_exists($file)) {
            Yii::$app->response->sendFile($file);
        }
    }

    public function actionUnactive($id)
    {
        $model = $this->findModel($id);
        $model->status = Orders::STATUS_NO;
        $model->update();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionCheckin($id)
    {
        if (!Yii::$app->user->can("booking")) {
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
        }

        $model = $this->findModel($id);
        $guest = OrderList::find()->where(['id' => $model->id])->count();
        $modelList = OrderList::find()->where(['id' => $model->id])->all();
        /* test show value on propety*/
        foreach ($modelList as $key => $value) {
            if ($key > 0)
                continue;
            $diet = $value->diet_row . $value->diet_col;
        }/**/
        if ($model->checkin == '0') {
            $model->checkin = '1';
            $model->update();
            $message = "โต๊ะ $diet ได้เช็คอิน จำนวน $guest ที่นั่ง ";
            $this->notify_message($message);
        }


        return $this->render('checkin', [
            'modelOrder' => $model,
            'guest' => $guest,
            'modelList' => $modelList
        ]);
    }

    public function activeQr($id)
    {
        //Generate Random String
        if (!Yii::$app->user->can("booking")) {
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
        }

        $hash = md5($id);
        $qrCode = (new QrCode('https://www.cedhomecoming.com/cedyiiapp/web/orders/checkin/' . $id))
            ->setSize(600)
            ->setMargin(5)
            ->useForegroundColor(51, 153, 255);

        // now we can display the qrcode in many ways
        // saving the result to a file:

        $dir = Yii::$app->basePath;
        $filename = $dir . "/web/img/" . $hash . ".jpg";
        $qrCode->writeFile($filename); // writer defaults to PNG when none is specified

    }

    public function notify_message($message)
    {
        $line_api = 'https://notify-api.line.me/api/notify';
        $line_token = 'your-linetoken';

        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                    . "Authorization: Bearer " . $line_token . "\r\n"
                    . "Content-Length: " . strlen($queryData) . "\r\n",
                'content' => $queryData
            )
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($line_api, FALSE, $context);
        $res = json_decode($result);
        return $res;
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        //$SearchUser = Orders::find()->where(['id'=>$id,'id'=>Yii::$app->user->identity->id])->one();

        //checkUserForadmin
        $model = null;
        $model = Orders::find()->where(['id' => $id])->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelPay($id)
    {
        $model = Payment::findOne($id);
        return $model;
    }
}

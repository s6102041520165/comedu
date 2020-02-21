<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Guest;
use app\models\Diet;
use app\models\OrderList;
use yii\db\Query;
use app\models\Payment;
use yii\helpers\Url;
use app\models\Orders;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use \app\models\Bank;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;


class BookingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actionStep1()
    {
        if(!Yii::$app->user->can("booking")){
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
            
        }

        $model = new OrderList();
        $updateList = new OrderList();
        $orders = new Orders();
        $request = Yii::$app->request;
        $insertid = null;
        if (isset(Yii::$app->request->post('OrderList')['counter'])) {
            $orders->counter = Yii::$app->request->post('OrderList')['counter'];
            $orders->status = 0;

            if ($orders->counter == 10) {
                $orders->price = 3000;
            } else {
                $orders->price = 320 * $orders->counter;
            }

            if ($orders->save()) {
                $insertid->id;
            }
        }

        $a = 0;
        if ($model->load(Yii::$app->request->post())) {
            for ($i = 0; $i < 10; $i++) {
                foreach ($model as $key => $value) {
                    $updateList->id = $insertid;

                    if ($model->$key[$i] && $key != null) {
                        $data[$key][] =  $model->$key[$i];
                    }
                }
            }
        }

        if ($data) {
            for ($i = 0; $i < $orders->counter; $i++) {
                foreach ($data as $key => $value) {
                    $updateList->$key = $data[$key][$i];
                    echo $data['f_name'][0];
                }
                $updateList->order_id = $orders->id;
                Yii::$app->db->createCommand()->batchInsert('order_list', ['id', 'f_name', 'l_name', 'tel', 'diet_row', 'diet_col'], [
                    [
                        $updateList->id,
                        $updateList->f_name,
                        $updateList->l_name,
                        $updateList->tel,
                        $data['diet_row'][0],
                        $data['diet_col'][0],
                    ],
                ])->execute();
            }
            return $this->redirect(['success', 'id' => $orders->id]);
        }
        if (Yii::$app->request->post()) {
            $row = Yii::$app->request->post('row');
            $col = Yii::$app->request->post('col');
            $max = Yii::$app->request->post('max');
        }
        if (Yii::$app->request->post('numOfPeople')) {
            $numOfPeople = Yii::$app->request->post('numOfPeople');
        } else $numOfPeople = 1;
        return $this->render('step1', ['model' => $model, 'row' => $row, 'col' => $col, 'max' => $max, 'numOfPeople' => $numOfPeople]);
    }

    public function actionIndex()
    {
        if(!Yii::$app->user->can("booking")){
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
            
        }

        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $Diet = new Diet();
        $getDietRow = Diet::find()
            ->select('diet_row')
            ->groupBy('diet_row')
            ->all();

        $getDietCol = Diet::find()
            ->all();

        $NumBooking = OrderList::find()
            ->select('COUNT(id) AS cnt,diet_row,diet_col')
            ->groupBy(['diet_row', 'diet_col'])
            ->all();
        //var_dump($model->load(Yii::$app->request->get()));

        return $this->render(
            'index',
            [
                'Diet' => $Diet,
                'RowDiet' => $getDietRow,
                'NumBooking' => $NumBooking,
                'ColDiet' => $getDietCol,
            ]
        );
    }

    /***
     * 
     * 
     * Action for payment.
     * 
     * * */
    public function actionPayment()
    {
        if(!Yii::$app->user->can("booking")){
            throw new ForbiddenHttpException('ไม่สามารถดูเนื้อหาได้');
            
        }

        $model = new Payment();
        $Orders = new Orders();


        $orderShow = null;
        if (Yii::$app->request->get('id')) {
            $id = Yii::$app->request->get('id');
            if (!($orderShow = Orders::find()->where(['id' => $id, 'created_by' => Yii::$app->user->identity->id])->one()))
                throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->attach = $model->upload($model, 'attach');
            $chkOrders = $Orders->findOne($id);
            //var_dump($chkOrders->id);die();

            if (!empty($chkOrders->id)) {
                $model->save();
                /*
                $message = "มีรายการแจ้งชำระเงินใหม่ รหัสใบจองที่ ".$model->order_id;
                $message.=" โดยคุณ ".$model->f_name." ".$model->l_name;
                $message.=" จำนวนเงิน ".$model->amount." บาท";
                
                $res = $this->notify_message($message);
                */
                return $this->redirect(Url::toRoute('/orders'));
            } else {
                $model->addError('id', 'ไม่พบประวัติการจองของคุณ');
            }
        }

        return $this->render('payment', [
            'model' => $model,
            'orderShow' => $orderShow,
        ]);
    }

    public function actionSuccess($id)
    {
        $model = Bank::find()->one();
        $order = Orders::findOne($id);
        return $this->render('success', [
            'model' => $model,
            'order' => $order,
        ]);
    }

    public function notify_message($message)
    {
        /*
        $line_api = 'https://notify-api.line.me/api/notify';
        $line_token = 'your-line_token';

        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData,'','&');
        $headerOptions = array(
            'http'=>array(
                'method'=>'POST',
                'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                    ."Authorization: Bearer ".$line_token."\r\n"
                    ."Content-Length: ".strlen($queryData)."\r\n",
                'content' => $queryData
            )
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($line_api, FALSE, $context);
        $res = json_decode($result);
        return $res;
        */
        return;
    }
}

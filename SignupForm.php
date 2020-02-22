<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => '{attribute} ต้องไม่เป็นค่าว่าง'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'ไม่สามาถใช้ {attribute} {value} ได้'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => '{attribute} ต้องไม่เป็นค่าว่าง'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'ไม่สามาถใช้ {attribute} {value} ได้'],

            ['password', 'required', 'message' => '{attribute} ต้องไม่เป็นค่าว่าง'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'รหัสอ้างอิง',
            'username' => 'ชื่อผู้ใช้',
            'password' => 'รหัสผ่าน',
            'status' => 'สถานะ',
            'email' => 'อีเมล',
            'created_at' => 'เพิ่มเมื่อ',
            'updated_at' => 'แก้ไขเมื่อ'
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $user::STATUS_ACTIVE;

        $user->setPassword($this->password);
        $user->generateAuthKey();

        
        // the following three lines were added:
        //$user->generateEmailVerificationToken();
        $user->save();
        
        $userRole = ($this->role != null) ? $this->role : "customer";
        $auth = Yii::$app->authManager;
        $customerRole = $auth->getRole($userRole);
        $auth->assign($customerRole, $user->getId());

        return $user;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}

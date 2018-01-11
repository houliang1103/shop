<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $mobile
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $chekcode;//手机验证码
    public $password;//密码
    public $repassword;//确认验证码
    public $captcha_code;//验证码
    public $rememberMe;//记住登录状态

    public function scenarios()
    {
        $parents = parent::scenarios();
        $parents['login']=['password','username','captcha_code','rememberMe'];
        $parents['regist']=['password','username','captcha_code','repassword','email','mobile','chekcode'];
        return $parents;
    }

    //注入行为自动更新时间
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    # 创建之前
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                    # 修改之前
                    self::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password','mobile'], 'required'],
            [['mobile','repassword'], 'required','on' => 'regist'],
            [['rememberMe'],'safe','on'=>'login'],
            [['username'], 'unique','on' => 'regist'],
            [['email'], 'email'],
            [['mobile'], 'match','pattern' => '/0?(13|14|15|17|18|19)[0-9]{9}/','message' => '手机号码不正确','on' => 'regist'],
            [['chekcode'], 'validateCode','on' => 'regist'],
            [['repassword'],'compare','compareAttribute' => 'password','on' => 'regist'],
            [['captcha_code'],'captcha','captchaAction' => '/user/captcha'],
        ];
    }
    //自定义规则验证手机验证码
    public function validateCode($attribute,$params){
        //把存在session的验证码取出来 和当前的对比
        $code=Yii::$app->session->get("tel_".$this->mobile);
        if ($this->chekcode!=$code) {
            $this->addError($attribute,'验证码错误');
        }

    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'mobile' => 'Mobile',
        ];
    }
/**
 * Finds an identity by the given ID.
 * @param string|int $id the ID to be looked for
 * @return IdentityInterface the identity object that matches the given ID.
 * Null should be returned if such an identity cannot be found
 * or the identity is not in an active state (disabled, deleted, etc.)
 */public static function findIdentity($id)
{
    return self::findOne($id);
}/**
 * Finds an identity by the given token.
 * @param mixed $token the token to be looked for
 * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
 * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
 * @return IdentityInterface the identity object that matches the given token.
 * Null should be returned if such an identity cannot be found
 * or the identity is not in an active state (disabled, deleted, etc.)
 */public static function findIdentityByAccessToken($token, $type = null)
{
    // TODO: Implement findIdentityByAccessToken() method.
}/**
 * Returns an ID that can uniquely identify a user identity.
 * @return string|int an ID that uniquely identifies a user identity.
 */public function getId()
{
    return $this->id;
}/**
 * Returns a key that can be used to check the validity of a given identity ID.
 *
 * The key should be unique for each individual user, and should be persistent
 * so that it can be used to check the validity of the user identity.
 *
 * The space of such keys should be big enough to defeat potential identity attacks.
 *
 * This is required if [[User::enableAutoLogin]] is enabled.
 * @return string a key that is used to check the validity of a given identity ID.
 * @see validateAuthKey()
 */public function getAuthKey()
{
    return $this->auth_key;
}/**
 * Validates the given auth key.
 *
 * This is required if [[User::enableAutoLogin]] is enabled.
 * @param string $authKey the given auth key
 * @return bool whether the given auth key is valid.
 * @see getAuthKey()
 */public function validateAuthKey($authKey)
{
    //判断停牌是否一致
    return $this->auth_key===$authKey;
}}

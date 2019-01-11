<?php
namespace oboom\comments\models;

use oboom\gallery\models\Gallery;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
//use oboom\gallery\behaviors\AttachGallery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\rbac\DbManager;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    public $password;
    public $repassword;
    public $avator;



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => 'oboom\gallery\behaviors\AttachGallery',
                //'quality' => 50,
                'mainPathUpload'=>Yii::$app->params['uploadPath'].'/uploads',
                'mode'=>'single',
                'type' => 'avator',
            ],
        ];
    }


    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            [['username','phone','email','password','repassword'],'required','on' => 'create'],
            [['username','phone','email','password','repassword'],'safe','on' => 'update'],

            ['username','unique', 'targetClass' => 'common\models\User', 'message' => 'Логин уже занят. Попробуйте другой'],
            ['email','unique', 'targetClass' => 'common\models\User','message' => 'Этот email уже есть в базе. Попробуйте воспользоваться <a href="">asd</a>'],
            ['phone','unique', 'targetClass' => 'common\models\User'],
            ['password', 'string', 'min' => 6],

            [['avator'], 'file'],

            [['name','surname'],'string','max' => 25],
            ['phone','match', 'pattern'=>'/^\d{3}-\d{3}-\d{4}$/'],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают" ],
            //[['password','username','email'] ,'safe', 'on' => 'update'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'repassword' => 'Пароль',
            'username' => 'Логин',
            'phone' => 'Телефон',
            'avator' => 'Фото профиля',
        ];
    }

    public function getAvatar()
    {
        $data = Gallery::getData($this->getId(),'logo');
        if(!is_null($data)){
            return $data->path;
        }

        return 'http://www.gravatar.com/avatar?d=mm&f=y&s=60';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }


        $this->setPassword($this->password);
        $this->generateAuthKey();

        if ($this->save()) {
            $auth = new DbManager();
            $auth->init();
            $role = $auth->getRole('user');
            $auth ->assign($role,$this->id);
            return $this;
        }
        else {
            return null;
        }
    }
}

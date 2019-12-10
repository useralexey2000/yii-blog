<?php
namespace app\models;
use Yii;
use \yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|not null $username
 * @property string|not null $password
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $_roles;
    public $_user = false;

    public static function tableName()
    {
        return 'user';
    }

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';    

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LOGIN] = ['username', 'password'];
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'password'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['password', 'username'], 'string'],
            [['username', 'password'],
            'match', 'pattern' => '/^[\*a-zA-Z0-9]{4,14}$/',
            'message' => 'Invalid characters in username or password.',
            ],
            [['username'], 'unique', 'on' => self::SCENARIO_REGISTER ],
            [['password'], 'validatePassword', 'on' => self::SCENARIO_LOGIN ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    public static function findIdentity($id)

    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return false;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {   
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($attribute, $params)
    {
        $this->_user = $this->findByUsername($this->username);
        if(!$this->_user || !$this->_user->password === $this->password){
            $this->addError($attribute, 'Incorrect username or password.');
        }
    }

    public function getPosts(){
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    public function getRoles(){

        if(isset($this->roles)){
            return $this->roles;
        }
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($this->getId());
        $roles = ArrayHelper::getColumn($roles, 'name');
        $this->roles = $roles;
        return $roles;
    }

    public function setRoles($roles){
        error_log(implode($roles));
        $this->roles = $roles;
    }

    public function signup(){
        
        if($this->validate()) {
           $this->save();
            //assign role:
            $auth = Yii::$app->authManager;
            $authRole = $auth->getRole('author');
            $auth->assign($authRole, $this->getId());
            return $this;
        }
        return null;
    }

    public function login(){
        if($this->validate()){
            return Yii::$app->user->login($this->_user, 0);
        }
    }
}

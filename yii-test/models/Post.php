<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string|null $content
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $user_id
 */
class Post extends ActiveRecord
{
    //public $_dir = "";

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    
    public static function tableName()
    {
        return 'post';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['image'], 'string'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 99],
            [['title'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'image' => 'Image',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getOwner(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public function getComments(){
        return $this->hasMany(Comment::className(),['post_id'=>'id']);
    }

    public function getPreview(){
        $words =60;
        if(StringHelper::countWords($this->content) > $words){
            return StringHelper::truncateWords($this->content, $words, $suffix = '...', $asHtml = true);
        }
        return $this->content;
    }

    public function getDir(){
        if ($this->_dir === ""){
            $this->_dir = uniqid('', true);
        }
        error_log($this->_dir);
        return $this->_dir;
    }
}

<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \yii\helpers\HtmlPurifier;


/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $content
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $user_id
* @property string|null $post_id
 */
class Comment extends ActiveRecord
{
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
        return 'comment';
    }

    public function rules()
    {
        return [
            [['post_id'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            ['content', 'filter', 'filter' => function($value){
                return HtmlPurifier::process($value);
            }],
            [['created_at', 'updated_at'], 'safe'],
            [['content'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'user_id' => 'User_id',
            'post_id' => 'Post_id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }

    public function getPost(){
        return $this->hasOne(Post::className(),['id'=>'post_id']);
    }

    public function getPreview(){
        $words =20;
        if(StringHelper::countWords($this->content) > $words){
            return StringHelper::truncateWords($this->content, $words, $suffix = '...', $asHtml = true);
        }
        return $this->content;
    }
}

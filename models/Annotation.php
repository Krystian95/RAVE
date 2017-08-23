<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "annotation".
 *
 * @property string $IdAnnotation
 * @property string $annotation
 * @property integer $user_id
 * @property string $article_revision_id
 * @property integer $global_visibility
 * @property string $page_id
 *
 * @property User $user
 */
class Annotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'annotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAnnotation', 'annotation', 'user_id', 'article_revision_id', 'page_id'], 'required'],
            [['IdAnnotation', 'user_id', 'global_visibility'], 'integer'],
            [['annotation'], 'string', 'max' => 1225],
            [['article_revision_id', 'page_id'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAnnotation' => 'Id Annotation',
            'annotation' => 'Annotation',
            'user_id' => 'User ID',
            'article_revision_id' => 'Article Revision ID',
            'global_visibility' => 'Global Visibility',
            'page_id' => 'Page ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

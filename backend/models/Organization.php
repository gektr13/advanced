<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string $name
 * @property string $login
 * @property string $password_hash
 * @property float|null $balance
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Transaction[] $transactions
 */
class Organization extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organizations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['balance'], 'number', 'min' => 0],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 12],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'balance' => 'Balance',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, ['organization_id' => 'id']);
    }

    public function getBalance()
    {
        return Transaction::find()->where(['organization_id' => $this->id, 'type' => Transaction::TYPE_AUGMENT])->sum('value') - Transaction::find()->where(['organization_id' => $this->id, 'type' => Transaction::TYPE_DEDUCT])->sum('value');
    }
}

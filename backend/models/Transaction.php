<?php

namespace backend\models;

use Yii;
use backend\models\Organization;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property int|null $organization_id
 * @property int|null $value
 * @property string $purpose
 * @property int|null $type
 * @property string|null $created_at
 *
 * @property Organization $organization
 */
class Transaction extends \yii\db\ActiveRecord
{
    const TYPE_AUGMENT = 1;
    const TYPE_DEDUCT = 2;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'value', 'created_at'], 'integer'],
            [['type'], 'boolean'],
            [['purpose', 'value'], 'required'],
            [['value'], 'integer', 'min' => 1],
            [['purpose'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organization ID',
            'value' => 'Value',
            'purpose' => 'Purpose',
            'type' => 'type',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Organization]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    public function createTransaction($organization, $transaction)
    {

        $transaction->type ? $organization->balance = $organization->balance + $transaction->value : $organization->balance = $organization->balance - $transaction->value;

        $t = \Yii::$app->db->beginTransaction();

        try {
            if ($organization->save()) {
                $transaction->organization_id = $organization->id;
                $transaction->save();
            }

            $t->commit();

            return true;
        } catch (\Exception $e) {

            $t->rollBack();

            throw $e;
        }
    }
}

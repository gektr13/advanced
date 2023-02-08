<?php

namespace backend\models;

use Yii;
use backend\models\Owner;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property int|null $owner_id
 * @property int|null $value
 * @property string $purpose
 * @property string|null $created_at
 *
 * @property Owner $owner
 */
class Car extends \yii\db\ActiveRecord
{

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
        return 'car';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['owner_id','created_at'], 'integer'],
            [['brand','model','region','price','horsepower', 'year'],'safe'],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Owner::class, 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'brand' => 'Марка',
            'model' => 'Модель',
            'horsepower' => 'Л.С.',
            'price' => 'Цена',
            'year' => 'Год выпуска',
            'region' => 'Регион',
        ];
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Owner::class, ['id' => 'owner_id']);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function create()
    {
        $t = \Yii::$app->db->beginTransaction();
        try {
            $owner= $this->owner;

            if (!($owner instanceof Organization)) {
                throw new \Exception('Необходимо указать владельца');
            }

            if (!$this->validate()) {
                return false;
            }

            $model = new Car();
            $model->owner_id = $this->owner->id;
            $model->brand = $this->brand;
            $model->model = $this->model;
            $model->horsepower = $this->horsepower;
            $model->price = $this->power;
            $model->year = $this->year;
            $model->region = $this->region;

            if ($model->save()) {

                $t->commit();

                return true;
            } else {
                throw new \Exception('Не удалось сохранить транзакцию ' . json_encode($model->errors));
            }
        } catch (\Exception $e) {
            $t->rollBack();
            throw $e;
        }
    }

}

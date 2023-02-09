<?php

namespace backend\models;

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
    /**
     * @var integer
     */
    public $month;

    public $owner;

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
            [['owner_id', 'created_at'], 'integer'],
            [['brand', 'model', 'region', 'price', 'horsepower', 'year', 'month'], 'safe'],
            [['brand', 'model', 'region', 'price', 'horsepower', 'year'], 'required'],
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
            'month' => 'Кол-во месяцев владения в 2022 годы',
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
            $owner = $this->owner;

            if (!($owner instanceof Owner)) {
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
            $model->price = $this->price;
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

    public function getRegionText()
    {
        switch ($this->region) {
            case ($this->region = 1):
                return 'Москва';

            case ($this->region = 2):
                return 'Санкт-Петербург';

            case ($this->region = 3):
                return 'Казань';

        }
        return false;
    }

    public function calculateTax($month)
    {
        $holding_period = $month / 12;

        switch ($this->region) {
            case ($this->region = 1):
                switch ($this->horsepower) {
                    case ($this->horsepower < 100):
                        $rate_tax = 12;
                        break;
                    case ($this->horsepower >= 100 && $this->horsepower < 125):
                        $rate_tax = 25;
                        break;
                    case ($this->horsepower >= 125 && $this->horsepower < 150):
                        $rate_tax = 35;
                        break;
                    case ($this->horsepower >= 150 && $this->horsepower < 175):
                        $rate_tax = 45;
                        break;
                    case ($this->horsepower >= 175 && $this->horsepower < 200):
                        $rate_tax = 50;
                        break;
                    case ($this->horsepower >= 200 && $this->horsepower < 225):
                        $rate_tax = 65;
                        break;
                    case ($this->horsepower >= 225 && $this->horsepower < 250):
                        $rate_tax = 75;
                        break;
                    case ($this->horsepower >= 250):
                        $rate_tax = 150;
                        break;
                }
                break;
            case ($this->region = 2):
                switch ($this->horsepower) {
                    case ($this->horsepower < 100):
                        $rate_tax = 24;
                        break;
                    case ($this->horsepower >= 100 && $this->horsepower < 150):
                        $rate_tax = 35;
                        break;
                    case ($this->horsepower >= 150 && $this->horsepower < 200):
                        $rate_tax = 50;
                        break;
                    case ($this->horsepower >= 200 && $this->horsepower < 250):
                        $rate_tax = 75;
                        break;
                    case ($this->horsepower >= 250):
                        $rate_tax = 150;
                        break;
                }
                break;
            case ($this->region = 3):
                switch ($this->horsepower) {
                    case ($this->horsepower < 100):
                        $rate_tax = 10;
                        break;
                    case ($this->horsepower >= 100 && $this->horsepower < 150):
                        $rate_tax = 35;
                        break;
                    case ($this->horsepower >= 150 && $this->horsepower < 200):
                        $rate_tax = 50;
                        break;
                    case ($this->horsepower >= 200 && $this->horsepower < 250):
                        $rate_tax = 75;
                        break;
                    case ($this->horsepower >= 250):
                        $rate_tax = 150;
                        break;
                }
                break;
        }

        if ($this->year < 2019 && $this->price > 3000000 && $this->price < 5000000) {
            $multifactor = 1.1;
        } elseif ($this->year < 2017 && $this->price > 5000000 && $this->price < 10000000) {
            $multifactor = 2;
        } elseif ($this->year < 2013 && $this->price > 10000000) {
            $multifactor = 3;
        } else($multifactor = 1);

        $tax_sum = $this->horsepower * $rate_tax * $holding_period * $multifactor;

        return $tax_sum;
    }
}

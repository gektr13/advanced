<?php

namespace backend\models;


use yii\base\Model;

class CreateCar extends Model
{
    /**
     * @var Organization
     */
    public $owner;

    /**
     * @var float
     */
    public $price;
    /**
     * @var string
     */
    public $brand;
    /**
     * @var string
     */
    public $model;
    /**
     * @var integer
     */
    public $horsepower;
    /**
     * @var integer
     */
    public $year;
    /**
     * @var float
     */
    public $region;

    /**
     * @inheritDoc
     * @return array
     */
    public function rules()
    {
        return [
            [['brand','model','region','price','horsepower', 'year'],'safe'],
        ];
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
                throw new \Exception('Необходимо указать Владельца');
            }

            if (!$this->validate()) {
                return false;
            }

            $model = new Car();
            $model->owner_id = $this->owner->id;
            $model->brand = $this->brand;
            $model->model = $this->model;
            $model->region = $this->region;
            $model->price = $this->price;
            $model->horsepower = $this->horsepower;
            $model->year = $this->year;


            if ($model->save()) {

                $t->commit();

                return true;
            } else {
                throw new \Exception('Не удалось сохранить автомобиль ' . json_encode($model->errors));
            }
        } catch (\Exception $e) {
            $t->rollBack();
            throw $e;
        }
    }

}
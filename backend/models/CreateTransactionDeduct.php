<?php

namespace backend\models;


use yii\base\Model;

class CreateTransactionDeduct extends Model
{
    /**
     * @var Organization
     */
    public $organization;

    /**
     * @var float
     */
    public $value;
    /**
     * @var string
     */
    public $purpose;

    const DEFAULT_VALUE = 1;

    const DEFAULT_PURPOSE = 'default';

    /**
     * @inheritDoc
     * @return array
     */
    public function rules()
    {
        return [
            [['value'], 'number', 'min' => 0],
            [['purpose'], 'string', 'max' => 255],
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
            $organization = $this->organization;

            if (!($organization instanceof Organization)) {
                throw new \Exception('Необходимо указать организацию');
            }

            if (!$this->validate()) {
                return false;
            }

            $model = new Transaction();
            $model->organization_id = $this->organization->id;
            $model->value = $this->value;
            $model->purpose = $this->purpose;
            $model->type = Transaction::TYPE_DEDUCT;

            if ($organization->balance - $this->value >= 0) {
                if ($model->save()) {

                    if ($organization->save()) {
                        $t->commit();

                        return true;
                    } else {
                        throw new \Exception('Не удалось сохранить баланс организации ' . json_encode($organization->errors));
                    }
                } else {
                    throw new \Exception('Не удалось сохранить транзакцию ' . json_encode($model->errors));
                }
            } else {
                throw new \Exception('Баланс меньше 0> ' . json_encode($model->errors));
            }
        } catch (\Exception $e) {
            $t->rollBack();
            throw $e;
        }
    }

    public function default()
    {
        $t = \Yii::$app->db->beginTransaction();
        try {
            $organization = $this->organization;

            if (!($organization instanceof Organization)) {
                throw new \Exception('Необходимо указать организацию');
            }

            if (!$this->validate()) {
                return false;
            }

            $model = new Transaction();
            $model->organization_id = $this->organization->id;
            $model->value = self::DEFAULT_VALUE;
            $model->purpose = self::DEFAULT_PURPOSE;
            $model->type = Transaction::TYPE_DEDUCT;

            if ($model->save()) {

                $t->commit();

                return true;
            } else {
                var_dump($model->errors);
                throw new \Exception('Не удалось сохранить транзакцию ' . json_encode($model->errors));
            }
        } catch (\Exception $e) {
            $t->rollBack();
            throw $e;
        }
    }
}
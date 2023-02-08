<?php

namespace backend\models;


use Yii;
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
            $model->value = abs($this->value) * -1;
            $model->purpose = $this->purpose;

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
                Yii::$app->session->setFlash('error', "Баланс будет меньше 0!");
            }
        } catch (\Exception $e) {
            $t->rollBack();
            throw $e;
        }
        return false;
    }
}
<?php

namespace backend\models;


use yii\base\Model;

class CreateTransactionAugment extends Model
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
            $model->value = $this->value;
            $model->purpose = $this->purpose;
            $model->type = Transaction::TYPE_AUGMENT;

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
<?php
namespace frontend\modules\User\models;

use Yii;
use yii\base\Model;
use frontend\models\User;

/**
 * Edit form
 */
class EditForm extends Model
{
    // сценарии обработки форм
    const SCENARIO_USER_UPDATE = 'user_update';
    const SCENARIO_COMPANY_UPDATE = 'company_update';

    public $email;
    public $full_name;
    public $description;
    public $years;


    public function scenarios()
    {
//        $scenarios = parent::scenarios();
//        $scenarios[self::SCENARIO_USER_UPDATE] = ['email', 'full_name', 'description','years'];
//        $scenarios[self::SCENARIO_COMPANY_UPDATE] = ['email', 'description'];
//        return $scenarios;
        return [
            self::SCENARIO_USER_UPDATE => ['email', 'full_name', 'description','years'],
            self::SCENARIO_COMPANY_UPDATE => ['email', 'description'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // email
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => 'frontend\models\User', 'message' => 'This email address has already been taken.'],
            ['email', 'isUniqueEmail', 'message' => 'This email address has already been taken.'],

            ['description', 'string', 'max' => 255],

            [['full_name', 'description', 'years'], 'required', 'on' => self::SCENARIO_USER_UPDATE],
            [['phone', 'address'], 'required', 'on' => self::SCENARIO_COMPANY_UPDATE],

        ];
    }

    /**
     * @param $email
     *
     * проверяет уникальность email
     */
    public function isUniqueEmail($email)
    {
        $user = Yii::$app->user->identity;

        $user->isUniqueEmail($email);
    }
    public function save()
    {

        if($this->validate()) {

            $user = Yii::$app->user->identity;

            $user->email = $this->email;

            $user->full_name = isset($this->full_name) ? $this->full_name : null;
            $user->description = isset($this->description) ? $this->description : null;
            $user->years = isset($this->years) ? $this->years : null;
            $user->updated_at = time();

            if($user->save(false)) {
                return true;
            }
            return false;
        }
    }
}

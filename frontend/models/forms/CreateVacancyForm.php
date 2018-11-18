<?php
namespace frontend\models\forms;

use frontend\models\Vacancy;
use Yii;
use yii\base\Model;
use frontend\models\User;

/**
 * CreateVacancy form
 */
class CreateVacancyForm extends Model
{

    public $position;
    public $salary;
    public $description;
    public $experience;
    public $responsibilities;
    public $offer;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'salary', 'description', 'experience', 'responsibilities', 'offer'], 'required'],
            ['description', 'string', 'max' => 255],
            ['responsibilities', 'string', 'max' => 255],
            ['offer', 'string', 'max' => 255],

        ];
    }

    public function save()
    {

        if($this->validate()) {

            $currentUser = Yii::$app->user->identity;

            $vacancy = new Vacancy();

            $vacancy->title = $this->position;
            $vacancy->salary = $this->salary;
            $vacancy->description = $this->description;
            $vacancy->experience = $this->experience;
            $vacancy->responsibilities = $this->responsibilities;
            $vacancy->offer = $this->offer;
            $vacancy->user_id = $currentUser->getId();
            $vacancy->created_at = $time = time();
            $vacancy->updated_at = $time;

            if($vacancy->save(false)) {
                return true;
            }
            return false;
        }
    }
}

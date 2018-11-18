<?php
namespace frontend\models\forms;

use frontend\models\Resume;
use Yii;
use yii\base\Model;
use frontend\models\User;

/**
 * CreateVacancy form
 */
class CreateResumeForm extends Model
{

    public $position;
    public $salary;
    public $description;
    public $experience;
    public $working_experience;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'salary', 'description', 'experience', 'working_experience'], 'required'],
            ['description', 'string', 'max' => 255],
        ];
    }

    public function save()
    {

        if($this->validate()) {

            $currentUser = Yii::$app->user->identity;

            $resume = new Resume();

            $resume->title = $this->position;
            $resume->salary = $this->salary;
            $resume->description = $this->description;
            $resume->experience = $this->experience;
            $resume->working_experience = $this->working_experience;
            $resume->user_id = $currentUser->getId();

            $resume->created_at = $time = time();
            $resume->updated_at = $time;

            if($resume->save(false)) {
                return true;
            }
            return false;
        }
    }
}

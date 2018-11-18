<?php

namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;
use Intervention\Image\ImageManager;

class PictureForm extends Model
{

    /* @var $picture string | null
     * Содержит в себе адрес картинки пользователя
     */
    public $picture;

    public function rules()
    {
        return [
            [['picture'], 'file',
                'extensions' => ['jpg'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize(),
            ],
        ];
    }

    /**
     * вызывается этот метод при каждом создании нового объекта
     *
     **/
    public function __construct()
    {
        // вызываем метод ресайза загруженной картинки
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
    }

    /**
     * Resize picture if needed
     */
    public function resizePicture()
    {
        if ($this->picture->error) {
            /* В объекте UploadedFile есть свойство error. Если в нем "1", значит
            * произошла ошибка и работать с изображением не нужно, прерываем
            * выполнение метода */
            return;
        }

        // берём размеры картинки из params.php
        $width = Yii::$app->params['profilePicture']['maxWidth'];
        $height = Yii::$app->params['profilePicture']['maxHeight'];

        // использование плагина intervention
        $manager = new ImageManager(array('driver' => 'imagick'));

        $picture = $manager->make($this->picture->tempName);

        // 3-й аргумент - органичения - специальные настройки при изменении размера
        $picture->resize($width, $height, function ($constraint) {

            // Пропорции изображений оставлять такими же (например, для избежания широких или вытянутых лиц)
            $constraint->aspectRatio();

            // Изображения, размером меньше заданных $width, $height не будут изменены:
            $constraint->upsize();

        })->save();
    }

    /**
     * @return integer
     */
    public function getMaxFileSize()
    {
        return Yii::$app->params['maxFileSize'];
    }
}
<?
namespace app\models;

use Yii;
use yii\base\Model;

class ReviewForm extends Model
{
    public $name;
    public $title;
    public $review;
    public $raiting;

    public function rules()
    {
        return [
            [['name', 'title', 'review', 'raiting'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Представтесь',           
            'review' => 'Оставьте свое сообщение',
            'title' => 'Тема',

        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
}
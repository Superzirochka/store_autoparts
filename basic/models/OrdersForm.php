<?

namespace app\models;

use Yii;
use yii\base\Model;



class OrdersForm extends Model
{
    public $name;
    public $lastname;
    public $email;
    public $phone;
    public $note;
    public $shiping;
    public $shipingCity;
    public $adress;
    public $cash;
    public $mailing;


    /**
     * @return array the validation rules.
     */

    public function rules()
    {
        return [
            [['name', 'lastname', 'email', 'phone', 'shiping', 'shipingCity', 'adress', 'cash'], 'required', 'message' => 'Не все данные введены. '],
            ['note', 'default'],
            ['shipingCity', 'default'],
            ['mailing', 'default'],
        ];
    }

 /**
     * @return array customized attribute labels
     */

    public function attributeLabels()
    {
        return [
            'mailing' => 'Я согласен получать рассылку',

        ];
    }
}
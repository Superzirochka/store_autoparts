<?

namespace app\models;

use Yii;
use yii\base\Model;



class ZakazForm extends Model
{
    public $marka;
    public $model;
    public $years;
    public $volume;
    public $eng;
    public $vin;
    public $description;
    public $fio;
    public $email;
    public $phone;

    public function rules()
    {
        return [
            [['marka', 'model', 'years', 'volume', 'eng', 'description', 'fio', 'email', 'phone'], 'required', 'message' => 'Не все данные введены. '],
            ['email', 'email'],
            ['vin', 'default'],
        ];
    }

    public function attributeLabels()
    {
        return [
            
            'marka' => Yii::t('app', 'Марка автомобиля'),
            'model' => Yii::t('app', 'Модель автомобиля'),
            'years' => Yii::t('app', 'Год выпуска'),
            'volume' => Yii::t('app', 'Объем двигателя'),
            'eng'=>Yii::t('app', 'Топливо'),
            'vin' => Yii::t('app', 'Vin код'),
            'description' => Yii::t('app', 'Содержание заказа'),
            'fio' => Yii::t('app', 'ФИО'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Номер телефона'),
            
        ];
    }
    public static function getAllName()
    {
        return self::findAll(['status' => self::STATUS_ACTIVE]);
    }
  
  
    
}
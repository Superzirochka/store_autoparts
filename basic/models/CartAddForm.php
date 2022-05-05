<?

namespace app\models;

use yii\base\Model;



class CartAddForm extends Model
{
    public $quant;


    public function rules()
    {
        return [
            [['quant'], 'required'],
        ];
    }
}
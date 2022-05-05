<?

namespace app\models;

use yii\base\Model;



class UpForm extends Model
{
    public $quanty;
    public $idB;
    public $idz;

    public function rules()
    {
        return [
            [['quanty','idB','idz'], 'default'],
           

        ];
    }
}
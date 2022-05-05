<?

namespace app\models;


use Yii;
use yii\base\Model;



class SortForm extends Model
{
    public $sort;
   

    public function rules()
    {
        return [
            [['sort'], 'default'],
           

        ];
    }

    public function attributeLabels()
    {
        return [
            'sort' => Yii::t('app', 'Сортировать '),            
        ];
    }

}
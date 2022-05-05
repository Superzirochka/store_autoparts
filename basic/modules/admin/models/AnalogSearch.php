<?


namespace app\modules\admin\models;
use Yii;
use yii\base\Model;
use app\modules\admin\models\Analog;
use yii\data\ActiveDataProvider;

class AnalogSearch extends Analog
{
    public $OEM;
    public $Marka;
    public $Analog;
    public $Brand;
  
    
    public function rules()
    {
        // только поля определенные в rules() будут доступны для поиска
        return [
            // [['Name', 'Status', 'MetaTitle'], 'string'],
            // [['Price'], 'number'],
            [['OEM', 'Marka', 'Analog','Brand'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $oem='')
    {
         if ($oem == '') {
            $query = Analog::find(); 
           // $analog =  Analog::find()->orderBy(['Analog' => SORT_DESC]);
        } else {
            $query =  Analog::find()->where(['OEM' => $oem]);
        }  
              

        // загружаем данные формы поиска и производим валидацию
        // if (!($this->load($params) && $this->validate())) {
        //     return $dataProvider;
        // }
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
            $query->andFilterWhere([
                'OEM' => $this->OEM,           
              'Brand' => $this->Brand,
                'Marka' => $this->Marka,
                'Analog' => $this->Analog,
              
            ]);
        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['OEM'=> $this->OEM]);
        $query->andFilterWhere(['like', 'Brand', $this->Brand])
        ->andFilterWhere(['like', 'Marka', $this->Marka])
            ->andFilterWhere(['like', 'Analog', $this->Analog])
            //->andFilterWhere(['like', 'DateAdd', $this->DateAdd]) 
            ;
          //  if (isset($this->Name)){
        //         $query->andWhere('Name like concat("%", :param1)',
        //             [':param1'=> $this->Name]);
         
        //  }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
      //  var_dump($dataProvider);
        return $dataProvider;
    }
}
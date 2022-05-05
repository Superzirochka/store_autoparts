<?


namespace app\modules\admin\models;
use Yii;
use yii\base\Model;
use app\modules\admin\models\Products;
use yii\data\ActiveDataProvider;

class ProductsSearch extends Products
{
    public $Name;
    public $Status;
    public $MetaTitle;
    public $Price;
    public $DateAdd;
    
    public function rules()
    {
        // только поля определенные в rules() будут доступны для поиска
        return [
            // [['Name', 'Status', 'MetaTitle'], 'string'],
            // [['Price'], 'number'],
            [['Name', 'Status', 'MetaTitle','DateAdd','Price'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Products::find();

       

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
                'Price' => $this->Price,           
              'Name' => $this->Name,
                'MetaTitle' => $this->MetaTitle,
                'Status' => $this->Status,
                'DateAdd' => $this->DateAdd,
            ]);
        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['Name'=> $this->cleanSearchString($this->Name)]);
        $query->andFilterWhere(['like', 'Status', $this->Status])
        ->andFilterWhere(['like', 'MetaTitle', $this->MetaTitle])
            ->andFilterWhere(['like', 'Price', $this->Price])
            ->andFilterWhere(['like', 'DateAdd', $this->DateAdd]) 
            ;
     
          
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }

    protected function cleanSearchString($search)
    {
        $search = iconv_substr($search, 0, 64);
        // удаляем все, кроме букв и цифр
        // $search = preg_replace('#[-]#u', ' ', $search); //убирает -
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ\-]#u', ' ', $search); // исключаем -' \-'
        // сжимаем двойные пробелы
        //   $search = preg_replace('#\s+#u', ' ', $search);
        $search = trim($search);
        return $search;
    }
    
}
<?php

namespace app\modules\api\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $Id
 * @property string $Login
 * @property string $FName
 * @property string $LName
 * @property string $Email
 * @property string $Phone
 * @property string $Password
 * @property string $News
 * @property string $City
 * @property string $Adres
 * @property int|null $IdGruop
 * @property string $hash
 * @property string|null $password_reset_token
 * @property int $Status
 * @property string|null $DateRegistration
 *
 * @property Cart[] $carts0
 * @property Review[] $reviews0
 * @property Wishlist[] $wishlists0
 */
class Customers extends \app\models\Customers
{




    public function fields()
    {
        // yii\db\ActiveRecord :: fields( );
        $fields = parent::fields();

        // удаляем небезопасные поля
        unset($fields['Password'], $fields['hash'], $fields['password_reset_token']);

        // return $fields;
        return ['FName', 'LName', 'Id', 'Email', 'Phone', 'City', 'Adres', 'Status', 'DateRegistration', 'News'];
    }

    public function rules()
    {
        return [
            [['Email'], 'unique'],
        ];
    }
}

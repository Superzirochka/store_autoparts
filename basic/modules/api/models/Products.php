<?php

namespace app\modules\api\models;

use Yii;

/**
 * @OA\Schema(
 *      schema="Products",
 *      required={"Name"},
 *     @OA\Property(
 *        property="Id",
 *        description="",
 *        type="integer",
 *        format="int64",
 *    ),
 *     @OA\Property(
 *        property="Name",
 *        description="",
 *        type="string",
 *        maxLength=100,
 *    ),
 *     @OA\Property(
 *        property="Description",
 *        description="",
 *        type="string",
 *    ),
 *     @OA\Property(
 *        property="Img",
 *        description="",
 *        type="string",
 *        maxLength=150,
 *    ),
 *     @OA\Property(
 *        property="Img2",
 *        description="",
 *        type="string",
 *        maxLength=500,
 *    ),
 *     @OA\Property(
 *        property="Tegs",
 *        description="",
 *        type="string",
 *        maxLength=1000,
 *    ),
 *     @OA\Property(
 *        property="MetaDescription",
 *        description="",
 *        type="string",
 *        maxLength=250,
 *    ),
 *     @OA\Property(
 *        property="MetaTitle",
 *        description="",
 *        type="string",
 *        maxLength=170,
 *    ),
 *     @OA\Property(
 *        property="MetaKeyword",
 *        description="",
 *        type="string",
 *        maxLength=500,
 *    ),
 *     @OA\Property(
 *        property="IdBrand",
 *        description="",
 *        type="integer",
 *        format="int64",
 *    ),
 *     @OA\Property(
 *        property="Id_lang",
 *        description="",
 *        type="integer",
 *        format="int64",
 *    ),
 *     @OA\Property(
 *        property="Id_category",
 *        description="",
 *        type="integer",
 *        format="int64",
 *    ),
 *     @OA\Property(
 *        property="Markup",
 *        description="наценка",
 *        type="integer",
 *        format="int64",
 *        default="50",
 *    ),
 *     @OA\Property(
 *        property="Conventional_units",
 *        description="условные единицы",
 *        type="number",
 *        format="double",
 *    ),
 *     @OA\Property(
 *        property="Price",
 *        description="",
 *        type="number",
 *        format="double",
 *        default="0",
 *    ),
 *     @OA\Property(
 *        property="Id_discont",
 *        description="",
 *        type="integer",
 *        format="int64",
 *        default="1",
 *    ),
 *     @OA\Property(
 *        property="Availability",
 *        description="",
 *        type="integer",
 *        format="int64",
 *        default="1",
 *    ),
 *     @OA\Property(
 *        property="Id_current",
 *        description="",
 *        type="integer",
 *        format="int64",
 *        default="1",
 *    ),
 *     @OA\Property(
 *        property="MinQunt",
 *        description="",
 *        type="integer",
 *        format="int64",
 *    ),
 *     @OA\Property(
 *        property="Units",
 *        description="",
 *        type="string",
 *        maxLength=20,
 *    ),
 *     @OA\Property(
 *        property="DateAdd",
 *        description="",
 *        type="string",
 *        format="date-time",
 *        default="CURRENT_TIMESTAMP",
 *    ),
 *     @OA\Property(
 *        property="Status",
 *        description="",
 *        type="integer",
 *        format="int64",
 *        default="10",
 *    ),
 *     @OA\Property(
 *        property="Description_ua",
 *        description="",
 *        type="string",
 *    ),
 *     @OA\Property(
 *        property="MetaDescription_ua",
 *        description="",
 *        type="string",
 *        maxLength=250,
 *    ),
 *     @OA\Property(
 *        property="MetaTitle_ua",
 *        description="",
 *        type="string",
 *        maxLength=170,
 *    ),
 *     @OA\Property(
 *        property="MetaKeyword_ua",
 *        description="",
 *        type="string",
 *        maxLength=500,
 *    ),
 * )
 */

/**
 * This is the model class for table "products".
 *
 * @property int $Id
 * @property string $Name
 * @property string $Description
 * @property string $Img
 * @property string $Img2
 * @property string $Tegs
 * @property string $MetaDescription
 * @property string $MetaTitle
 * @property string $MetaKeyword
 * @property int $IdBrand
 * @property int $Id_lang
 * @property int $Id_category
 * @property int $Markup наценка
 * @property string $Conventional_units условные единицы
 * @property string $Price
 * @property int $Id_discont
 * @property int $Availability
 * @property int $Id_current
 * @property int $MinQunt
 * @property string $Units
 * @property string $DateAdd
 * @property int $Status
 * @property string $Description_ua
 * @property string $MetaDescription_ua
 * @property string $MetaTitle_ua
 * @property string $MetaKeyword_ua
 *
 * @property Carts[] $carts
 * @property ProductImg[] $productImgs0
 * @property Lang $lang0
 * @property BrandProd $brand
 * @property Discont $discont0
 * @property Current $current0
 * @property Category $category0
 * @property RecommendProds[] $recommendProds1
 * @property RecommendProds[] $recommendProds2
 * @property Reviews[] $reviews0
 * @property Wishlist[] $wishlists
 */
class Products extends \app\models\Products
{

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['Id'];
    }
}

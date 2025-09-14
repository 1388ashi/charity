<?php

namespace Modules\Core\Helpers;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;
use Modules\Customer\Entities\Customer;
use Modules\CustomersClub\Entities\CustomersClubGetScore;
use Modules\CustomersClub\Entities\CustomersClubLevel;
use Modules\CustomersClub\Entities\CustomersClubScore;
use Modules\CustomersClub\Entities\CustomersClubSellScore;
use Modules\CustomersClub\Entities\CustomersClubSetting;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\CustomRelatedProduct;
use Modules\Product\Entities\Product;
use Illuminate\Validation\ValidationException;

//use Shetabit\Shopit\Modules\Core\Helpers\Helpers as BaseHelpers;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function PHPUnit\Framework\isEmpty;

include_once "jdf.php";
include_once "convertDate.php";

class Helpers /*extends BaseHelpers*/
{
    public static function to_english_numbers(String $string): String {
        $persinaDigits1 = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $persinaDigits2 = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
        $allPersianDigits = array_merge($persinaDigits1, $persinaDigits2);
        $replaces = [...range(0, 9), ...range(0, 9)];

        return str_replace($allPersianDigits, $replaces , $string);
    }

    public static function toDigit($number){
        return number_format($number, 0 , '.' , ',' );
    }
    public static function cacheRemember($key, $ttl, $callback)
    {
        return app()->environment('production') ? \Cache::remember($key, $ttl, $callback) : $callback();
    }

    public static function cacheForever($key, $callback)
    {
        return app()->environment('production') ? \Cache::rememberForever($key, $callback) : $callback();
    }

    public static function removeVarieties(array $products)
    {
        foreach ($products as $key => $product) {
            unset($products[$key]['active_flash']);
            unset($products[$key]['varieties']);
        }

        return $products;
    }

    public static function getActivePayments($order_id): array
    {
        $invoices = DB::table('invoices')
            ->where('payable_type','Modules\Order\Entities\Order')
            ->where('payable_id',$order_id)
            ->get();
        $active_payments=[];
        foreach ($invoices as $invoice) {
            $payments = DB::table('payments')
                ->where('invoice_id',$invoice->id)
                ->where('status','success')
                ->get();
            foreach ($payments as $payment) {
                $active_payments[] = $payment;
            }
        }
        return $active_payments;
    }

    public function getToday(){
        return date('Y-m-d');
    }

    public function getThisYearPersian(){
        return $this->convertMiladiToShamsi($this->getToday(),"Y");
    }

    public function firstDayOfWeek(){
        date_default_timezone_set('UTC');   // Set the timezone to the desired one
        $currentDate = date('Y-m-d');   // Get the current date
        $startDayOfWeek = 'Saturday';   // Set the start day of the week (Saturday)
        return date('Y-m-d', strtotime("last $startDayOfWeek", strtotime($currentDate)));   // Find the most recent occurrence of the start day of the week
    }

    public function convertMiladiToShamsi($date,$format="Y/m/d"){
        $verta = new Verta($date);
        return $verta->format($format);
    }

    public function convertShamsiToMiladi($date){
        return convertShamsiToMiladiWithoutTime($date);
    }

    public function getDaysOfMonth($year, $month){
        switch ($month){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                $days = 31;
                break;

            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                $days = 30;
                break;

            case 12:
                $days = $this->isKabise($year)?30:29;
                break;
        }

        return $days;
    }

    public function getDaysOfYear($year){
        return $this->isKabise($year)?366:365;
    }

    public function isKabise($year): bool
    {
        $list = [1, 5, 9, 13, 17, 22, 26, 30];
        $a = $year % 33;
        if (in_array($a,$list))
            return true;
        else
            return false;
    }


    public function updateOrdersUsefulData(){
//        $orders = Order::select('address')->whereNull('receiver')->whereNull('parent_id')->where('id',37)->get();

        DB::table('orders')
            ->whereNull('province')
            ->whereNull('parent_id')
//            ->where('id','<',1000)
            ->update([
//                'receiver' => DB::raw("CONCAT(CAST(json_unquote(JSON_EXTRACT(address, '$.first_name')) as CHAR), ' ', CAST(json_unquote(JSON_EXTRACT(address, '$.last_name')) as CHAR))"),
                'first_name' => DB::raw("CAST(json_unquote(JSON_EXTRACT(address, '$.first_name')) as CHAR)"),
                'last_name' => DB::raw("CAST(json_unquote(JSON_EXTRACT(address, '$.last_name')) as CHAR)"),
                'city' => DB::raw("trim(CAST(json_unquote(JSON_EXTRACT(address, '$.city.name')) as CHAR))"),
                'province' => DB::raw("trim(CAST(json_unquote(JSON_EXTRACT(address, '$.city.province.name')) as CHAR))"),
            ]);
    }

    public function updateOrdersCalculateData($order_id=null){
        if ($order_id){
            $orders = DB::table('orders')
                ->where('id',$order_id)
                ->get();
        } else {
            $orders = DB::table('orders')
                ->whereNull('items_count')
                ->whereNull('parent_id')
//                ->whereDate('created_at','2023-07-24')
//                ->whereIn('id',[88288])
                ->when(env('APP_ENV') === 'local', function ($query) {
                    $query->take(5);
                })
//                ->take(5)
                ->get();
//                ->toSql();
//            dd($orders);
        }

//        Log::info('orders to reCalculate:');
//        foreach ($orders as $order) {
//            Log::info('order_id = ' . $order->id);
//        }

        foreach ($orders as $order) {
            $this->calculateOrderFields($order);
        }
    }

    public function calculateOrderFields($order, $return_total_amount = false)
    {
        // محاسبه ارقام مربوط به آیتم های سفارش
        $count = DB::table('order_items')->where('order_id',$order->id)->count();
        $quantity = DB::table('order_items')->select(DB::raw('sum(quantity) as q'))->where('order_id',$order->id)->where('status',1)->first()->q;
        $amount = DB::table('order_items')->select(DB::raw('sum(quantity*amount) as s'))->where('order_id',$order->id)->where('status',1)->first()->s;
        $discount = DB::table('order_items')->select(DB::raw('sum(quantity*discount_amount) as d'))->where('order_id',$order->id)->where('status',1)->first()->d;
        $shipping = DB::table('orders')->select('shipping_amount')->where('id',$order->id)->first()->shipping_amount;

        // Log::info($order->id . ': original quantity = ' . $quantity);

        $used_wallet_amount = DB::table('invoices')
            ->select('wallet_amount')
            ->where('payable_id',$order->id)
            ->where('payable_type',"Modules\Order\Entities\Order")
            ->where('status','success')
            ->first()->wallet_amount??0;

        // در صورتی که روی آیتم ها تخفیف داده شده باشد، تخفیف مورد نظر روی amount نیز اعمال شده است
        // پس هنگام محاسبه amount مقدار تخفیف را با آن جمع بسته تا مقدار واقعی آن محاسبه گردد
        $amount += $discount;

        // Log::info($order->id . ': final discount amount = ' . $discount);
        // Log::info($order->id . ': calculated amount = ' . $amount);

        if ($order->coupon_id){
            $coupon = DB::table('coupons')->find($order->coupon_id);
            $undiscounted_amount = DB::table('order_items')
                ->select(DB::raw('sum(quantity*amount) as s'))
                ->where('order_id',$order->id)
                ->where('status',1)
                ->where('discount_amount',0)
                ->first()->s;
            if ($coupon->type == 'flat'){
                $discount += $coupon->amount;
            } else {
                $discount += $coupon->amount * $undiscounted_amount / 100;
            }
        }

        // Log::info($order->id . ': final discount amount = ' . $discount . " ($undiscounted_amount)");

        // افزودن مقادیرمربوط به سفارشات زیر مجموعه سفارش اصلی
        $sub_orders = DB::table('orders')->where('parent_id',$order->id)->whereIn('status',['new','delivered','in_progress'])->get();

//            Log::info('sub_orders for reCalculate:');
//            foreach ($sub_orders as $sub_order) {
//                Log::info('sub_order_id = ' . $sub_order->id);
//            }

        foreach ($sub_orders as $sub_order) {
            $count += DB::table('order_items')->where('order_id',$sub_order->id)->count();
            $quantity += DB::table('order_items')->select(DB::raw('sum(quantity) as q'))->where('order_id',$sub_order->id)->where('status',1)->first()->q;
            $amount += DB::table('order_items')->select(DB::raw('sum(quantity*amount) as s'))->where('order_id',$sub_order->id)->where('status',1)->first()->s;
            $child_discount = DB::table('order_items')->select(DB::raw('sum(quantity*discount_amount) as d'))->where('order_id',$sub_order->id)->where('status',1)->first()->d;

//                Log::info('new quantity = ' . $quantity);

            $child_amount = DB::table('order_items')->select(DB::raw('sum(quantity*amount) as s'))->where('order_id',$sub_order->id)->where('status',1)->first()->s;

            // در صورتی که روی آیتم های زیر مجموعه تخفیف داده شده باشد، تخفیف مورد نظر روی amount نیز اعمال شده است
            // پس هنگام محاسبه amount مقدار تخفیف را با آن جمع بسته تا مقدار واقعی آن محاسبه گردد
            $amount += $child_discount;

            if ($sub_order->coupon_id){
                $coupon = DB::table('coupons')->find($sub_order->coupon_id);
                if ($coupon->type == 'flat'){
                    $child_discount += $coupon->amount;
                } else {
                    $child_discount += $coupon->amount * $child_amount / 100;
                }
            }

            // Log::info($order->id . ': final discount amount on child = ' . $child_discount . " ($child_amount)");

            $discount += $child_discount;
        }

        DB::table('orders')
            ->where('id',$order->id)
            ->update([
                'items_count' => $count,
                'items_quantity' => $quantity,
                'total_amount' => $amount,
//                'discount_amount' => $discount,
                'used_wallet_amount' => $used_wallet_amount,
                'total_payable_amount' => $amount + $shipping - $discount - $used_wallet_amount,
            ]);

        if ($return_total_amount){
            return $amount;
        }
    }

    public function updateChargeTypeOfTransactions(){

        $order_gift_id = DB::table('charge_types')->where('value','order_gift')->value('id');
        $instagram_gift_id = DB::table('charge_types')->where('value','instagram_gift')->value('id');
        $customers_club_gift_id = DB::table('charge_types')->where('value','customers_club_gift')->value('id');
        $cancel_order_id = DB::table('charge_types')->where('value','cancel_order')->value('id');
        $online_charge_id = DB::table('charge_types')->where('value','online_charge')->value('id');
        $other_id = DB::table('charge_types')->where('value','other')->value('id');

        // به روز رسانی شناسه نوع واریز تراکنش های هدیه سفارش
        DB::table('transactions')
            ->whereNotNull('meta')
            ->whereRaw("CAST(json_unquote(JSON_EXTRACT(meta, '$.description')) as CHAR) like '%هدیه خرید سفارش%'")
            ->whereNull('charge_type_id')
            ->update([
                'charge_type_id' => $order_gift_id
            ]);

        // به روز رسانی شناسه نوع واریز تراکنش های مسابقات اینستاگرامی
        DB::table('transactions')
            ->whereNotNull('meta')
            ->whereRaw("CAST(json_unquote(JSON_EXTRACT(meta, '$.description')) as CHAR) like '%اینستاگرام%'")
            ->whereNull('charge_type_id')
            ->update([
                'charge_type_id' => $instagram_gift_id
            ]);

        // به روز رسانی شناسه نوع واریز تراکنش های لغو شده
        DB::table('transactions')
            ->whereNotNull('meta')
            ->whereRaw("CAST(json_unquote(JSON_EXTRACT(meta, '$.description')) as CHAR) like '%با وضعیت لغو شده%'")
            ->whereNull('charge_type_id')
            ->update([
                'charge_type_id' => $cancel_order_id
            ]);

        // به روز رسانی شناسه نوع واریز تراکنش برگشت مبلغ
        DB::table('transactions')
            ->whereNotNull('meta')
            ->whereRaw("CAST(json_unquote(JSON_EXTRACT(meta, '$.description')) as CHAR) like '%برگشت مبلغ سفارش در اثر تغییر وضعیت به%'")
            ->whereNull('charge_type_id')
            ->update([
                'charge_type_id' => $cancel_order_id
            ]);

        // به روز رسانی شناسه نوع واریز تراکنش شارژ آنلاین
        DB::table('transactions')
            ->whereNull('meta')
            ->whereNull('charge_type_id')
            ->update([
                'charge_type_id' => $online_charge_id
            ]);

        // به روز رسانی شناسه نوع واریز تراکنش های متفرقه
        DB::table('transactions')
            ->where('type','deposit')
            ->whereNull('charge_type_id')
            ->update([
                'charge_type_id' => $other_id
            ]);
    }

    public static function getCustomersClubScoreByKey($key)
    {
        return CustomersClubGetScore::where("key",$key)->first();
    }

    public static function getCustomersClubSettingByKey($key)
    {
        $setting = CustomersClubSetting::where("key",$key)->first();
        $default_values = [
            'min_first_order' => 100000,
            'min_story_hours' => 24,
        ];
        if (!$setting){
            $setting = CustomersClubSetting::create([
                'key' => $key,
                'value' => $default_values[$key],
                'type' => 'number',
                'status' => 1,
            ]);
        }
        return $setting;
    }

    public static function getImages($model, $id, $getAllSizes = false)
    {
        $model_type = match ($model) {
            'Advertise' => 'Modules\Advertise\Entities\Advertise',
            'Post' => 'Modules\Blog\Entities\Post',
            'Category' => 'Modules\Category\Entities\Category',
            'Customer' => 'Modules\Customer\Entities\Customer',
            'Flash' => 'Modules\Flash\Entities\Flash',
            'GiftPackage' => 'Modules\GiftPackage\Entities\GiftPackage',
            'Instagram' => 'Modules\Instagram\Entities\Instagram',
            'Product' => 'Modules\Product\Entities\Product',
            'Variety' => 'Modules\Product\Entities\Variety',
            'Shipping' => 'Modules\Shipping\Entities\Shipping',
            'Slider' => 'Modules\Slider\Entities\Slider',
            'CustomersClubBeforeAfter' => 'Modules\CustomersClub\Entities\CustomersClubBeforeAfter',
            default => '',
        };

        $images = DB::table('media')
            ->where('model_type',$model_type)
            ->where('model_id',$id)
//            ->select(DB::raw("concat(uuid, '/', file_name) as url"))
//            ->select(DB::raw("concat(uuid,'/',file_name) as url"))
            ->select(
                'uuid',
                'file_name'
            )
            ->get();

        if (count($images)>0){
            // در صورتی که مدل درخواست شده محصول بود و دارای تصویر هم بود تصاویر خود محصول برگشت داده میشود.
            $list_images = [];
            if ($getAllSizes){
                foreach ($images as $image) {
                    $image_file_name_array = explode('.',$image->file_name);
                    $file_name = $image_file_name_array[0];
                    $file_extension = $image_file_name_array[1];
                    $list_images[] = [
                        'lg' => "$image->uuid/conversions/$file_name-thumb_lg.$file_extension",
                        'md' => "$image->uuid/conversions/$file_name-thumb_md.$file_extension",
                        'sm' => "$image->uuid/conversions/$file_name-thumb_sm.$file_extension"
                    ];
                }
            } else {
                foreach ($images as $image) {
                    $list_images[] = "$image->uuid/$image->file_name";
                }
            }
            return $list_images;
        } elseif ($model == 'Product' && count($images)==0){
            // در صورتی که مدل درخواست شده Product بود ولی تصویری برای آن یافت نشد تصاویر تنوع آن دریافت شده و برگشت داده می شود
            // اولویت تصویر با موردی است که به عنوان تنوع پیش فرض درنظر گرفته شده است
            $varieties = DB::table('varieties')->select('id')->where('product_id',$id)->orderBy('is_head','desc')->get();

            $variety_images = [];
            foreach ($varieties as $v) {
                if (self::getImages('Variety',$v->id)){
                    $variety_images[] = self::getImages('Variety',$v->id)[0];
                }
            }
            return $variety_images;
        }
    }

    public static function getMajorFinalPrice($id)
    {
        $varieties = DB::table('varieties as v')
            ->join('stores as s','s.variety_id','=','v.id')
            ->where('v.product_id',$id)
            ->select(
                "v.discount_type",
                "v.discount",
                "v.price",
//                "product_id",
                "v.discount_until",
                "s.balance as quantity",
            )
            ->get();

        if (!$varieties){
            $product = DB::table('products')->where('id',$id)->first();

            $has_discount = ($product->discount_until && ($product->discount_until > now()));
            $discount_price = $has_discount ? $product->discount_type=='percentage' ? $product->unit_price*$product->discount/100 : $product->discount : 0;
            $discount_value = $has_discount ? $product->discount : 0;

            return (object)[
//                "discount_model"=> "none",
                "discount_type"=> $product->discount_type,
                "discount"=> $discount_value,
                "discount_price"=> $discount_price,
                "amount"=> $product->unit_price - $discount_price
            ];
        }

        $final_amount = PHP_INT_MAX;
        $final_discount = 0;
        $final_discount_price = 0;
        $final_discount_type = null;

        foreach ($varieties as $variety) {

            $has_discount = ($variety->quantity != 0 && $variety->discount_until && ($variety->discount_until > now()));

            $discount_price = $has_discount ? $variety->discount_type=='percentage' ? $variety->price*$variety->discount/100 : $variety->discount : 0;
            $discount_value = $has_discount ? $variety->discount : 0;

            if ($has_discount) {
                $discount_type = $variety->discount_type;
            } else {
                $discount_type = null;
            }

            $amount = $variety->price - $discount_price;

//            dump(($has_discount?"yes ":"no  ") . $discount_price . " | " . $discount_value . " | " . $amount . " | " . $discount_type);

            if ($amount < $final_amount){
                $final_amount = $amount;
                $final_discount = $discount_value;
                $final_discount_price = $discount_price;
                $final_discount_type = $discount_type;
            }

//            dump(($has_discount?"yes ":"no  ") . $final_discount_price . " | " . $final_discount . " | " . $final_amount . " | " . $final_discount_type);
        }

//        dd('done');

        return (object)[
//                "discount_model"=> "none",
            "discount_type"=> $final_discount_type,
            "discount"=> $final_discount,
            "discount_price"=> $final_discount_price,
            "amount"=> $final_amount
        ];
    }

    public static function getProductRate($id)
    {
        return round(DB::table('product_comments')->where('status','approved')->where('product_id',$id)->avg('rate'),1);
    }

    public static function getRelatedProducts($product,$getCustomRelatedProducts= false,$showOnlyCustomRelatedProducts=true){
        $num=0;
        if ($getCustomRelatedProducts){
            $CustomRelatedProducts = CustomRelatedProduct::query()->where('product_id',$product->id)->pluck('related_id');
            $num=count($CustomRelatedProducts);
        }else{
            $CustomRelatedProducts = [];
        }

        $product_categories = DB::table('category_product')
            ->select('category_id')
            ->where('product_id',$product->id)
            ->get()
            ->pluck('category_id');

        if ($showOnlyCustomRelatedProducts){
            // در صورتی که فقط محصولات از پیش مشخص شده درخواست شوند، لیست محصولات مرتبط محاسبه شده خالی ارسال می شود
            $relatedProductIds = DB::table('category_product')->whereIn('product_id', [])->get();
        } else {
            $relatedProductIds = DB::table('category_product')
                ->join('products', 'category_product.product_id', '=', 'products.id')
                ->whereNotIn('product_id', [$product->id])
                ->whereIn('category_id', $product_categories)
                ->whereIn('products.status', ['available', 'out_of_stock'])
                ->inRandomOrder()
                ->select('product_id')
                ->limit(6 - $num)
                ->get()
                ->pluck('product_id');
        }

        if ($getCustomRelatedProducts){
            $merge = array_merge($CustomRelatedProducts->toArray(),$relatedProductIds->toArray());
        }else{
            $merge = $relatedProductIds->toArray();
        }

        $relatedProducts = DB::table('products')
            ->join('custom_related_products as crp','crp.related_id','=','products.id')
            ->whereIn('products.id',$merge)
            ->where('crp.product_id',$product->id)
            ->select(
                'products.id',
                'title',
                'slug',
                'status',
            )
            ->orderBy('crp.id')
            ->get();

        foreach ($relatedProducts as $relatedProduct) {
            $relatedProduct->images = self::getImages("Product", $relatedProduct->id);
            $relatedProduct->image_conversions = self::getImages("Product", $relatedProduct->id,true);
            $relatedProduct->rate = Helpers::getProductRate($relatedProduct->id);
            $relatedProduct->major_final_price = Helpers::getMajorFinalPrice($relatedProduct->id);
            $relatedProduct->major_discount_amount = $relatedProduct->major_final_price->discount;
            $relatedProduct->major_discount_type = $relatedProduct->major_final_price->discount_type;
        }

        return $relatedProducts;
    }

    public function generateCauseTitleByCauseId($id)
    {
        return CustomersClubGetScore::where('id',$id)->value('title');
    }
    public function generateCauseTitleBySellScoreId($id,$order_id ='')
    {
        return "خرید " . CustomersClubSellScore::where('id',$id)->value('title') . " سفارش " . $order_id;
    }
    public static function checkUserBoughtProduct($customer_id,$product_id)
    {
        $orders = DB::table('orders')
            ->where('customer_id',$customer_id)
            ->whereIn('status', Order::ACTIVE_STATUSES)
            ->pluck('id')
            ->toArray();

        $product_ids = DB::table('order_items')
            ->whereIn('order_id',$orders)
            ->pluck('product_id')
            ->toArray();

        return in_array($product_id,$product_ids);
    }

    public function setScoreForBeforeAfterImages($customer_id, $product_id)
    {
        $get_score = Helpers::getCustomersClubScoreByKey('products_before_after');  // دریافت امتیازی که بابت ثبت تصاویر قبل و بعد مصول به کاربر تعلق می گیرد
        $customer_club_score = CustomersClubScore::query()
            ->where('customer_id',$customer_id)
            ->where('product_id', $product_id)
            ->where('cause_id', $get_score->id)
            ->first();

        // در صوتی که امتیاز این مرحله وجود داشته باشد دوباره امتیاز داده نمی شود
        if (!$customer_club_score){
            $product = Product::find($product_id)->title;
            $customer_club_score = new CustomersClubScore();
            $customer_club_score->customer_id = $customer_id;
            $customer_club_score->product_id = $product_id;
            $customer_club_score->cause_id = $get_score->id;
            $customer_club_score->cause_title = 'ثبت ' . (new \Modules\Core\Helpers\Helpers)->generateCauseTitleByCauseId($get_score->id) . " ($product_id - $product)";
            $customer_club_score->score_value = $get_score->score_value;
            $customer_club_score->bon_value = $get_score->bon_value;
            $customer_club_score->date = date('Y-m-d');
            $customer_club_score->status = 1;

            $customer_club_score->save();
        }
    }

    public function setScoreForStoryMention($customer_id,$get_score)
    {
        $customer_club_score = new CustomersClubScore();
        $customer_club_score->customer_id = $customer_id;
        $customer_club_score->cause_id = $get_score->id;
        $customer_club_score->cause_title = (new \Modules\Core\Helpers\Helpers)->generateCauseTitleByCauseId($get_score->id) . " (" . convertMiladiToShamsiWithoutTime(date('Y-m-d')) . ")";
        $customer_club_score->score_value = $get_score->score_value;
        $customer_club_score->bon_value = $get_score->bon_value;
        $customer_club_score->date = date('Y-m-d');
        $customer_club_score->status = 1;

        $customer_club_score->save();
    }

    public function setScoreForDailyLogin($customer_id,$get_score)
    {
        $customer_club_score = new CustomersClubScore();
        $customer_club_score->customer_id = $customer_id;
        $customer_club_score->cause_id = $get_score->id;
        $customer_club_score->cause_title = (new \Modules\Core\Helpers\Helpers)->generateCauseTitleByCauseId($get_score->id) . " (" . convertMiladiToShamsiWithoutTime(date('Y-m-d')) . ")";
        $customer_club_score->score_value = $get_score->score_value;
        $customer_club_score->bon_value = $get_score->bon_value;
        $customer_club_score->date = date('Y-m-d');
        $customer_club_score->status = 1;

        $customer_club_score->save();
    }

    public function setScoreForEnamadSurvey($customer_id,$get_score)
    {
        $customer_club_score = new CustomersClubScore();
        $customer_club_score->customer_id = $customer_id;
        $customer_club_score->cause_id = $get_score->id;
        $customer_club_score->cause_title = (new \Modules\Core\Helpers\Helpers)->generateCauseTitleByCauseId($get_score->id);
        $customer_club_score->score_value = $get_score->score_value;
        $customer_club_score->bon_value = $get_score->bon_value;
        $customer_club_score->date = date('Y-m-d');
        $customer_club_score->status = 1;

        $customer_club_score->save();
    }

    public function setScoreForRegisterCustomer($customer_id, $new_customer_id)
    {
        $get_score = Helpers::getCustomersClubScoreByKey('use_invite_link');  // دریافت امتیازی که بابت ثبت نام یک کاربر جدید از طریق لینک به وی تعلق می گیرد

        $customer_club_score = new CustomersClubScore();
        $customer_club_score->customer_id = $customer_id;
//        $customer_club_score->product_id = $product_id;
        $customer_club_score->cause_id = $get_score->id;
        $customer_club_score->cause_title = (new \Modules\Core\Helpers\Helpers)->generateCauseTitleByCauseId($get_score->id) . " (کاربر $new_customer_id)";
        $customer_club_score->score_value = $get_score->score_value;
        $customer_club_score->bon_value = $get_score->bon_value;
        $customer_club_score->date = date('Y-m-d');
        $customer_club_score->status = 1;

        $customer_club_score->save();
    }

    public function getShippingAmountByOrderAmount($userId=0): bool
    {
        $cartTotal = DB::table('carts')->where('customer_id',$userId)->select(DB::raw('sum(quantity*price) as total'))->value('total');
        $userLevel = Customer::find($userId)->customers_club_level['id'];
        $shippingPriceOfLevel = CustomersClubLevel::find($userLevel)->free_shipping;
        return $cartTotal>=$shippingPriceOfLevel; // در صورتی که مبلغ سفارش از مبلغ تعیین شده برای سطح بیشتر باشد مقدار true برگردانده می شود به این معنی که ارسال رایگان خواهد بود
    }


    public static function sortOrders(Model $model, int $order): void
    {
        $id = $model->id;
        $oldOrder = $model->order;
        $orders = [];
        $orderedServices = $model->query()->ordered()->where('id', '!=', $id)->get(['id', 'order']);

        if ($order < $oldOrder) {
            $beforeOrders = $orderedServices->where('order', '<', $order)->pluck('id')->all();
            $orders = $beforeOrders;
            $orders[] = $id;
            $afterOrders = $orderedServices->where('order', '>=', $order)->pluck('id')->all();
            $orders = array_merge($orders, $afterOrders);

        } elseif ($order > $oldOrder) {
            $beforeOrders = $orderedServices->where('order', '<=', $order)->pluck('id')->all();
            $orders = $beforeOrders;
            $orders[] = $id;
            $afterOrders = $orderedServices->where('order', '>', $order)->pluck('id')->all();
            $orders = array_merge($orders, $afterOrders);
        }

        if (count($orders) > 0) {
            $model->setNewOrder($orders);
        }
    }

    public static function getMajorVarietyPriceOfProduct($product_id)
    {
        return DB::table('varieties')->where('product_id',$product_id)->max('price');
    }

    public static function getMinorVarietyPriceOfProduct($product_id)
    {
        return DB::table('varieties')->where('product_id',$product_id)->min('price');
    }

    public static function getMinorVarietyPriceOfProductsID($product_id)
    {
        return DB::table('varieties')->where('product_id',$product_id)->orderBy('price', 'asc')->value('id');
    }

    public function convertMobileNumberForReport($mobile)
    {
        return substr($mobile,0,4)."---".substr($mobile,7,4);
    }

    public static function toGregorian(string $jDate): ?string
    {

        $output = null;
        $pattern = '#^(\\d{4})/(0?[1-9]|1[012])/(0?[1-9]|[12][0-9]|3[01])$#';

        if (preg_match($pattern, $jDate)) {
            $jDateArray = explode('/', $jDate);
            $dateArray = \Hekmatinasser\Verta\Facades\Verta::getGregorian(
                $jDateArray[0],
                $jDateArray[1],
                $jDateArray[2]
            );
            $output = implode('/', $dateArray);
        }
        return $output;

    }




    // came from vendor ================================================================================================
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|Model
     */
    public static function getAuthenticatedUser()
    {
        foreach(array_keys(config('auth.guards')) as $guard){
            if(auth()->guard($guard)->check()) {
                return auth()->guard($guard)->user();
            }
        }

        return null;
    }

    public static function resizeImageWithAspectRatio(Image $image, $width, $height)
    {
        $image->height() > $image->width() ? $width = null : $height = null;
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $image;
    }

    public static function resizeImage(Image $image, $width, $height)
    {
        $image->resize($width, $height);

        return $image;
    }

    public static function paginateOrAll($query, $perPage = null)
    {
        $perPage = $perPage ?? \request('per_page', 10);

        return request('all', false) ? $query->get() : $query->paginate($perPage);
    }

    public static function paginateFromRequest($query, $perPage = 10)
    {
        return $query->paginate(request('per_page', $perPage));
    }

    public static function applyFilters($query)
    {
        static::searchFilters($query);
        static::dateFilter($query);
        static::sortBy($query);
    }
    public static function searchFilters($query, $paramsCount = 8, $prefix = '')
    {
        $prefix = empty($prefix) ? '' : $prefix . '.';
        for ($i = 1; $i <= $paramsCount; $i++) {
            $search = \request('search' . $i, false);
            $searchBy = \request('searchBy' . $i, false);
            if ($searchBy == 'category_id' && !empty($search)) {
                $query->whereHas('categoryPivot', function ($query2) use ($search) {
                    $query2->where('category_id', '=', $search);
                });

                return;
            }
            if(mb_strlen($search) > 0 && strlen($searchBy) > 0) {
                if(str_contains($searchBy, '_id')) {
                    $query->where($prefix . $searchBy, '=', $search);
                } else {
                    $query->where($prefix . $searchBy, 'LIKE', '%' . $search . '%');
                }
            }
        }
    }

    public static function dateFilter($builder)
    {
        $request = request();
        if($request->filled('start_date')) {
            $builder->where('created_at', '>', Carbon::createFromTimestamp($request->start_date));
        }
        if($request->filled('end_date')) {
            $builder->where('created_at', '<', Carbon::createFromTimestamp($request->end_date));
        }
    }

    public static function sortBy($builder)
    {
        if (request('sort', false)) {
            $order = 'asc';
            if(request('order', false) == 'desc')
            {
                $order = 'desc';
            }
            if (class_basename($builder) == 'Builder') {
                $builder->getQuery()->orders = null;
            } else {
                // is relationship
                $builder->getBaseQuery()->orders = null;
            }

            return $builder->orderBy(request('sort'), $order);
        }
    }

    public static function getIds($collection)
    {
        $ids = [];
        foreach ($collection as $item) {
            $ids[] = $item->id;
        }

        return $ids;
    }

    public static function getWhereInString(array $ids)
    {
        $queryString = ' ';
        foreach ($ids as $id) {
            $queryString .= $id . ',';
        }
        $queryString[strlen($queryString) - 1] = ' ';

        return $queryString;
    }

    public static function removeFromRequest(Request $request, ...$keys)
    {
        foreach ($keys as $key) {
            $jsonRequest = $request->json();
            $jsonRequest->remove($key);
            $request->request->remove($key);
        }
    }

    public static function makeValidationException($message, $key = 'unknown',$errorBag = 'default'): HttpResponseException|ValidationException
    {
        if (\request()->wantsJson()) {
            return new HttpResponseException(response()->error($message,
                [
                    $key => [$message]
                ]
                , 422));
        }
        return ValidationException::withMessages([
            $key => [$message]
        ])->errorBag($errorBag);
    }

    public static function getRealUrl()
    {
        return str_replace('api.', '', config('app.url'));
    }

    public static function getModelIdOnPut($model)
    {
        $model = request()->route($model);

        return is_object($model) ? $model->getKey() : $model;
    }

    // Return an object with only id and url
    public static function mediaToImage(?Media $media)
    {
        if (!$media) {
            return null;
        }
        $image = [];
        $image['id'] = $media->id;
        if (in_array($media->getExtensionAttribute(), ['docx', 'doc', 'ppt', 'txt', 'pptx', 'ppt'])) {
            $image['type'] = 'document';
        } else if (in_array($media->getExtensionAttribute(), ['zip', 'rar'])) {
            $image['type'] = 'archive';
        } else {
            $image['type'] = $media->type;
        }
        $image['url'] = $media->getUrl();

        return $image;
    }

    public static function mediasToImages(MediaCollection $mediaCollection)
    {
        $images = [];
        foreach ($mediaCollection as $media) {
            $images[] = \Shetabit\Shopit\Modules\Core\Helpers\Helpers::mediaToImage($media);
        }

        return $images;
    }

    /**
     * @param array $fields
     * @param $request
     * @return mixed
     */
    public static function toCarbonRequest(array $fields , $request): mixed
    {
        foreach ($fields as $field){
            if(is_numeric($request->input($field))){
                $request->merge([$field => Carbon::createFromTimestamp($request->input($field))->toDateTimeString()]);
            }else{
                $request->merge([$field => $request->input($field)]);
            }
        }
        return $request;
    }

    public static function hideAttributes(\Traversable $models, ...$attributes)
    {
        foreach ($models as $model) {
            $model->makeHidden($attributes);
        }
    }

    public static function randomString()
    {
        return bcrypt(md5(md5(time().time())));
    }

    public static function unsetFillable($model, ...$keys)
    {
        $fillable = $model->fillable;
        foreach ($keys as $key) {
            unset($fillable[$key]);
        }
        $model->fillable($fillable);
    }

    public static function searchOnRelations($model , $field , string $q , $searchIn)
    {
        $query = $model->whereHas($searchIn, function ($query) use ($q , $field) {

            $query->where($field , 'like', "%$q%");

        });

        return $query;
    }

    /**
     * Get random numbers code.
     *
     * @param int $digits
     * @return int
     */
    public static function randomNumbersCode(int $digits = 4)
    {
        return rand(pow(10, $digits-1), pow(10, $digits) - 1);
    }

    public static function isStringBase64(string $value, string $mime = 'gif|png|jpg|jpeg|svg|webp'): bool
    {
        $base64RegEx = '#^data:image\/(?:'.$mime.')(?:;charset=utf-8)?;base64,.*+={0,2}#';
        if (!preg_match($base64RegEx, $value)){
            return false;
        }

        return true;
    }

    public static function decodeUnicode($str)
    {
        return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $str);
    }

    #[NoReturn] public static function checkResponseInTest($response)
    {
        dd(json_decode(Helpers::decodeUnicode($response->getContent())));
    }

    public static function hasCustomSearchBy($key)
    {
        for ($i = 1; $i < 99; $i++) {
            if (\request('searchBy' . $i) === $key && \request('search' . $i)) {
                $temp = \request('search' . $i);
                request()->merge(['search' . $i => null]);

                return $temp;
            }
        }

        return null;
    }



    public static function clearCacheInBooted($model, $key)
    {
        $key = is_array($key) ? $key : [$key];
        $model::updated(function () use ($key){
            \Cache::deleteMultiple($key);
        });
        $model::deleted(function () use ($key){
            \Cache::deleteMultiple($key);
        });
        $model::created(function () use ($key){
            \Cache::deleteMultiple($key);
        });
    }

    public static function convertFaNumbersToEn($string) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    public static function setEventNameForLog($eventName): string
    {
        if ($eventName == 'updated'){
            return 'بروزرسانی';
        }
        if ($eventName == 'deleted'){
            return  'حذف';
        }
        if ($eventName == 'created'){
            return 'ایجاد';
        }
        return $eventName;
    }

    public static function getDeviceTokens($model , array $ids): array
    {
        $model = ucfirst($model);
        $tokens = DB::table('personal_access_tokens')
            ->where('tokenable_type', "Modules\{$model}\Entities\{$model}")
            ->whereNotNull('device_token')
            ->whereIn('tokenable_id', $ids)
            ->get('device_token')
            ->pluck('device_token')->toArray();

        return array_values(array_unique($tokens));
    }


    public static function actingAs($user, $guard = 'customer-api')
    {
        app('auth')->guard($guard)->setUser($user);
        app('auth')->shouldUse($guard);

        return $user;
    }

    /** Remove where from query */
    public static function removeWhere(Builder|\Illuminate\Database\Query\Builder $query, string $column,
                                                                                  $operator = false)
    {
        $wheres = [];
        foreach ($query->wheres as $where) {
            if (isset($where['column']) &&
                ($where['column'] === $column || str_contains($where['column'], ".$column"))) {
                foreach ($query->bindings['where'] as $key => $binding) {
                    if (isset($where['value']) && $binding === $where['value']) {
                        unset($query->bindings['where'][$key]);
                        break;
                    }
                }
                continue;
            }
            $wheres[] = $where;
        }
        $query->wheres = $wheres;
    }

    public static function getArrayIndexes($data, $keys): array
    {
        if (isset($keys[0]) && is_string($keys[0])) {
            return [$keys[0]];
        }

        $newData = [];
        $c = 0;
        foreach ($data as $key => $value) {
            if (in_array($c, $keys)) {
                $newData[$key] = $value;
            }
            $c++;
        }

        return $newData;
    }
}


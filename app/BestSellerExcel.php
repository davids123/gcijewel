<?php
namespace App;
use App\Memo;
use App\Product;
use App\JobOrder;
use App\MemoDetail;
use App\RetailReseller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
class BestSellerExcel implements FromCollection, WithMapping, WithHeadings
{
    protected $ids;
     function __construct($ids) {
     $this->ids = $ids;
    }
     
    public function collection()
    {  
        $best_seller=Memo::select('memos.id','memo_details.item_status','products.model',DB::raw('SUM(memos.sub_total) as memoSubTotal'),DB::raw('SUM(memo_details.product_qty) as totalQty'),'product_types.listing_type')
        ->join('memo_details', 'memo_details.memo_id', '=', 'memos.id')
        ->join('products', 'products.id', '=', 'memo_details.product_id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->where('memo_details.item_status','=','2')
        ->orderBy('totalQty','DESC')
        ->groupBy('products.model')
        ->whereIn('products.model',$this->ids)
        ->get();
        // dd($best_seller);
        return $best_seller;
                                    
    }
    public function headings(): array
    {
        return [
            'Model Number',
            'Qty Sold',
            'Sales Value',
        ];

    }



    /**

    * @var Customer $customer

    */

    public function map($best_seller): array

    {
        setlocale(LC_MONETARY,"en_US");
        $total_cost=money_format("%(#1n",$best_seller->memoSubTotal)."\n" ;
        // $averagecost=money_format("%(#1n",$best_seller->totalcost)."\n" ;
        return [
                $best_seller->model,
                $best_seller->totalQty,
                $total_cost,
            
            ];
    }

}

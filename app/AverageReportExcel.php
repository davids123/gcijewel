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
class AverageReportExcel implements FromCollection, WithMapping, WithHeadings
{
    protected $ids;
     function __construct($ids) {
     $this->ids = $ids;
    }
     
    public function collection()
    {  
        $average_cost=Product::with('reviews', 'stocks')
        ->leftJoin('memo_details', 'memo_details.product_id', '=', 'products.id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->leftJoin('memos', 'memo_details.memo_id', '=', 'memos.id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        ->select('products.*',DB::raw('SUM(product_stocks.qty) as totalQty'),DB::raw('SUM(products.product_cost) as totalcost'),DB::raw('SUM(memos.sub_total) as memo_sub_total'),DB::raw('SUM(memo_details.product_qty) as memo_qty_totl'))
        ->orderBy('products.id', 'DESC')
        ->groupBy('products.model')
        ->whereIn('products.id',$this->ids)
        ->get();
        // dd($average_cost);
        return $average_cost;
                                    
    }
    public function headings(): array
    {
        return [
            'Model Number',
            'Qty Purchased',
            'Total Purchases Cost',
            'Average Cost ',
        ];

    }



    /**

    * @var Customer $customer

    */

    public function map($average_cost): array

    {
        setlocale(LC_MONETARY,"en_US");
        $total_cost=money_format("%(#1n",$average_cost->totalcost)."\n" ;
        $averagecost=money_format("%(#1n",$average_cost->totalcost)."\n" ;
        return [
                $average_cost->model,
                $average_cost->totalQty+$average_cost->memo_qty_totl,
                $total_cost,
                $averagecost,
            
            ];
    }

}

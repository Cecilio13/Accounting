<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\User;
use App\Company;
use App\Sales;
use App\Expenses;
use App\Advance;
use App\Customers;
use App\ProductsAndServices;
USE App\SalesTransaction;
use App\Supplier;
use App\JournalEntry;
use App\Formstyle;
use App\Report;
use App\AuditLog;
use App\Voucher;
use App\ChartofAccount;
use App\Numbering;
use App\CostCenter;
use App\DepositRecord;
use App\Bank;
use App\UserAccess;
use App\CC_Type;
use App\ExpenseTransaction;
use App\ExpenseTransactionNew;
use App\EtAccountDetail;
class GetController extends Controller
{
    public function print_invoice_info(Request $request){
        $no=$request->no;
        $location=$request->location;
        $type=$request->type;
        $SS=DB::connection('mysql')->select("SELECT * FROM sales_transaction LEFT JOIN customers ON customers.customer_id=sales_transaction.st_customer_id WHERE st_no='$no' AND st_location='$location' AND st_invoice_type='$type' AND st_type='Invoice'");
        $st_invoice =DB::connection('mysql')->select("SELECT * FROM st_invoice LEFT JOIN cost_center ON cost_center.cc_no=st_invoice.st_p_cost_center LEFT JOIN products_and_services ON products_and_services.product_id=st_invoice.st_i_product WHERE st_i_no='$no' AND st_p_location='$location' AND st_p_invoice_type='$type'");
        $invoice_date="";
        $invoice_due_date="";
        $customer="";
        $address="";
        $terms="";
        $job_order="";
        $work_no="";
        $email="";
        $note="";
        $memo="";
        $COA= ChartofAccount::all();
        foreach($SS as $data){
            $invoice_date=$data->st_date;
            $invoice_due_date=$data->st_due_date;
            $customer=$data->display_name!=""? $data->display_name : $data->f_name." ".$data->l_name;
            $address=$data->st_bill_address;
            $terms=$data->st_term;
            $job_order=$data->st_invoice_job_order;
            $work_no=$data->st_invoice_work_no;
            $email=$data->st_email;
            $note=$data->st_note;
            $memo=$data->st_memo;
        }
        
        return view('pages.print_invoice', compact('COA','SS','st_invoice','type','location','no','invoice_date','invoice_due_date','customer','address','terms','job_order','work_no','email','note','memo'));
        
    }
    public function get_bill_info_for_supplier_credit(Request $request){
        $supplier_credit_bill_no=$request->supplier_credit_bill_no;
        $bill_info=ExpenseTransaction::where([
            ['et_type','=','Bill'],
            ['et_no','=',$supplier_credit_bill_no]
        ])->first();

        return $bill_info;
    }
    public function get_bill_account_detail(Request $request){
        $supplier_credit_bill_no=$request->supplier_credit_bill_no;
        $bill_info=EtAccountDetail::where([
            ['et_ad_no','=',$supplier_credit_bill_no]
        ])->get();

        return $bill_info;
    }
    public function check_supplier_credit_no(Request $request){
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=ExpenseTransaction::where([
            ['et_type','=','Supplier credit'],
            ['et_no','=',$invoice_no_field]
        ])->count();
        return $invoice_count;
    }
    public function check_bill_no(Request $request){
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=ExpenseTransaction::where([
            ['et_type','=','Bill'],
            ['et_no','=',$invoice_no_field]
        ])->count();
        $invoice_count_new=ExpenseTransactionNew::where([
            ['et_type','=','Bill'],
            ['et_no','=',$invoice_no_field]
        ])->count();
        return $invoice_count+$invoice_count_new;
    }
    public function check_sales_receipt_no(Request $request){
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Sales Receipt'],
            ['st_no','=',$invoice_no_field]
        ])->count();

        return $invoice_count;
    }
    public function check_credit_note_no(Request $request){
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Credit Note'],
            ['st_no','=',$invoice_no_field]
        ])->count();

        return $invoice_count;
    }
    public function check_estimate_no(Request $request){
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Estimate'],
            ['st_no','=',$invoice_no_field]
        ])->count();

        return $invoice_count;
    }
    public function check_invoice_no(Request $request){
        $invoice_location_top=$request->invoice_location_top;
        $invoice_type_top=$request->invoice_type_top;
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Invoice'],
            ['st_location', '=', $invoice_location_top],
            ['st_invoice_type','=',$invoice_type_top],
            ['st_no','=',$invoice_no_field]
        ])->count();

        return $invoice_count;
    }
    public function get_customer_info(Request $request){
        $customers=Customers::find($request->id);
        return $customers;
    }
    public function get_product_info(Request $request){
        return ProductsAndServices::find($request->id);
    }
    public function check_cost_center_name(Request $request){
        $count=0;
        $count+=count(CostCenter::where([['cc_type','=',$request->name]])->get());
        $count+=count(CC_Type::where([['cc_type','=',$request->name]])->get());
        return $count;
    }
    public function check_cost_center_code(Request $request){
        $count=0;
        $count+=count(CostCenter::where([['cc_type_code','=',$request->name]])->get());
        $count+=count(CC_Type::where([['cc_code','=',$request->name]])->get());
        return $count;
    }
    public function save_cc_type(Request $request){
        $data=new CC_Type;
        $data->cc_type=$request->typename;
        $data->cc_code=$request->typecode;
        $data->save();
    }
}

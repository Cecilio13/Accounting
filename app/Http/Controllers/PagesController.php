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

class PagesController extends Controller
{
    public function index(\Illuminate\Http\Request $request){
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, ['consmanagementsys']);
        if(empty($db)){

        }
        else{
            $users2 = DB::table('users')->get();
            $users1= DB::connection('mysql2')->select("SELECT * FROM employee_info JOIN employee_email_address ON 
            employee_info.employee_id=employee_email_address.emp_id JOIN employee_job_detail ON employee_job_detail.emp_id=employee_info.employee_id WHERE position='Fixed Asset Officer'");
            //return $users2[0]->id;
            $a = array();
            if(count($users1) > 0){
                foreach($users1 as $useri){
                    if($useri->email!=""){

                        //array_push($a,$useri->email);
                        $dup=0;
                        if(count($users2) > 0){
                            foreach($users2 as $userso){
                                if(strtolower($userso->email)==strtolower($useri->email)){
                                    $dup=1;
                                    
                                    break;
                                }
                            }
                        }
                        
                        if($dup==0){
                            $user= new User;
                            $user->name=$useri->fname;
                            $user->email=$useri->email;
                            $user->position=$useri->position;
                            $user->password=Hash::make($useri->password);
                            $user->save();
                        }
                    }
                
        
                }

            }
        }
        
            
        //temporary login using GET
        //http://accounting.me/?param1={email}&param2={password}
        $emailll=$request->input('param1');
        $passww=$request->input('param2');
        $sss=$passww;
        $arr2 = str_split($passww);
        $length=1;
        $dencrypted="";
        /* foreach($arr2 as $arr22){

            
            if($arr22=="_"){
                $dencrypted=$dencrypted." ";
            }else{
            $arr22=chr(ord($arr22) - $length);
            $dencrypted=$dencrypted.$arr22;
            }
            $length++;
        }
        $passww= $dencrypted;   */ 
       
        //$emailll = $request->route()->getAction()['Email'];
        //$passww = $request->route()->getAction()['Password'];
        /* $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-A";
        $cc_name="Administrative/Legal";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-B";
        $cc_name="Human Resource";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-C";
        $cc_name="Purchasing";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-D";
        $cc_name="Security";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-E";
        $cc_name="Accounting";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-F";
        $cc_name="Budget";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-G";
        $cc_name="Cashiering";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-H";
        $cc_name="Safety";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-I";
        $cc_name="Company Nurse";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-J";
        $cc_name="Logistic";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-K";
        $cc_name="Property Custodian";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="02";
        $cc_type="Administrative";
        $cc_name_code="02-L";
        $cc_name="Technical Working Group";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);

        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-1";
        $cc_name="CW Perimeter Lighting- Sarangani";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-2";
        $cc_name="Construction and Improvement of Road Including Drainage at Sobrecary";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-3";
        $cc_name="Demolition Job @ Astorga";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-4";
        $cc_name="Installation of Gabion ( Tudaya 2 Dessander )";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-5";
        $cc_name="Powerhouse A Dessander Gabion Installation ( Dessander B )";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-6";
        $cc_name="Powerhouse A Access Road Gabions Installation";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-7";
        $cc_name="Weir Trash Rack Modification";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-8";
        $cc_name="Dredging of Conveyance Canal";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-9";
        $cc_name="Contruction of CR @ Mintal";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-10";
        $cc_name="Construction of Septic Tank @ Mintal";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-11";
        $cc_name="Repair of Mess Hall @ Mintal";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-12";
        $cc_name="DLPC Under Ground";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-13";
        $cc_name="Intake Modification @ Mintal";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-A";
        $cc_type="Civil Works";
        $cc_name_code="03-A-14";
        $cc_name="Talomo 3 Spillway Catalunan";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-1";
        $cc_name="Magtuod 138KV";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-2";
        $cc_name="Tugbok 69KV";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-3";
        $cc_name="Substation Ponciano";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-4";
        $cc_name="PLDT Under Ground";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-5";
        $cc_name="Holcim- Transmission 69KV";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-6";
        $cc_name="Saranggani-Electrical";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-7";
        $cc_name="Talomo CCTV Plant 1A Project";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-8";
        $cc_name="Baguio Project";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-B";
        $cc_type="Electrical";
        $cc_name_code="03-B-9";
        $cc_name="Distribution Line Project Manolo";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);

        $cc_type_code="03-C";
        $cc_type="Telecommunication";
        $cc_name_code="03-C-1";
        $cc_name="FOC";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-C";
        $cc_type="Telecommunication";
        $cc_name_code="03-C-2";
        $cc_name="Skycable";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-C";
        $cc_type="Telecommunication";
        $cc_name_code="03-C-3";
        $cc_name="Surveillance Manolo";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-C";
        $cc_type="Telecommunication";
        $cc_name_code="03-C-4";
        $cc_name="VECO Project";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-C";
        $cc_type="Telecommunication";
        $cc_name_code="03-C-5";
        $cc_name="Surveillance CM Recto Mabini Street";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);
        $cc_type_code="03-C";
        $cc_type="Telecommunication";
        $cc_name_code="03-C-6";
        $cc_name="Surveillance Malagos Hedcor";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name);

        $cc_type_code="13";
        $cc_type="Arkpower";
        $cc_name_code="13-A";
        $cc_name="24/7 On call Electrician";
        $this->adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name); */
        
       
        
        $userdata = array(
            'email' => $emailll ,
            'password' => $passww
        );

        // attempt to do the login

        if (Auth::attempt($userdata))
            {
            $user = Auth::user();
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="User Login";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
            // Get the currently authenticated user's ID...
            $id = Auth::id();
            
            //Auth::logout();
            return redirect()->intended('/dashboard');
            // validation successful
            // do whatever you want on success

            }
          else
            {
            return redirect()->intended('/login');
            //echo $emailll." ".$passww;
            // validation not successful, send back to form

            //return Redirect::to('checklogin');
            }  
        /* $user = new User();
        $user->name = "Cecilio";
        $user->email = "Ceciliodeticio13@gmail.com";
        $user->password = "Odanobunaga13";
        Auth::logout();
        Auth::login($user);
        if (Auth::check()) {
            // Get the currently authenticated user...
            $user = Auth::user();
            echo $user;
            //echo "Authenticated!";
        } else {
            echo "<b>Not Authenticated!!!</b>";
        } */
        
    }
    public function dashboard(Request $request){
        try {
			
            DB::connection('mysql_ms')->getPdo();
            $employees_from_monitoring_system= DB::connection('mysql_ms')->select("SELECT * FROM ark_employee ");
            foreach($employees_from_monitoring_system as $efms){
                $customers_from_accounting = Customers::where([
                    ['display_name','=',$efms->First_Name." ".$efms->Middle_Name." ".$efms->Last_Name]
                ])->first();
                if(empty($customers_from_accounting)){
                $customer = new Customers;
                $customer->customer_id = Customers::count() + 1;
                $customer->f_name = $efms->First_Name;
                
                $customer->l_name = $efms->Last_Name;
                $customer->email = $efms->EmailAddress;
                $customer->company = "";
                $customer->phone = "";
                $customer->mobile = $efms->ContactNumber;
                $customer->fax = "";
                $customer->display_name = $efms->First_Name." ".$efms->Middle_Name." ".$efms->Last_Name;
                $customer->other = "";
                $customer->website = "";
                $customer->street = $efms->Address;
                $customer->city = "";
                $customer->state = "";
                $customer->postal_code = "";
                $customer->country = "";
                $customer->payment_method = "";
                $customer->terms = "";
                $customer->opening_balance = 0;
                $customer->as_of_date = date('Y-m-d');
                $customer->account_no = "";
                $customer->business_id_no = "";
                $customer->notes = "";
                $customer->attachment = "";
                $customer->tin_no=$efms->TINNo;
                $customer->withhold_tax=12;
                $customer->business_style="";
                $customer->account_type="Employee";
                
                $customer->save();

                $AuditLog= new AuditLog;
                $AuditLogcount=AuditLog::count()+1;
                $userid = Auth::user()->id;
                $username = Auth::user()->name;
                $eventlog="Imported Employee";
                $AuditLog->log_id=$AuditLogcount;
                $AuditLog->log_user_id=$username;
                $AuditLog->log_event=$eventlog;
                $AuditLog->log_name="";
                $AuditLog->log_transaction_date="";
                $AuditLog->log_amount="";
                $AuditLog->save();
                }else{
                   
                }
                
            }
            //return "";
        } catch (\Exception $e) {
            //connection not established
            //return $e;
        }
        $useracess=UserAccess::find("q");
        if(empty($useracess)){
            $useracess= new UserAccess;
            $useracess->user_id="q";
            $useracess->save();
        }
        
        
        //return Auth::user()->position;
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        if(empty($numbering)){
            $numbering = new Numbering;
            $numbering->numbering_no="0";
            $numbering->sales_exp_start_no="1001";
            $numbering->numbering_bill_invoice_main="1001";
            $numbering->numbering_sales_invoice_branch="1001";
            $numbering->numbering_bill_invoice_branch="1001";
            $numbering->credit_note_start_no="1001";
            $numbering->sales_receipt_start_no="1001";
            $numbering->bill_start_no="1001";
            $numbering->suppliers_credit_start_no="1001";
            $numbering->cash_voucher_start_no="1";
            $numbering->cheque_voucher_start_no="1";
            $numbering->estimate_start_no="1001";
            $numbering->save();
        }
        
        // $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        // $db = DB::select($query, ['consmanagementsys']);
        // if(empty($db)){
            
        // }else{
        //     $users2 = DB::table('products_and_services')->get();
        //     $users1= DB::connection('mysql2')->select("SELECT * FROM assets WHERE asset_approval='1'");
        //     if(count($users1) > 0){
        //         foreach($users1 as $useri){
        //                 //array_push($a,$useri->email);
        //                 $dup=0;
        //                 if(count($users2) > 0){
        //                     foreach($users2 as $userso){
        //                         if(strtolower($userso->product_name)==strtolower($useri->asset_tag)){
        //                             $dup=1;
                                    
        //                             break;
        //                         }
        //                     }
        //                 }
                        
        //                 if($dup==0){
        //                     $user= new ProductsAndServices;
        //                     $user->product_id=ProductsAndServices::count() + 1;
        //                     $user->product_name=$useri->asset_tag;
        //                     $user->product_sku=$useri->sku_code;
        //                     $user->product_type=$useri->asset_type;
        //                     $user->product_sales_description=$useri->asset_description;
        //                     $user->product_sales_price=$useri->current_cost;
        //                     $user->product_cost=$useri->current_cost;
        //                     $user->product_qty='1';
        //                     $user->product_reorder_point="0";
        //                     $user->save();
        //                 }
        //         }
    
        //     }
        // }
        // $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        // $db = DB::select($query, ['acc_system']);
        // if(empty($db)){

        // }else{
        //     $users1= DB::connection('mysql3')->select("SELECT * FROM customers");
        //     return $users1;
        // }
            // $coa_title="Assets";
            // $coa_account_type="Current Asset";
            // $coa_detail_type="Cash in Bank";
            // $coa_code="100";
            // $coa_normal_balance="Debit";
            // $coa_description=" ";
            // $coa_sub_acc="Bank";
            // $this->adddefaultcoa($coa_account_type,$coa_detail_type,$coa_code,$coa_normal_balance,$coa_title,$coa_description,$coa_sub_acc);

            // $coa_account_type="Current Asset";
            // $coa_detail_type="Accounts Receivable";
            // $coa_code="200";
            // $coa_normal_balance="Debit";
            // $coa_description=" ";
            // $coa_sub_acc="Receivable Accounts";
            
            // $this->adddefaultcoa($coa_account_type,$coa_detail_type,$coa_code,$coa_normal_balance,$coa_title,$coa_description,$coa_sub_acc);
            
            // $coa_account_type="Payable Accounts";
            // $coa_title="Liabilities";

            // $coa_detail_type="Accounts Payable";
            // $coa_code="1000";
            // $coa_normal_balance="Credit";
            // $coa_description=" ";
            // $coa_sub_acc="";
            // $this->adddefaultcoa($coa_account_type,$coa_detail_type,$coa_code,$coa_normal_balance,$coa_title,$coa_description,$coa_sub_acc);

            // $coa_title="Revenue";
            // $coa_account_type="Revenue";
            // $coa_detail_type="Service Revenue";
            // $coa_code="1300";
            // $coa_normal_balance="Credit";
            // $coa_description=" ";
            // $coa_sub_acc="";
            // $this->adddefaultcoa($coa_account_type,$coa_detail_type,$coa_code,$coa_normal_balance,$coa_title,$coa_description,$coa_sub_acc);
        
        $company = Company::first();
        $sales = Sales::first();
        $expenses = Expenses::first();
        $advance = Advance::first();
        $numbering = Numbering::first();
        $bank = Bank::all();
        if(empty($company) ||  empty($sales) || empty($expenses) ||  empty($advance) || empty($numbering) || empty($bank)){
            return redirect()->intended('/accountsandsettings');
        }
            
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $users2 = DB::table('users')->get();
        //$users1= DB::connection('mysql2')->select("SELECT * FROM employee_info JOIN employee_email_address ON 
        //employee_info.employee_id=employee_email_address.emp_id");
        //return $a;
        //$user= new User;
        //$user->name="Cecilio";
        //$user->email="Ceciliodeticio13@gmail.com";
        //$user->password="Odanobunaga13";
        //$user->save();
        

        //return view('pages.index')->with('usss',$users);
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();
        $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $sales_transaction = SalesTransaction::all();
        $total_invoice_receivable=0;
        $total_invoice_receivable_due=0;
        foreach($sales_transaction as $transaction){
            if($transaction->st_type == "Invoice" && $transaction->remark!="Cancelled"){
                $total_invoice_receivable += $transaction->st_balance;
                if(strtotime($transaction->st_due_date) < time()){
                    $total_invoice_receivable_due += $transaction->st_balance;
                }
            }
            
        }
        
        
        $overduetotal_amount=0;
        $unuetotal_amount=0;
        $current_month=0;
        $current_month_due=0;
        $current_month_less_one=0;
        $current_month_less_one_due=0;
        $current_month_less_two=0;
        $current_month_less_two_due=0;
        $current_month_less_three=0;
        $current_month_less_three_due=0;
        $rest=$request->expense_month;
        if($rest==""){
            $rest=date('n');
        }
        $month_selected_raw=$rest;
        $month_selected=$rest;
        if($month_selected<10){
            $month_selected="0".$month_selected;
        }

        $year_less_one=date('Y');
        $month_selected_less_one=$rest-1;
        $one_month=$rest-1;
        if($month_selected_less_one<=0){
            $month_selected_less_one+=12;
            $one_month+=12;
            $year_less_one=date('Y')-1;
        }
        if($month_selected_less_one<10){
            $month_selected_less_one="0".$month_selected_less_one;
        }

        $year_less_two=date('Y');
        $month_selected_less_two=$rest-2;
        $two_month=$month_selected_less_two;
        if($month_selected_less_two<=0){
            $month_selected_less_two+=12;
            $two_month+=12;
            $year_less_two=date('Y')-1;
        }
        if($month_selected_less_two<10){
            $month_selected_less_two="0".$month_selected_less_two;
        }

        $year_less_three=date('Y');
        $month_selected_less_three=$rest-3;
        $three_month=$month_selected_less_two;
        if($month_selected_less_three<=0){
            $month_selected_less_three+=12;
            $three_month+=12;
            $year_less_three=date('Y')-1;
        }
        if($month_selected_less_three<10){
            $month_selected_less_three="0".$month_selected_less_three;
        }

        //return $month_selected_less_two." - ".$year_less_two;
        foreach($expense_transactions as $et){
            
            if ($et->et_type==$et->et_ad_type){
                if($et->et_due_date!=""){
                    
                    if($et->et_date>=date('Y-'.$month_selected.'-01') && $et->et_date<=date('Y-'.$month_selected.'-t') ){
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($et->et_due_date);
                        $diff=date_diff($date1,$date2);
                        if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" ){
                            $current_month_due+=$et->bill_balance;
                        }else{
                            if($et->et_bil_status!="Paid" && $et->remark==""){
                                $current_month+=$et->bill_balance;
                            }   
                        }
                    }
                    if($et->et_date>=date($year_less_one.'-'.$month_selected_less_one.'-01') && $et->et_date<=date($year_less_one.'-'.$month_selected_less_one.'-t') ){
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($et->et_due_date);
                        $diff=date_diff($date1,$date2);
                        if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" ){
                            $current_month_less_one_due+=$et->bill_balance;
                        }else{
                            if($et->et_bil_status!="Paid" && $et->remark==""){
                                $current_month_less_one+=$et->bill_balance;
                            }   
                        }
                    }

                    if($et->et_date>=date($year_less_two.'-'.$month_selected_less_two.'-01') && $et->et_date<=date($year_less_two.'-'.$month_selected_less_two.'-t') ){
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($et->et_due_date);
                        $diff=date_diff($date1,$date2);
                        if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" ){
                            $current_month_less_two_due+=$et->bill_balance;
                        }else{
                            if($et->et_bil_status!="Paid" && $et->remark==""){
                                $current_month_less_two+=$et->bill_balance;
                            }   
                        }
                    }
                    if($et->et_date>=date($year_less_three.'-'.$month_selected_less_three.'-01') && $et->et_date<=date($year_less_three.'-'.$month_selected_less_three.'-t') ){
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($et->et_due_date);
                        $diff=date_diff($date1,$date2);
                        if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" ){
                            $current_month_less_three_due+=$et->bill_balance;
                        }else{
                            if($et->et_bil_status!="Paid" && $et->remark==""){
                                $current_month_less_three+=$et->bill_balance;
                            }   
                        }
                    }

                }
            }
        }
        
        //return 0;
        return view('pages.index', compact(['current_month_less_three','current_month_less_three_due','month_selected_less_three','year_less_three','three_month','one_month','two_month','current_month_less_two','current_month_less_two_due','month_selected_less_two','year_less_two','year_less_one','current_month_less_one','current_month_less_one_due','month_selected_raw','current_month_due','current_month','overduetotal_amount','unuetotal_amount','total_invoice_receivable','total_invoice_receivable_due','numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount', 'users2','customers', 'products_and_services','JournalEntry','VoucherCount']));

    }
    private function adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name){
        $cc= DB::connection('mysql')->select("SELECT * FROM cost_center WHERE cc_name_code='$cc_name_code' AND cc_name='$cc_name' AND cc_type='$cc_type' AND cc_type_code='$cc_type_code'");
        $cc_count = count($cc);
        if($cc_count<1){
            $costcenter= New CostCenter;
            $costcenter->cc_no= CostCenter::count() + 1; 
            $costcenter->cc_type_code=$cc_type_code; 
            $costcenter->cc_type=$cc_type; 
            $costcenter->cc_name_code=$cc_name_code; 
            $costcenter->cc_name=$cc_name;
            $costcenter->save();
        }
        
    }
    private function adddefaultcoa($coa_account_type,$coa_detail_type,$coa_code,$coa_normal_balance,$coa_title,$coa_description,$coa_sub_acc){
           $coa= DB::connection('mysql')->select("SELECT * FROM chart_of_accounts WHERE coa_account_type='$coa_account_type' AND coa_detail_type='$coa_detail_type' AND coa_name='$coa_detail_type'");
           $coa_count = count($coa);
           if($coa_count<1){
               $Chart= New ChartofAccount;
               $Chart->id= ChartofAccount::count() + 1; 
   
               $Chart->coa_account_type=$coa_account_type;
               $Chart->coa_detail_type=$coa_detail_type;
               $Chart->coa_name=$coa_detail_type;
               $Chart->coa_description=$coa_description;
               $Chart->coa_is_sub_acc="0";
               $Chart->coa_code=$coa_code;
               $Chart->normal_balance=$coa_normal_balance;
               $Chart->coa_title=$coa_title;
               $Chart->coa_parent_account="";
               $Chart->coa_balance="0";
               $Chart->coa_sub_account=$coa_sub_acc;
               $Chart->coa_as_of_date=date('Y-m-d');
               $Chart->coa_active="1";
               $Chart->save();
           } 
    }
    public function print_journal_entry(Request $request){
        $Journal_no_selected= $request->no;
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.print_journal', compact('Journal_no_selected','numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
    }
    public function reports(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.reports', compact('numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
    }
    public function userprofile(){
        
        
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.userprofile', compact('numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
    }
    public function voucher(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.voucher', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','customers','JournalEntry','products_and_services','VoucherCount'));

    }
    public function banking(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.banking', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','customers','JournalEntry','products_and_services','VoucherCount'));
    }
    public function pending_user(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $all_system_users=DB::table('users')->get();
        $all_system_users_access=DB::table('users_access_restrictions')->get();
        $all_system_users_cost_center_access=DB::table('user_cost_center_access')->get();
        $cost_center_list_grouped= CostCenter::where('cc_status','1')->groupBy('cc_type')->orderBy('cc_type', 'asc')->get();
        return view('pages.pending_users', compact('cost_center_list_grouped','all_system_users_cost_center_access','all_system_users_access','all_system_users','numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
       
    }
    public function sync(){
        return view('pages.sync');
    }
    public function approvals(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.approvals', compact('numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
      
    }
    public function expenses(){
        $customers = Customers::all();
        
        $products_and_services = ProductsAndServices::all();
        $Supplier= Supplier::where('supplier_active', '1')->get();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark=="" && $et->et_type==$et->et_ad_type)
            {
                $totalexp=$totalexp+$et->et_ad_total;
                //echo $et->et_ad_total."<br>";
            }
        }
        
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark=="" && $et->et_type==$et->et_ad_type){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        //return $expense_transactions;
        // foreach($expense_transactions as $et){
        //     print_r($et);
        //     echo "<br>";
        //     echo "<br>";
        // }
        return view('pages.expenses', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','et_it','et_acc','totalexp','expense_transactions','jounalcount','customers','Supplier', 'products_and_services','JournalEntry','VoucherCount'));
    }
   
    public function taxes(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.taxes', compact('numbering','st_invoice','cost_center_list','ETran','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','customers', 'products_and_services','JournalEntry','VoucherCount'));
    }
    public function accounting(Request $request){

        $chart_of_accounts = DB::table('chart_of_accounts')
                ->where('coa_active', '1')
                 ->get();
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $orThose2 = ['st_type' => 'Invoice','st_status' => 'Partially paid'];
        $sales_transaction = DB::table('sales_transaction')
            ->join('customers', 'customers.customer_id', '=', 'sales_transaction.st_customer_id')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $sales_tran = DB::table('sales_transaction')
            ->join('customers', 'customers.customer_id', '=', 'sales_transaction.st_customer_id')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $notude=0;
        $due=0;
        $invoicetotal=0;
        foreach($sales_tran as $st){
            $datetime1 = date_create(date('Y-m-d'));
            $datetime2 = date_create($st->st_due_date);
            $interval = date_diff($datetime1, $datetime2);
            $invoicetotal=$invoicetotal+$st->st_balance;
            if($interval->format('%R')=="-"){
                $due=$due+$st->st_balance;
            }else{
                $notude=$notude+$st->st_balance;
            }
            //echo $notude." ".$due."<br>";
        }
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA_Index=0;
        $keyword="";
        if($request->no){
            $COA_Index=($request->no)-1;
        }else{
            $COA_Index=0;
        }
        if($request->keyword){
            $keyword=$request->keyword;
        }else{
            $keyword="";
        }
        $chartofaccountbyaccounttype = DB::table('chart_of_accounts')
                ->skip($COA_Index)
                ->take(20)
                ->select('*')
                ->groupBy('coa_account_type')
                ->orderBy('id', 'asc')
                ->orderBy('coa_account_type', 'DESC')
                ->get();
        $COA= DB::table('chart_of_accounts')
                ->skip($COA_Index)
                ->take(20)
                ->where('coa_active','1')
                ->Where(function ($query) use ($keyword) {
                    $query->where('coa_account_type','LIKE','%'.$keyword.'%')
                          ->orwhere('coa_detail_type','LIKE','%'.$keyword.'%')
                          ->orwhere('coa_name','LIKE','%'.$keyword.'%')
                          ->orwhere('coa_code','LIKE','%'.$keyword.'%');
                })
                ->orderBy('id', 'asc')
                ->get();
        //return $COA;
        $COA_Type_GROUPPED = []; 
        foreach($COA as $coaa){
            $COA_Type_GROUPPED[]=$coaa->coa_account_type;
        }
        $COA_Type_GROUPPED=array_unique($COA_Type_GROUPPED);
        //return $COA_Type_GROUPPED;
        $SS=SalesTransaction::all();
        $ETran = DB::table('expense_transactions')->get();
        $CostCenter = DB::table('cost_center')->orderBy('cc_name_code', 'asc')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center = DB::table('cost_center')
                ->select('*')
                ->groupBy('cc_type')
                ->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();        
        return view('pages.accounting', compact('keyword','COA_Index','COA_Type_GROUPPED','cost_center','CostCenter','numbering','st_invoice','cost_center_list','ETran','SS','chartofaccountbyaccounttype','COA','expense_transactions','totalexp','et_acc','et_it','sales_transaction','invoicetotal','due','notude','jounalcount','customers', 'chart_of_accounts', 'products_and_services','JournalEntry','VoucherCount'));
    }
    public function cost_center(Request $request){
        $chart_of_accounts = DB::table('chart_of_accounts')
                ->where('coa_active', '1')
                 ->get();
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $orThose2 = ['st_type' => 'Invoice','st_status' => 'Partially paid'];
        $sales_transaction = DB::table('sales_transaction')
            ->join('customers', 'customers.customer_id', '=', 'sales_transaction.st_customer_id')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $sales_tran = DB::table('sales_transaction')
            ->join('customers', 'customers.customer_id', '=', 'sales_transaction.st_customer_id')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $notude=0;
        $due=0;
        $invoicetotal=0;
        foreach($sales_tran as $st){
            $datetime1 = date_create(date('Y-m-d'));
            $datetime2 = date_create($st->st_due_date);
            $interval = date_diff($datetime1, $datetime2);
            $invoicetotal=$invoicetotal+$st->st_balance;
            if($interval->format('%R')=="-"){
                $due=$due+$st->st_balance;
            }else{
                $notude=$notude+$st->st_balance;
            }
            //echo $notude." ".$due."<br>";
        }
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $chartofaccountbyaccounttype = DB::table('chart_of_accounts')
                ->select('*')
                ->groupBy('coa_account_type')
                ->orderBy('coa_code', 'desc')
                ->get();
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();
        $ETran = DB::table('expense_transactions')->get();
        $CC_Index=0;
        $keyword="";
        if($request->no){
            $CC_Index=($request->no)-1;
        }else{
            $CC_Index=0;
        }
        if($request->keyword){
            $keyword=$request->keyword;
        }else{
            $keyword="";
        }
        $CostCenter = DB::table('cost_center')
                    ->skip($CC_Index)
                    ->take(20)
                    ->Where(function ($query) use ($keyword) {
                        $query->where('cc_no','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_type_code','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_name_code','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_type','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_name','LIKE','%'.$keyword.'%');
                    })
                    ->orderBy('cc_type_code', 'asc')->get();
        $CC_Type_GROUPPED = []; 
        foreach($CostCenter as $coaa){
            $CC_Type_GROUPPED[]=$coaa->cc_type_code." -- ".$coaa->cc_type;
        }
        $CC_Type_GROUPPED=array_unique($CC_Type_GROUPPED);
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center = DB::table('cost_center')
                ->select('*')
                ->groupBy('cc_type')
                ->orderBy('cc_type_code', 'asc')
                ->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();        
        return view('pages.cost_center', compact('CC_Type_GROUPPED','keyword','CC_Index','cost_center','CostCenter','numbering','st_invoice','cost_center_list','ETran','SS','chartofaccountbyaccounttype','COA','expense_transactions','totalexp','et_acc','et_it','sales_transaction','invoicetotal','due','notude','jounalcount','customers', 'chart_of_accounts', 'products_and_services','JournalEntry','VoucherCount'));
    }

    public function invoice(){
        return view('pages.invoice');
    }
    public function receivepayment(){
        return view('pages.receivepayment');
    }
    public function estimate(){
        return view('pages.estimate');
    }
    public function creditnotice(){
        return view('pages.creditnotice');
    }
    public function salesreceipt(){
        return view('pages.salesreceipt');
    }
    public function sales(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $prod= ProductsAndServices::where('product_qty', '0')->get();
        $prod2= ProductsAndServices::whereRaw('product_qty<=product_reorder_point')->get();
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $sales_tran = DB::table('sales_transaction')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $notude=0;
        $due=0;
        $invoicetotal=0;
        foreach($sales_tran as $st){
            $datetime1 = date_create(date('Y-m-d'));
            $datetime2 = date_create($st->st_due_date);
            $interval = date_diff($datetime1, $datetime2);
            $invoicetotal=$invoicetotal+$st->st_balance;
            if($interval->format('%R')=="-"){
                $due=$due+$st->st_balance;
            }else{
                $notude=$notude+$st->st_balance;
            }
            //echo $notude." ".$due."<br>";
        }
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.sales', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','invoicetotal','due','notude','jounalcount','customers', 'products_and_services', 'sales_transaction','JournalEntry','prod','prod2','VoucherCount'));
    }
    public function refundreceipt(){
        return view('pages.refundreceipt');
    }
    public function delayedcredit(){
        return view('pages.delayedcredit');
    }
    public function delayedcharge(){
        return view('pages.delayedcharge');
    }
    //
    public function expense(){
        return view('pages.expense');
    }
    public function cheque(){
        return view('pages.cheque');
    }
    public function bill(){
        return view('pages.bill');
    }
    public function paybills(){
        return view('pages.paybills');
    }
    public function purchaseorder(){
        return view('pages.purchaseorder');
    }
    public function suppliercredit(){
        return view('pages.suppliercredit');
    }
    public function creditcardcredit(){
        return view('pages.creditcardcredit');
    }
    //
    public function bankdeposit(){
        return view('pages.bankdeposit');
    }
    public function transfer(){
        return view('pages.transfer');
    }
    public function journalentry(Request $request){
        // $JournalEntry = JournalEntry::where([['remark','!=','Cancelled']])->get();
        //     return $JournalEntry;
        $JournalNoSelected=0;
        $keyword="";
        if($request->no){
            $JournalNoSelected=($request->no)-1;
        }else{
            $JournalNoSelected=0;
        }
        if($request->keyword){
            $keyword=$request->keyword;
        }else{
            $keyword="";
        }
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        if($keyword==""){
            $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->skip($JournalNoSelected)->take(20)->orderBy('je_no','DESC')->orderBy('je_debit', 'DESC')->get();
        }else{
            $JournalEntry = DB::table('journal_entries')->skip($JournalNoSelected)
            ->join('chart_of_accounts', 'chart_of_accounts.id', '=', 'journal_entries.je_account')
            
            ->Where(function ($query) use ($keyword) {
                $query->where('je_debit','LIKE','%'.$keyword.'%')
                        ->where('remark','!=','NULLED')
                      ->orwhere('je_no','LIKE','%'.$keyword.'%')
                      ->orwhere('je_credit','LIKE','%'.$keyword.'%')
                      ->orwhere('je_memo','LIKE','%'.$keyword.'%')
                      ->orwhere('chart_of_accounts.coa_name','LIKE','%'.$keyword.'%')
                      ->orwhere('chart_of_accounts.coa_code','LIKE','%'.$keyword.'%')
                      ->orwhere('je_desc','LIKE','%'.$keyword.'%')
                      ->orwhere('je_name','LIKE','%'.$keyword.'%');
            })
            ->take(20)
            ->orderBy('je_no','DESC')
            ->orderBy('je_debit', 'DESC')
            ->get();
           // return $JournalEntry;
        }
        //return $JournalEntry;
        
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.journalentry', compact('keyword','JournalNoSelected','numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    
    }
    public function checkregister(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();
        $deposit_records=DepositRecord::all();
        $ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $all_cost_center_list=CostCenter::all();
        return view('pages.register', compact('all_cost_center_list','deposit_records','numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function statements(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.statements', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function investqtyadj(){
        return view('pages.investqtyadj');
    }
    //  
    public function accountsandsettings(){
        $company = Company::first();
        $sales = Sales::first();
        $expenses = Expenses::first();
        $advance = Advance::first();
        $numbering = Numbering::first();         
        $st_invoice = DB::table('st_invoice')->get();
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.accountsandsettings', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','company', 'sales', 'expenses', 'advance', 'customers', 'products_and_services','VoucherCount'));
    }
    public function customformstyles(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $settings_company = DB::table('settings_company')->first();
        $Formstyle= Formstyle::where('cfs_status', '1')->get();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.customformstyles', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Formstyle','settings_company','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    


    public function alllists(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.alllists', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    
    }
    
    public function recurringtransactions(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.recurringtransactions', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function attachments(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
                    ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
                    ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
                    ->get();
                    $et_acc = DB::table('et_account_details')->get();
                    $et_it = DB::table('et_item_details')->get();
                $totalexp=0;
                foreach($expense_transactions as $et){
                    if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
                }
                $COA= ChartofAccount::where('coa_active','1')->get();
                $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
                $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
                $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.attachments', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    //
    public function importdata(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
                    ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
                    ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
                    ->get();
                    $et_acc = DB::table('et_account_details')->get();
                    $et_it = DB::table('et_item_details')->get();
                $totalexp=0;
                foreach($expense_transactions as $et){
                    if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
                }
                $COA= ChartofAccount::where('coa_active','1')->get();
                $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
                $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
                $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.importdata', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function exportdata(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.exportdata', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function auditlog(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.auditlog', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    

}

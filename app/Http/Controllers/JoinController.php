<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Firm;
use App\Models\Phone;
use App\Models\Role;
use App\Models\Account;

class JoinController extends Controller
{
    public function show()
    {
        // 1). Simple join or Inner join query : 

        $query1 = User::join('firms', 'users.id', '=', 'firms.user_id')
                ->select('users.*', 'firms.*')
                ->where('user_id', '>', 3)
                ->get();


        // 2). Left join query :

        $query2 = User::leftJoin('firms','users.id', '=', 'firms.user_id')
                    ->select('firms.*', 'users.*')
                    ->get();


        // 3). Right join query :

        $query3 = User::rightJoin('firms', 'users.id' , '=', 'firms.user_id')
                ->select('users.*', 'firms.*')
                ->get();


        // 4). Cross join query:

        $query4 = User::crossJoin('firms')
                // ->select('users.bio-data', 'firms.address')
                ->get();


        // 5). Advanced join query : 

        $query5 = User::join('firms', function($join) {
            $join->on('users.id', '=', 'firms.user_id')
                ->where('users.id', '>=', 2);
        })
            // ->select('users.bio-data', 'firms.f_name')
            ->get();


        /* 6). Sub-query join : 
               First example     */                   
        $firms = Firm::select('user_id',DB::raw('MAX(created_at)'))
                        ->groupBy('user_id');

        $users = User::joinSub($firms, 'latest_firms', function($join){
             $join->on('users.id', '=', 'latest_firms.user_id');
                
        })->get();

                // second example
        $users = User::select('id','name')
                        ->groupBy('id');

        $firms = Firm::leftJoinSub($users, 'newUser', function($join){
            $join->on('firms.user_id', '=', 'newUser.id');
        })->get();       



        //third example : 

        $firms = Firm::select('user_id', 'f_name','address')
                    ->where('firms.user_id', '>=', 2);
                    // ->groupBy('user_id','f_name','address');

        $users = User::rightJoinSub($firms, 'newFirms', function($join){
            $join->on('users.id', '=', 'newFirms.user_id');
        })->where('users.id', '>', 1)
        ->get();


                    //Practice : 

        //inner
        $firms = Firm::join('users', 'firms.user_id', '=', 'users.id')
                            ->select('users.*','firms.*')
                            ->get();

        //right
        $firms = Firm::rightJoin('users', 'users.id', '=', 'firms.user_id')
                        ->select('users.*','firms.user_id')
                        ->get();
        
        //left
        $firms = Firm::leftJoin('users', 'users.id', '=', 'firms.user_id')
                        ->select('firms.f_name', 'users.*')
                        ->get();                

        //cross
        $firms = Firm::crossJoin('users')
                    ->get();

        //advanced
        $firms = Firm::join('users', function($join){
            $join->on('users.id', '=', 'firms.user_id');
            
        })->get();

        //sub query

        $firms = Firm::select('user_id', 'f_name');
                    
        $users = User::joinSub($firms, 'newFirms', function($join){
            $join->on('users.id', '=', 'newFirms.user_id');
        })->get();

    
        // Advanced : 

        $users = User::rightJoin('firms', function($join){
        $join->on('users.id', '=', 'firms.user_id');
        })->select('users.id', 'firms.user_id', 'f_name','description')
        ->get();


        // sub-query : 

        $firms = Firm::select('firms.user_id', 'f_name');

        $users = User::leftJoinSub($firms, 'newFirms', function($join){
        $join->on('users.id', '=', 'newFirms.user_id');
        })->get();


        // left join : 

        $users = User::leftJoin('firms', 'users.id', '=', 'firms.user_id')
                    ->select('users.id', 'name', 'f_name', 'firms.user_id')
                    ->get();


        // sub query: 

        $users = User::select('users.id');

        $firms = Firm::leftJoinSub($users, 'newUsers', function($join){
            $join->on('firms.user_id' , '=', 'newUsers.id');
        })
        ->get();



        $users = User::select('users.id');

        $firms = Firm::leftJoinSub($users, 'newUser', function($join){
            $join->on('firms.user_id', '=', 'newUser.id');
        })->select('firms.user_id', 'newUser.id')
        ->get();



        //Practice : 

        //inner : 

        $firms = Firm::join('users', 'firms.user_id', '=', 'users.id')
                        ->select('name','f_name','user_id','users.id')
                        ->get();

        //left join : 

        $users = User::leftJoin('firms', 'firms.user_id', '=', 'users.id')
                        ->select('users.id', 'name', 'user_id','f_name','address')
                        ->get();

        //right join : 

        $firms = Firm::rightJoin('users', 'firms.user_id', '=', 'users.id')
                // ->select('users.id', 'user_id', 'name', 'f_name')
                ->where('firms.user_id', '>', 6)
                ->get();
                
        //cross join : 

        $users = User::crossJoin('firms')
                ->select('user_id', 'users.id', 'f_name', 'name')
                ->get();

        //advanced join : 

        $firms =Firm::rightJoin('users', function($join){
            $join->on('users.id', '=', 'firms.user_id');
        })->select('f_name', 'name','address','description','user_id', 'users.id')
        ->get();


        //sub query : 

        $users = User::select('users.id', 'name', 'email');


        $firms = Firm::joinSub($users, 'newUser', function($join){
            $join->on('firms.user_id', '=', 'newUser.id');
        })->get();


        // sub query leftJoinSub : 


        $firms = Firm::select('firms.user_id', 'f_name');

        $user = User::leftJoinSub($firms, 'newFirm', function($join){
            $join->on('users.id', '=', 'newFirm.user_id');
        })->get();


        // sub query rightJoinSub : 

        $users = User::select('users.id', 'name');

        $firms = Firm::rightJoinSub($users, 'newUser', function($join){
            $join->on('newUser.id', '=', 'firms.user_id');
        })->get();




        //inner join : 

        $users = User::join('firms', 'users.id', '=', 'firms.user_id')
                    ->select('user_id', 'users.id','f_name')
                    ->get();
        

        //left join 

        $firms = Firm::leftJoin('users', 'users.id', '=', 'firms.user_id')
                    ->select('user_id','users.id','f_name','u_address')
                    ->get();                


        //right join 

        $firms = Firm::rightJoin('users','firms.user_id', '=', 'users.id')
                    ->get();


        //cross join 

        $users = User::crossJoin('firms')
                    ->get();


        // advanced join 

        $users = User::leftJoin('firms', function($query){
            $query->on('users.id', '=', 'firms.user_id');
        })->select('users.*','firms.*')
        ->get();;


        //sub query 

        $firms = Firm::select('firms.user_id','f_name');

        $user = User::joinSub($firms,'newFirm', function($query){
            $query->on('users.id', '=', 'newFirm.user_id');
        })->get();



        $users = User::select('users.id', 'description','name');

        $firms = Firm::leftJoinSub($users, 'newUser', function($query){
            $query->on('firms.user_id', '=', 'newUser.id');
        })->get();




        $users = User::select('users.id', 'description');

        $firms = Firm::rightJoinSub($users,'newUser', function($q){
            $q->on('firms.user_id', '=', 'newUser.id');
        })->get();

        

        // $firms = Firm::find(1);

        // return $firms->users;


        $users = User::find(7);

        return $users->firm;


        // $firms = Firm::find(2);

        // return $firms->users->name;

    }

    public function model()
    {
    //   return $user = User::find(1)->accounts;
        
        // return $account = User::find(1)->accounts;

        // return $user = Account::find(1)->user;

        return $accounts = User::find(1)->accounts;
    }

    public function relation()
    {
        // return $roles = User::find(1)->roles;   -returns role of the user.

        // return $users =Role::find(2)->users->where('id', '=', 2);   -returns the user's name whose role is 'admin' and whose id is 2.
        
        // $roles = Role::find(2);
        // // dd($roles->users);
        // foreach($roles->users as $role)
        // {
        //     echo $role->name;                         // returns the names of users who are admin.
        // }


        // $user= User::find(1);
        // dd($user->roles);
        // foreach($user->roles as $role)
        // {
        //     echo $role->name;
        // }

        // $user = Role::find(2)->users;
        // dd($user);
        // foreach($user as $role)
        // {
        //     dd($role->name);
        // }


    //    $user  = User::find(2);
    //     dd($user->roles);
    //    foreach($user->roles as $role)
    //    {
    //        echo $role->field;
    //    }
        

        // $roles = Role::find(1);

        // foreach($roles->users->where('id', '=', 4) as $role)
        // {
        //     echo $role->name;
        // }

    }
}

<?php
namespace App\Http\Controllers;
use Illuuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;

Class UserController extends Controller {
use ApiResponser;
private $request;
public function __construct(Request $request){
$this->request = $request;
}
    public function info(){
        
        $users = User::all();
        return response()->json($users, 200);
    }
    public function showID($id)
    {
        //
        return User::where('id','like','%'.$id.'%')->get();
    }
    public function addCustomer(Request $request ){
        $rules = [
        'customer_first_name' => 'required|max:20',
        'customer_last_name' => 'required|max:20',
        'customer_phone_num' => 'required|max:20',
        ];
        $this->validate($request,$rules);
        $user = User::create($request->all());
        return $user;
       
}
    public function update(Request $request,$id)
    {
    $rules = [
        'customer_first_name' => 'required|max:20',
        'customer_last_name' => 'required|max:20',
        'customer_phone_num' => 'required|max:20',
    ];
    $this->validate($request, $rules);
    $user = User::findOrFail($id);
    $user->fill($request->all());

   
    if ($user->isClean()) {
    return $this->errorResponse('At least one value must
    change', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $user->save();
    return $user;
}
    public function delete($id)
    {
    $user = User::findOrFail($id);
    $user->delete();

 
    
    }
}
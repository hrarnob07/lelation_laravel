<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $user ;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public  function index()
    {
        $users = $this->user->all();

        if(!empty($this->user->errors()))
        {
            return response()->json([
                'success' => false,
                'message'=> $this->user->errors()
            ]);
        }
        return  $users;
    }
    public function store(UserRequest $request)
    {

        Try{
            $form = $request->validated();

            $form["status"] = empty($form["status"])? 'pending': $form["status"];
            $form["role"] = empty($form['role'])? 'user': $form['role'];
            /**
             * create user
             */

            $user=  $this->user->create($form);


            $data['address'] = empty($form['address'])? '': $form["address"];
            $data['gender'] = empty($form['gender'])? '': $form["gender"];
            $data['age'] = empty($form['age'])? 0: $form["age"];

            /**
             * profile add
             */

            $user->profile()->create($data);


            /**
             * attachment image of the user
             */

            if(!empty($form['attachment']))
            {
                $attactment['url'] =  $form['attachment'];

                $user->image()->create($attactment);

            }
            if(!empty($this->user->errors()))
            {
                return response()->json(['success'=> false,
                    'message'=>$this->user->errors()
                ]);
            }
            return response()->json([
                'success'=> true,
                'message'=>'Successfully user created',
                'data'=>$user
            ]);

        }
        catch (\Throwable $exception)
        {
            return response()->json(['success'=> false,
                'message'=>$exception->getMessage()
            ]);
        }

    }
}

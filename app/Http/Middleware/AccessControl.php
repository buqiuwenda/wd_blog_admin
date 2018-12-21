<?php
/**
 * Class AccessControl
 * @package App\Http\Middleware
 * Author:huangzhongxi@rockfintech.com
 * Date: 2018/11/30 2:42 PM
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Model\Member;

class AccessControl
{
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check()){
            /**
             * @var $member Member
             */
            $member = Auth::guard($guard)->user();

            if($member['id'] == config('permission.root_user')){
                return $next($request);
            }

            $name = Route::currentRouteName();

            $verify = $member->permissionCheck($name);

            if($verify){
              return $next($request);
            }else{
                abort(403);
            }


        }else{
            return redirect()->route('login');
        }


    }
}
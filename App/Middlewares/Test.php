<?php

namespace App\Middlewares;

use Closure;
use Mabdulmonem\System\Http\Request;

class Test {

    public function handle(Request $request, ?Closure $next = null)
    {
//        return redirect('login');
        $role = "admin1";
        if($role != "admin"){
          
            return redirect('login');
        }

        return $next();
        
    }
}
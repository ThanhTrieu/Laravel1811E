<?php

namespace App\Http\Middleware;

use Closure;

class CheckNumberOddOrEven
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $params = null)
    {
        // in params
        // dd($params);
        // sau nay co the xu ly logic gi do cho param.

        // luon luon duoc thuc thi 1 request nao do
        $respone = $next($request);

        // after middleware
        //  chung se kiem tra cac tham so cua routes sau
        $myNumber = $request->number;
        if($myNumber % 2 != 0){
            return redirect('test-number');
        }
        // neu vuot qua phan check se tiep tuc thuc thi request $respone . Neu khong dung lai request do
        
        return $respone;
    }
}

<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->path() == RouteServiceProvider::HOME)
            return parent::render($request, $exception);
        
        $statusCode = -1;
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $statusCode = $exception->getStatusCode();    
        }
        // else {
        //     $statusCode = $exception->getCode();   
        // }
        // elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
        //     $statusCode = $exception->getStatusCode();
        // }
        // dd($exception->getMessage());

        if ($statusCode >= 0) {
            $errors = [
                401 => [
                    'image'=>'401.png',
                    'title'=>'401 | Unauthorized',
                    'label'=>[
                        'head'=>'You dont have authorized to access the page',
                        'description'=>''
                    ],
                ],
                404 => [
                    'image'=>'404.png',
                    'title'=>'404 | Page Not Found',
                    'label'=>[
                        'head'=>"Oopps. The page you were looking for doesn't exist",
                        'description'=>'You may have mistyped the address or the page may have moved. <a href="'.url()->previous().'".>Back</a> to previous URL'
                    ],
                ],
                413 => [
                    'image'=>'413.png',
                    'title'=>'413 | Error ',
                    'label'=>[
                        'head'=>"Error Exception",
                        'description'=>$exception->getMessage()
                    ],
                ],
                // 0 => [
                //     'image'=>'0.png',
                //     'title'=>'Error ',
                //     'label'=>[
                //         'head'=>"Error Exception",
                //         'description'=>$exception->getMessage().' on '.$exception->getFile().' line:'.$exception->getLine()
                //     ],
                // ],
            ];

            $data = [
                'status'=>$statusCode,
                'error'=>$errors[$statusCode]
            ];
            
            $global = \App\Tools\Variable::set([
                'title'=>$errors[$statusCode]['title'],
            ]);
            return response()->view('errors.custom', $data);
        }
        
        return parent::render($request, $exception);
    }
}

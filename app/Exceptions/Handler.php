<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use App\Models\Error;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof CustomException) {
            return api()->error(__($exception->getMessage()),[
                'error' => $exception->data
            ]);
        } else if ($exception instanceof ModelNotFoundException) {
            $a = explode('\\', $exception->getModel());
            $model = end($a);
            $ids = implode(', ', $exception->getIds());

            if ($exception->getIds()) {
                $message = __(":model with id(s) `$ids` not found.", ['model' => $model]);
            } else {
                $message = __(":model not found.", ['model' => $model]);
            }
            return api()->notfound($message);
        }else if ($exception instanceof \PDOException) {
            return api()->validation(__('Database Error!!!'),[
                'error' => $exception->getMessage()
            ]);
        }
        else if ($exception instanceof \PDOException) {
            return api()->validation(__('Database Error!!!'),[
                'error' => $exception->getMessage()
            ]);
        }
        else if ($exception instanceof NotFoundHttpException) {
            $ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
            $isMobile = is_numeric(strpos($ua, "mobile"));
            $isPostman = is_numeric(strpos($ua, "postmanruntime"));
            $isWeb = is_numeric(strpos($ua, "web"));

            if ($isMobile == 1 || $isPostman == 1) {
                return api()->error(__('404 method not found'),[
                    'error' => $exception->getMessage()
                ]);
            }else if ($isWeb == 1) {
                return response(redirect(url('dashboard')), 404);
            }
        }
        else if ($exception instanceof \GuzzleHttp\Exception\ServerException) {
            return api()->validation(__('ServerException Error!!!'),[
                'error' => $exception->getMessage()
            ]);
        }
        else if ($exception instanceof \Twilio\Exceptions\RestException) {
            return api()->error(__('Invalid phone number'),(object)[]);
        }
        return parent::render($request, $exception);
    }

    public function register()
    {
        $this->reportable(function (Throwable $exception) {
            // only create entries if app environment is not local
            if(!app()->environment('local'))
            {
               $user_id = null;

               if (Auth::user()) {
                   $user_id = Auth::user()->id;
               }

               $data = array(
                   'user_id'   => $user_id,
                   'code'      => $exception->getCode(),
                   'file'      => $exception->getFile(),
                   'line'      => $exception->getLine(),
                   'message'   => $exception->getMessage(),
                   'trace'     => $exception->getTraceAsString(),
               );

               Error::create($data);
            }
        });
    }
}

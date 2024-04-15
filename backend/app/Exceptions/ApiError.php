<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ApiError extends \Exception
{
    protected $code = null;
    protected $message = null;
    protected $fields = null;

    public function __construct($code = 500, $message = '', $fields = [], \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = $code;
        $this->message = $message;
        $this->fields = $fields;
    }

    // public function context(): array
    // {
    //     return [
    //         'code' => $this->code,
    //         'message' => $this->message,
    //         'fields' => $this->fields,
    //     ];
    // }

    public function render(): Response
    {
        return response([
            'code' => $this->code,
            'message' => $this->message,
            'fields' => $this->fields,
        ], $this->code);
    }
}

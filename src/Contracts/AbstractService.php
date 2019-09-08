<?php
namespace Imdhemy\Repovel\Contracts;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Imdhemy\Repovel\Contracts\ServiceInterface;
use Imdhemy\Repovel\Requests\BaseFormRequest;

abstract class AbstractService implements ServiceInterface, Jsonable
{
    /**
     * Form Request
     *
     * @var Illuminate\Foundation\Http\FormRequest
     */
    protected $requests;

    /**
     * Create new instance
     *
     * @param Illuminate\Http\Request|null $request
     */
    public function __construct(?Request $request = null)
    {
        $this->request = $this->createFormRequest($request);
    }

     /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->handle(), $options);
    }

    /**
     * Create Form request from the submitted request
     *
     * @param  Request|null $request
     * @return Illuminate\Foundation\Http\FormRequest
     */
    protected function createFormRequest(? Request $request = null) : FormRequest
    {
        return ($request instanceof FormRequest) ? $request : \App::make(BaseFormRequest::class);
    }

    /**
     * Allow invoking FormRequest methods
     *
     * @param  string $name
     * @param  array $arguments
     * @return mixed
     */
    protected function __call($name, $arguments)
    {
        return $this->request->$name(... $arguments);
    }
}

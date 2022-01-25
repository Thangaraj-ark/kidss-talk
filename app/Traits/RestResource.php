<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Trait Uuids
 * @package App
 */
trait RestResource
{
    //protected $modelClass;

    protected $modelIndexRoute;

    protected $modelCreateRoute;

    protected $modelUpdateRoute;

    protected $modelDeleteRoute;

    //protected $datatableClass;

    protected $resourcePath;

    protected $indexIsDatatable = true;

    protected $indexBladePath = "users.index";

    protected $createBladePath = "users.create";

    protected $editBladePath = "users.edit";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function index()
    {
        $data = [
            'indexRoute' => 'users.index',
            'deleteRoute' => $this->modelDeleteRoute,
            'modelClass' => $this->modelClass,
            'resourcePath' => 'users'
        ];

        $data = array_merge($data, $this->_indexFormData());
        //dd($data);
        $datatableParams = $this->_indexDataTableParams();
        //dd($datatableParams);
        //return (new $this->datatableClass)->render($this->indexBladePath, $data);
        return $this->indexIsDatatable ?
            (new $this->datatableClass)->with($datatableParams)->render($this->indexBladePath, $data) :
            view($this->indexBladePath, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data =  [
            'model' => $this->_getCreateModel(),
            'route' => $this->modelCreateRoute,
            'resourcePath' => $this->resourcePath,
            'colSize'  => 'col-md-12'
        ];

        $data = array_merge($data, $this->_createFormData());

        return view($this->createBladePath, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function store(Request $request)
    {
        $model = (new $this->modelClass);

        $this->_modifyFormRequest($model, $request);

        $this->_validate($request);

        $savedModel = $this->_save($request, $model);

        if ($request->ajax()) {
            return response()->json($savedModel);
        } else {
            flash(sprintf("%s created successfully", class_basename($model)))->success();
            return redirect()->route($this->_indexRoute() ?: sprintf("%s.index", $this->resourcePath));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return Response|mixed
     */
    public function show(string $id)
    {
        $Model = $this->getModel($id);

        return view(sprintf("users.show", $this->resourcePath), compact('Model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     *
     * @return Response|mixed
     */
    public function edit(string $id)
    {
        $data = [
            'id' => $id,
            'model' => $this->getModel($id),
            'route' => [$this->modelUpdateRoute, $id],
            'breadcrumbRoute' => $this->modelUpdateRoute,
            'resourcePath' => $this->resourcePath,
            'colSize'  => 'col-md-12'
        ];

        $data = array_merge($data, $this->_updateFormData($data['model']));

        return view($this->editBladePath, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     *
     * @return Response|mixed
     */
    public function update(Request $request, string $id)
    {
        $model = $this->getModel($id);

        $this->_modifyFormRequest($model, $request);

        $this->_validate($request, $id);

        $savedModel = $this->_save($request, $model);

        if ($request->ajax()) {
            return response()->json($savedModel);
        } else {
            flash(sprintf("%s updated successfully", class_basename($model)))->success();
            return redirect()->route($this->_indexRoute() ?: sprintf("%s.index", $this->resourcePath));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     */
    public function destroy(string $id)
    {
        $this->getModel($id)->delete();
    }

    /***
     * @param $id
     * @return mixed
     */
    public function getModel($id)
    {
        return $this->modelClass::find($id);
    }

    /**
     * @return mixed
     */
    protected function _getCreateModel()
    {
        return (new $this->modelClass);
    }

    /**
     * @param $model
     * @param Request $request
     */
    protected function _modifyFormRequest($model, Request &$request)
    {
        //
    }

    /**
     * @return array
     */
    protected function _indexFormData() :array
    {
        return [];
    }

    /**
     * @return string|null
     */
    protected function _indexRoute()
    {
        return null;
    }

    /**
     * @return array
     */
    protected function _indexDataTableParams() :array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function _createFormData() :array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function _updateFormData(&$model) :array
    {
        return [];
    }

    /**
     * @param $request
     * @param null $id
     *
     * @return array
     */
    protected function _rules($request, $id = null) :array
    {
        return [];
    }

    /**
     * @param $request
     * @param null $id
     *
     * @return array
     */
    protected function _ruleMessages($request, $id = null) :array
    {
        return [];
    }

    /**
     * @param $request
     * @param null $id
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function _validate($request, $id = null)
    {
        $this->validate($request, $this->_rules($request, $id), $this->_ruleMessages($request, $id));
    }

    /**
     * @param $request
     * @param $model
     */
    protected function _save($request, $model)
    {
        $data = $request->except(['_token']);

        $model->fill($data);
        $model->save();

        return $model;
    }
}

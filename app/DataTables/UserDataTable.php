<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        //dd($query);
        return datatables()
            ->eloquent($query)
            ->editColumn('name', function ($model) {
                return 'kumae';
            })
            ->addColumn('action', function ($model) {
                $action = '';
//                if(\Auth::user()->can('cities.edit')){
//                    $action = '<a href="' . route('cities.edit', $model->id) . '" class="btn btn-warning" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;';
//                }
//                if(\Auth::user()->can('cities.show')) {
//                    $action .= '<a href="javascript:void(0)" class="btn btn-default" title="View" data-url="' . route('cities.show', $model->id) . '" data-toggle="modal" data-target="#DatatableViewModal"><i class="fa fa-eye"></i></a>&nbsp;';
//                }
//                if(\Auth::user()->can('cities.destroy')) {
//                    $action .= ' <button class="btn btn-danger btn-delete" type="button" title="Delete" data-id="' . $model->id . '" data-loading-text="<i class=\'fa fa-spin fa-spinner\'></i> Please Wait..."><i class="fa fa-trash"></i></a>';
//                }
                return $action;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->where('adsad', 'asdasd');
    }

    /**
     */
    public function html()
    {
        $params = $this->getBuilderParameters('user.store');

        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom(config('datatables-buttons.parameters.dom'))
            ->orderBy(0, 'asc')
            ->parameters($params);
    }

    protected function getColumns()
    {
        return [
            'name',
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    
    protected function filename()
    {
        return 'users_' . date('YmdHis');
    }
}
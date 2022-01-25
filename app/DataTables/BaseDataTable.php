<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Helpers\SecurityHelper;
use Storage;
use View;
use DataTables;

class BaseDataTable extends DataTable
{

    protected function getBuilderParameters($createRoute = null)
    {
        $params = config('datatables-buttons.parameters');

        if (!\Auth::user()->can($createRoute)) {
            unset($params['buttons'][0]); //removed create
            $params['buttons'] = array_values($params['buttons']);
        }

        $params['drawCallback'] = "function(settings) {
            const func = 'datatableDrawCallback';
            if($.isFunction(window[func])) {
                eval(func + '(settings)');
            }
        }";

        return $params;
    }

}

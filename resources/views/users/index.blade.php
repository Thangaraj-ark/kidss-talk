@extends('layouts.app')


@section('content')
    
    {!! $dataTable->table(['class' => 'table table-striped table-responsive', 'id' => 'datatable-buttons']) !!}
    <div id="DatatableViewModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">View {{ @$dataTableTitle ? Str::singular($dataTableTitle) : class_basename($modelClass) }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body order-status-table" id="datatableViewContent"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

<!-- @includeIf(sprintf("%s.index_scripts", $resourcePath)) -->

@push('scripts')
    
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    {{$dataTable->scripts()}}

@endpush
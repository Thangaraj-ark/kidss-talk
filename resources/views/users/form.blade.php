<div class="form-group">
	<label class="col-sm-2 control-label" for="title"> Name: </label>
    <div class="col-sm-6">
        {{ Form::text('name',  ($data->name ?? ''), ['class'=>'form-control']) }}
    </div>
</div>
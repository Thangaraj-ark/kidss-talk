@extends('layouts.app')
@section('content')

{{ Form::model($data, array('class' => 'form-horizontal', 'route' => array('category.store', $data->id), 'files' => true)) }}
    @include('users.form')
{{ Form::close() }}
@extends('layouts.app')
@section('content')

<h2>Edit category</h2>

{{ Form::model($data, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('category.update', $data->id), 'files' => true)) }}
    @include('users.form')
{{ Form::close() }}
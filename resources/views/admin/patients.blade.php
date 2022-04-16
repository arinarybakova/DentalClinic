@extends('layouts.admin')

@section('title', 'Patients')
@section('headingTitle', 'Pacientai')

@section('content')
    <users usertype="{{ config('app.usertype_patient') }}"></users>
@endsection
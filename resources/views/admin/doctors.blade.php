@extends('layouts.admin')

@section('title', 'Doctors')

@section('content')
    <users usertype="{{ config('app.usertype_dentist') }}"></users>
@endsection
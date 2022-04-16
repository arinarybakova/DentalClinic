@extends('layouts.admin')

@section('title', 'Doctors')
@section('headingTitle', 'Gyd. odontologai')

@section('content')
    <users usertype="{{ config('app.usertype_dentist') }}"></users>
@endsection
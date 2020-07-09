@extends('layouts.app')

@section('content')
    <user-edit-component
        :user = "{{ json_encode($user) }}"
    />
@endsection

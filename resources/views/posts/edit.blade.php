@extends('layouts.app')

@section('content')
    <post-edit-component
        :post = "{{ json_encode($post) }}"
    />
@endsection

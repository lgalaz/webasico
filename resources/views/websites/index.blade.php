@extends('layouts.app')

@section('content')

<website-index
    :account="{{json_encode($account)}}"
    :websites="{{json_encode($websites)}}"
></website-index>

@endsection

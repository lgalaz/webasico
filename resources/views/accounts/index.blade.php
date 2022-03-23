@extends('layouts.app')

@section('content')

<account-index :accounts="{{json_encode($accounts)}}"></account-index>

@endsection

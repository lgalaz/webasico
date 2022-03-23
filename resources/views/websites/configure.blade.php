@extends('layouts.app')

@section('content')

<website-configure :website="{{json_encode($website)}}">
</website-configure>

@endsection

@extends('layout')

@section('content')
    @include('cards.rain')
    @foreach(range(0, 2) as $i)
        @include('cards.hourly', ['date' => now()->addDays($i)])
    @endforeach
@endsection
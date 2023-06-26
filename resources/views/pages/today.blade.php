@extends('layout')

@section('content')
    @include('cards.now')
    {{-- @include('cards.rain') --}}
    {{-- @include('cards.radar') --}}
    @include('cards.forecast-today')
    @include('cards.weather-today')
    @include('cards.forecast-hourly')
    @include('cards.forecast-daily')
@endsection

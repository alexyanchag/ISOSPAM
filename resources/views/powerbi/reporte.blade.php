@extends('layouts.dashboard')

@section('spinner')
    <x-spinner />
@endsection

@section('content')
    <iframe
        style="width: 100vh !important; height: 92vh !important;"
        src="https://app.powerbi.com/view?r=eyJrIjoiNDllMjkyYmYtZWU2YS00M2E5LWIyNGItYjFlNDQyM2Q1NzUxIiwidCI6Ijc0YTdlYjFkLTQzODgtNDhjNS04YWU4LWY0YjY5NzFlOTJlYiJ9"
        frameborder="0"
        allowfullscreen="true">
    </iframe>
@endsection

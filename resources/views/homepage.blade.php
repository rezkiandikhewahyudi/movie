@extends('layout.template')

@section('title', 'Homepage')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>    
@endif

<h1>Popular Movie</h1>

<div class="row">

    @foreach ($movies as $movie)
        @include('movies.partials.card')
    @endforeach

</div>

<div class="d-flex justify-content-center">
    {{ $movies->links() }}
</div>

@endsection

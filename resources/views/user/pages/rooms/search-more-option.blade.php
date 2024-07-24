
@extends('user.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-md-11 mt-5 mx-auto">
            @livewire('room.option-form', [
           'branch' => $branch,
           'rooms' => $rooms,
           'condition' => $condition,
          ])
        </div>
    </div>
@endsection

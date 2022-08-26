@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Average Events Count') }}</div>
                    
                <div class="card-body">
                {{$average->average}}
                </div>
            </div>
        </div>

        <div class="col-md-4">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Average</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key=>$user)
                <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$user->user->first_name}}</td>
                <td>{{$user->user->last_name}}</td>
                <td>{{$average->total_count/$user->total}}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>


    </div>
</div>
@endsection

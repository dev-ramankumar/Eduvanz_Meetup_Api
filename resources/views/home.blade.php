@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Participants</div>

                <div class="card-body">
                    <form action="{{route('home')}}" method="get"  autocomplete="off">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" value="{{!empty($_GET["name"])?$_GET["name"]:''}}" name="name" placeholder="{{ __('Name')}}">

                            </div>

                            <div class="form-group col-md-3">

                                <input type="text" class="form-control" value="{{!empty($_GET["locality"])?$_GET["locality"]:''}}" name="locality" placeholder="{{ __('Locality')}}" >

                            </div>
                            <div class="col-md-1 text-center">
                                <button type="submit" class="btn btn-primary"  >Submit</button>
                            </div>
                        </div>

                    </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <td>ID</td>
                              <td>Name</td>
                              <td>Age</td>
                              <td>DOB</td>
                              <td>Profession</td>
                              <td>Locality</td>
                              <td>No of guests</td>
                              <td>Address</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participants as $participant)
                            <tr>
                                <td>{{ (($participants->currentPage() - 1 ) * $participants->perPage() ) + $loop->iteration }}</td>
                                <td>{{$participant->name}}</td>
                                <td>{{$participant->age}}</td>
                                <td>{{ \Carbon\Carbon::parse($participant->dob)->format('d M Y')}}</td>
                                <td>{{$participant->profession == 0 ? 'Employed' : 'Student'}}</td>
                                <td>{{$participant->locality}}</td>
                                <td>{{$participant->no_of_guests}}</td>
                                <td>{{$participant->address}}</td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                    {{ $participants->appends(request()->input())->links() }}

                </div>

            </div>

        </div>
    </div>
</div>
@endsection

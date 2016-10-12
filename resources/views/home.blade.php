@extends('layouts.app')

@section('content')
    <div>
        @include('common.errors')
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="">Home</a></li>
            <li role="presentation"><a href="create_tour">Create New Tour</a></li>
            <li role="presentation"><a href="booking_list">View Bookings</a></li>
        </ul>
    </div>
    @if (count($tours) > 0)
        <table class="table table-bordered">
            <tr>
                <td> Tour Id </td>
                <td> Tour Name </td>
                <td> Action </td>
            </tr>
        @foreach ($tours as $tour)
                <tr>
                    <td>{{ $tour->id }}</td>
                    <td>{{ $tour->name }}</td>
                    <td>
                        <form action="{{url('edit_tour/' . $tour->id)}}" method="GET">
                            <input type="submit" value="edit" id="edit" class="btn btn-default" style="width: 40%; float: left">
                        </form>
                        <form action="{{url('booking/' . $tour->id)}}" method="GET">
                        <input type="submit" value="booking" id="booking" class="btn btn-default" style="width:40%">
                        </form>
                    </td>
                </tr>
        @endforeach
        </table>
    @endif
@endsection

@section('scripts')

@stop
@extends('layouts.app')

@section('content')
    <div>
        @include('common.errors')
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="{{URL::to('')}}">Home</a></li>
        </ul>
    </div>

    <table class="table table-bordered" >
        <tr>
            <td> Booking Id </td>
            <td> Tour </td>
            <td> Tour Date </td>
            <td> Number of Passengers </td>
            <td>Actions </td>
        </tr>
        @if(count($booking)>0)
            @foreach($booking as $each_booking)
                <tr>
                    <td>{{$each_booking->id}}</td>
                    <td>{{$tour->where('id', $each_booking->tour_id)->first()->name}}</td>
                    <td>{{$each_booking->tour_date}}</td>
                    <td>{{$each_booking->passengers()->count()}}</td>
                    <td>
                        <form action="{{url('booking_edit/' . $each_booking->id)}}" method="GET">
                            <input type="submit" value="Edit" class="btn btn-default">
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@stop
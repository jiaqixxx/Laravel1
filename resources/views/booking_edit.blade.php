@extends('layouts.app')

@section('content')
    <form id="passenger" class="form-horizontal">
        <div>
            <div class="form-group">
                <label for="Tour_Name" class="col-sm-2 control-label">Tour Name:</label>
                <div class="col-sm-10">
                    <p class="form-control-static">{{old('name', $tour->name)}}</p>
                </div>
            </div>
            <div class="form-group">
                <label for="Tour_Date" class="col-sm-2 control-label">Tour Date:</label>
                <div class="col-sm-10">
                    <select name="Tour_Date" class="form-control" id="Tour_Date" style="width: 20%">
                        @foreach($tourdate as $enabledate)
                            <option>{{old('status', $enabledate->date)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <p style="float: left; margin-left: 5%; width: 140px; font-size: 120%">Passengers</p>
                <input type="button" id="Add_Passenger" value="Add_Passenger" class="btn btn-default" style="float:right; margin-right: 5%">
            </div>

            <table class="table table-bordered" style="width: 90%; margin-left: auto; margin-right: auto">
                <tr>
                    <td style="vertical-align: top; padding-bottom: 3cm">
                        @foreach($booking->passengers()->get() as $passenger)
                            <div class="passenger_detail1">
                                <table style='background-color: #45b29f' align='center' class="table_num">
                                    <tr>
                                        <td>Passenger#{{$num++}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="passenger[{{$num}}][id]" value="{{old('id', $passenger->id)}}">
                                            <label for='Given_Name'>Given Name: </label>
                                            <input type='text' name="passenger[{{$num}}][Given_Name]" style='width: 200px' value="{{old('Given_Name', $passenger->Given_Name)}}">
                                        </td>
                                        <td>
                                            <label for='Surname'>Surname: </label>
                                            <input type='text' name="passenger[{{$num}}][Surname]" class='passenger' style='width: 200px' value="{{old('Surname', $passenger->Surname)}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for='Email'>Email: </label>
                                            <input type='email' name="passenger[{{$num}}][Email]" class='passenger' style='width: 200px' value="{{old('Email', $passenger->Email)}}">
                                        </td>
                                        <td>
                                            <label for='Mobile'>Mobile: </label>
                                            <input type='text' name="passenger[{{$num}}][Mobile]" class='passenger' style='width: 200px' value="{{old('Mobile', $passenger->Mobile)}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for='Passport'>Passport: </label>
                                            <input type='text' name="passenger[{{$num}}][Passport]" class='passenger' style='width: 200px' value="{{old('Passport', $passenger->Passport)}}">
                                        </td>
                                        <td>
                                            <label for='Date_of_Birth'>Date of Birth: </label>
                                            <input type='date' name="passenger[{{$num}}][Date_of_Birth]" class='passenger' style='width: 200px' value="{{old('Date_of_Birth', $passenger->Date_of_Birth)}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for='Special_Request'>Special Request: </label>
                                            <input type='text' name="passenger[{{$num}}][Special_Request]" class='passenger' style='width: 400px' value="{{old('Special_Request', $passenger->Special_Request)}}">
                                        </td>
                                        <td>
                                            <input type='button' id='remove' value='Remove' style='float: right' class='btn btn-default'>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                            </div>
                        @endforeach
                        <div class="passenger_detail"></div>
                    </td>
                </tr>
            </table>
            <input type="button" value="Cancel" id="cancel" class="btn btn-default" style="margin-left: 5%; float: left">
            <input type="submit" value="Submit" id="submit" class="btn btn-default" style="float: right; margin-right: 5%">
        </div>
    </form>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(e) {
            var num = $('.table_num').length;
            $('#Add_Passenger').click(function (e) {
                e.preventDefault();
                num++;
                $('.passenger_detail').append("<div><table style='background-color: #45b29f; margin-left: auto; margin-right: auto'>" +
                        "<input type='hidden' name='passenger["+(num+1)+"][id]' value='0'>" +
                        "<tr><td>Passenger#" +
                        num +
                        "</td></tr>" +
                        "<tr><td><label for='Given_Name'>Given Name: </label><input type='text' name='passenger["+(num + 1)+"][Given_Name]' style='width: 200px'></td>" +
                        "<td><label for='Surname'>Surname: </label><input type='text' name='passenger["+(num + 1)+"][Surname]' style='width: 200px'></td></tr>" +
                        "<tr><td><label for='Email'>Email: </label><input type='email' name='passenger["+(num + 1)+"][Email]' style='width: 200px'></td>" +
                        "<td><label for='Mobile'>Mobile: </label><input type='text' name='passenger["+(num + 1)+"][Mobile]' style='width: 200px'></td></tr>" +
                        "<tr><td><label for='Passport'>Passport: </label><input type='text' name='passenger["+(num + 1)+"][Passport]' style='width: 200px'></td>" +
                        "<td><label for='Date_of_Birth'>Date of Birth: </label><input type='date' name='passenger["+(num + 1)+"][Date_of_Birth]' style='width: 200px'></td></tr>" +
                        "<tr><td><label for='Special_Request'>Special Request: </label><input type='text' name='passenger["+(num + 1)+"][Special_Request]' style='width: 400px'></td>" +
                        "<td><input type='button' id='remove' value='Remove' style='float: right' class='btn btn-default'></td></tr></table><br></div>");
            });

            $('.passenger_detail').on('click', '#remove', function (e) {
                e.preventDefault();
                $(this).parent().parent().parent().parent().parent().remove();
                num--;
            });

            $('.passenger_detail1').on('click', '#remove', function (e) {
                e.preventDefault();
                $(this).parent().parent().parent().parent().parent().remove();
                num--;
            });

            $('#submit').click(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var url = window.location.href;
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: $('#passenger').serializeArray(),
                    success: function (result) {
                        window.location.href = "{{URL::to('booking_list')}}";
                    }
                });
            });
            $('#cancel').click(function (e) {
                e.preventDefault();
                window.location.href = "{{URL::to('booking_list')}}";
            })
        });
    </script>
@stop
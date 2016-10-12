@extends('layouts.app')

@section('content')
    <form class="form-horizontal">
        <div class="form-group" style="margin-left: 30%">
            <label for="tourname" class="col-sm-2 control-label">Tour Name:</label>
            <div class="col-sm-10">
                <input type="text" name="tourname" id="tourname" class="tour_input form-control" style="width: 30%" value="{{old('name', $tour->name)}}">
            </div>
        </div>
        <div class="form-group" style="margin-left: 30%">
            <label for="ltinerary" class="col-sm-2 control-label">litinerary:</label>
            <div class="col-sm-10">
                <textarea name="ltinerary" id="ltineray" class="tour_input form-control" rows="5" style="width: 30%">{{old('ltinerary', $tour->ltinerary)}}</textarea>
            </div>
        </div>
        <div class="form-group" style="margin-left: 30%">
            <label for="tour_status" class="col-sm-2 control-label">Status:</label>
            <div class="col-sm-10">
                <select name="tour_status" style="width: 30%" class="form-control" id="tour_status">
                    @if($tour->status == 1)
                        <option value="Enable">Enable</option>
                        <option value="Disable">Disable</option>
                    @else
                        <option value="Disable">Disable</option>
                        <option value="Enable">Enable</option>
                    @endif
                </select>
            </div>
        </div>
    <table class="table table-bordered" style="margin-left: 30%; width: 30%">
        <tr>
            <td style="vertical-align: top; padding-bottom: 3cm">
                <div class="input_field">
                    <label for="add_date"> Tour available Dates: </label>
                    <button id="add_date" name="add_date" class="btn btn-default" style="float: right">Add Date</button>
                    <table class="nest_table table table-bordered">
                        @if(count($tourdate) > 0)
                            <tr class='remove_title'>
                                <td>
                                    Date
                                </td>
                                <td>
                                    Action
                                </td>
                            </tr>
                            @for($i = 0; $i < count($tourdate);$i++)
                                <tr>
                                    <td>
                                        <input type="date" class="tourdates form-control" value="{{old('date', $tourdate[$i]->date)}}">
                                    </td>
                                    <td>
                                        <div class="date_status">
                                        @if($tourdate[$i]->status == 1)
                                            <input type="button" id='first' class="datetest btn btn-default" value="Disable">
                                        @else
                                            <input type="button" id='first' class="datetest btn btn-default" value="Enable">
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        @endif
                    </table>
                </div>
            </td>
        </tr>
    </table>
    </form>
    <div id="check"></div>
    <div>
        <form action="{{url('')}}" method="GET">
            <input type="submit" value="Cancel" class="btn btn-default" style="margin-left: 30%; float: left">
        </form>
        <input type="submit" value="Save" id="save" class="btn btn-default" style="display: inline; float: right; margin-right: 40%">
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#add_date').click(function (e) {
                e.preventDefault();
                if ($('.remove_title').length){
                    $('.nest_table').append("<tr><td><input type='date' value='yyyy-mm-dd' class='tourdates form-control'></td><td><button id='remove' class='btn btn-default'>Remove</button></td></tr>");
                }else{
                    $('.nest_table').append("<tr class='remove_title'><td>Date</td><td>Action</td></tr>");
                    $('.nest_table').append("<tr><td><input type='date' value='yyyy-mm-dd' class='tourdates form-control'></td><td><button id='remove' class='btn btn-default'>Remove</button></td></tr>");
                }
            });

            $('.date_status').on('click', '#first', function (e) {
                e.preventDefault();
                if ($(this).val() == "Disable"){
                    $(this).val("Enable");
                }else {
                    $(this).val("Disable");
                }
            });

            $('.nest_table').on('click', '#remove', function (e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            $('#save').click(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var tour_status = $('#tour_status').val();
                if (tour_status == "Enable"){
                    tour_status = 1;
                }else if(tour_status == "Disable"){
                    tour_status = 0;
                }
                var url = window.location.href;
                var datevalues = $('.tourdates').map(function () {
                    return this.value;
                }).get();
                var datestatus = $('.datetest').map(function () {
                    return this.value;
                }).get();
                var tourname = $('#tourname').val();
                var ltineray = $('#ltineray').val();
                var check = true;
                var check1 = true;
                if (datevalues.length > 1){
                    for(var i = 0; i < datevalues.length - 1; i++){
                        for(var j = i + 1; j < datevalues.length; j++){
                            if (datevalues[i].replace(/\-/g,"") == datevalues[j].replace(/\-/g,"")){
                                check = false;
                                break;
                            }
                        }
                    }
                    for (var k = 0; k < datevalues.length; k++){
                        if (datevalues[k] == "yyyy-mm-dd" || datevalues[k] == ""){
                            check1 = false;
                            break;
                        }
                    }
                }
                if (check == false){
                    $('#check').html("<div class='alert alert-danger' role='alert' style='width: 50%; margin-left: auto; margin-right: auto'>Duplicate tour date!</div>");
                }else if(check1 == false){
                    $('#check').html("<div class='alert alert-danger' role='alert' style='width: 50%; margin-left: auto; margin-right: auto'>Please set the tour date!</div>");
                }else{
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {
                            tourstatus: tour_status,
                            datevalues: datevalues,
                            datestatus: datestatus,
                            tourname: tourname,
                            ltineray: ltineray
                        },
                        success: function (result) {
                            window.location.href = "{{URL::to('')}}";
                        }
                    });
                }
            });
        });
    </script>
@stop
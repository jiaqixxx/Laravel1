@extends('layouts.app')

@section('content')
    <div>
        @include('common.errors')
        <form class="form-horizontal">
            <div class="form-group" style="margin-left: 30%">
                <label for="tourname" class="col-sm-2 control-label">Tour Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="tourname" id="tourname" class="form-control" style="width: 30%">
                </div>
            </div>
            <div class="form-group" style="margin-left: 30%">
                <label for="ltinerary" class="col-sm-2 control-label">litinerary:</label>
                <div class="col-sm-10">
                    <textarea name="ltinerary" id="ltineray" class="form-control" rows="5" style="width: 30%"></textarea>
                </div>
            </div>
            <div>
                <table class="table table-bordered" style="margin-left: 30%; width: 30%">
                    <tr>
                        <td style="vertical-align: top; padding-bottom: 3cm">
                            <div class="input_field">
                                <label for="add_date"> Tour available Dates: </label>
                                <button id="add_date" name="add_date" class="btn btn-default" style="float: right">Add Date</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div >
    <div>
        <div id="check"></div>
        <form action="{{url('')}}" method="GET">
            <input type="submit" value="Cancel" class="btn btn-default" style="margin-left: 30%; float: left">
        </form>
        <input type="submit" value="Submit" id="submit" class="btn btn-default" style="display: inline; float: right; margin-right: 40%">
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(e) {
        var num = 0;
        var num1 = 0;
        $('#add_date').one('click',function (e) {
            e.preventDefault();
            $('.input_field').append("<tr class='remove_title'><td>Date</td><td>Action</td></tr>");
            num1++;
        }).click(function (e) {
            e.preventDefault();
            if(num1 == 0){
                $('.input_field').append("<tr class='remove_title'><td>Date</td><td>Action</td></tr>");
                num1++;
            }
            $('.input_field').append("<tr><td><input type='date' value='yyyy-mm-dd' class='tourdates form-control' style='width: auto'></td><td><button id='remove' class='btn btn-default'>Remove</button></td></tr>");
            num++;
        });

        $('.input_field').on('click', '#remove', function (e) {
            e.preventDefault();
            $(this).parent().parent().remove();
            num--;
            if (num == 0){
                $('.remove_title').remove();
                num1--;
            }
        });
        $('#submit').click(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var check = true;
            var check1 = true;
            var tourname = $('#tourname').val();
            var ltinerary = $('#ltineray').val();
            var datevalues = $('.tourdates').map(function () {
                return this.value;
            }).get();
            if (datevalues.length > 1){
                for(var i = 0; i < datevalues.length - 1; i++) {
                    for (var j = i + 1; j < datevalues.length; j++) {
                        if (datevalues[i].replace(/\-/g, "") == datevalues[j].replace(/\-/g, "")) {
                            check = false;
                            break;
                        }
                    }
                }
            }
            if (datevalues.length > 0){
                for (var k = 0; k < datevalues.length; k++){
                    if (datevalues[k] == "yyyy-mm-dd" || datevalues[k] == ""){
                        check1 = false;
                        break;
                    }
                }
            }
            if(!tourname || !ltinerary){
                window.location.href = "{{URL::to('')}}";
            }else if(check == false) {
                $('#check').html("<div class='alert alert-danger' role='alert' style='width: 50%; margin-left: auto; margin-right: auto'>Duplicate tour date!</div>");
            }else if(check1 == false){
                $('#check').html("<div class='alert alert-danger' role='alert' style='width: 50%; margin-left: auto; margin-right: auto'>Please set the tour date!</div>");
            }else{
                $.ajax({
                    type: 'GET',
                    url: "{{URL::to('create_tour')}}",
                    data:{
                        tourname: tourname,
                        ltinerary: ltinerary,
                        datevalues: datevalues
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


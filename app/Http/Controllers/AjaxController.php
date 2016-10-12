<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Passenger;
use DB;
use App\Tour;
use App\Tourdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use SebastianBergmann\Comparator\Book;

class AjaxController extends Controller
{
    public function store(Request $request){
        if ($request->ajax()){
            $tourname = $request->input('tourname');
            $ltinerary = $request->input('ltinerary');
            $tour = new Tour;
            $tour->name = $tourname;
            $tour->ltinerary = $ltinerary;
            $tour->status = 1;
            $tour->save();
            if ($request->has('datevalues')){
                $datevalues = $request->input('datevalues');
                for ($i = 0; $i < count($datevalues); $i++){
                    $tourdate = new Tourdate;
                    $tourdate->tour_id = $tour->id;
                    $tourdate->date = $datevalues[$i];
                    $tourdate->status = 1;
                    $tourdate->save();
                }
            }
        }else{
            return view('/create_tour');
        }
    }

    public function update($id, Request $request){
        if ($request->ajax()){
            $tourstatus = $request->input('tourstatus');
            DB::table('tours')->where('id','=', $id)->update(['status' => $tourstatus]);
            if ($request->has('datevalues')){
                $datevalues = $request->input('datevalues');
                DB::table('tourdates')->where('tour_id', $id)->delete();
                if ($request->has('datestatus')) {
                    $datestatus = $request->input('datestatus');
                    for ($i = 0; $i < count($datevalues); $i++) {
                        $tourdate = new Tourdate;
                        $tourdate->tour_id = $id;
                        $tourdate->date = $datevalues[$i];
                        if ($i < count($datestatus)) {
                            if ($datestatus[$i] == "Enable") {
                                $tourdate->status = 0;
                            } else {
                                $tourdate->status = 1;
                            }
                        }else{
                            $tourdate->status = 1;

                        }
                        $tourdate->save();
                    }
                }else{
                    for ($i = 0; $i < count($datevalues); $i++) {
                        $tourdate = new Tourdate;
                        $tourdate->tour_id = $id;
                        $tourdate->date = $datevalues[$i];
                        $tourdate->status = 1;
                        $tourdate->save();
                    }
                }
            }
            if ($request->has('tourname')){
                $tourname = $request->input('tourname');
                Tour::where('id', $id)->update([
                    'name' => $tourname
                ]);
            }
            if ($request->has('ltineray')){
                $ltineray = $request->input('ltineray');
                Tour::where('id', $id)->update(['ltinerary' => $ltineray]);
            }
        }else{
            $tour = Tour::findOrFail($id);
            $tourdate = DB::table('tourdates')->where('tour_id','=', $id)->get();
            return view('/edit_tour', compact('tour','tourdate'));
        }
    }

    public function booking($id, Request $request){
        if ($request->ajax()){
            if ($request->has('passenger')) {
                $passengers = $request->input('passenger');
                $date_value = $request->input('Tour_Date');
                $booking = new Booking;
                $booking->tour_id = $id;
                $booking->tour_date = $date_value;
                $booking->status = 1;
                $booking->save();
                foreach ($passengers as $passenger) {
                    $passenger = Passenger::create($passenger);
                    $booking->passengers()->save($passenger);
                }
            }
        }else{
            $tour = Tour::findOrFail($id);
            $tourdate = DB::table('tourdates')->where('tour_id','=', $id)->where('status', '=' , 1)->get();
            return view('/booking', compact('tour', 'tourdate'));
        }
    }

    public function booking_list(){
        $booking = Booking::get();
        $tour = Tour::get();
        return view('/bookinglist', compact('booking', 'tour'));
    }

    public function booking_edit($id, Request $request){
        if ($request->ajax()){
            if ($request->has('passenger')) {
                $passengers = $request->input('passenger');
                $date_value = $request->input('Tour_Date');
                Booking::where('id', $id)->update(['tour_date' => $date_value]);
                $passenger_id = array();
                foreach($passengers as $passenger){
                    if ($passenger['id'] == 0){
                        $passenger = Passenger::create($passenger);
                        Booking::find($id)->passengers()->save($passenger);
                        array_push($passenger_id, $passenger['id']);
                    }else{
                        array_push($passenger_id, $passenger['id']);
                        Passenger::where('id', $passenger['id'])->update($passenger);
                    }
                }
                $all_passenger = Booking::find($id)->passengers;
                foreach ($all_passenger as $each_passenger){
                    if (in_array($each_passenger->id, $passenger_id) == false){
                        Booking::find($id)->passengers()->detach($each_passenger);
                    }
                }
            }else{
                Booking::find($id)->passengers()->detach();
            }
        }else{
            $booking = Booking::find($id);
            $tour = Tour::where('id', $booking->tour_id)->first();
            $tourdate = DB::table('tourdates')->where('tour_id','=', $booking->tour_id)->where('status', '=' , 1)->get();
            $num = 1;
            return view('/booking_edit', compact('booking', 'tour', 'tourdate', 'num'));
        }
    }
}
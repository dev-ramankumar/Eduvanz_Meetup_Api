<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;
use App\Http\Resources\ParticipantResource;
use Validator;
use Symfony\Component\HttpFoundation\Response;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resource = Participant::filterParticipant($request)->orderBy('id', 'desc')->paginate(15);
        return ParticipantResource::collection($resource);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate =  Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:255',
            'age' => 'required|min:0|max:128',
            'dob' => 'required|date',
            'profession' => 'required|in:employed,student',
            'locality' => 'required|string|min:1|max:255',
            'no_of_guests' => 'required|in:0,1,2',
            'address' => 'required|string|max:50'
        ]);

        if ($validate->passes()) {
            $createRecord =  Participant::insert([
                'name' => trim($request->name),
                'age' => trim($request->age),
                'dob' => trim($request->dob),
                'profession' => strtolower($request->profession) == "employed" ? 0 : 1,
                'locality' => trim($request->locality),
                'no_of_guests' => $request->no_of_guests,
                'address' => $request->address
            ]);
            if ($createRecord) {
                return response()->json(['status' => Response::HTTP_CREATED, 'message' => "Participant Registered successfully"], Response::HTTP_CREATED);
            }
            return response()->json(['status' => Response::HTTP_BAD_REQUEST, 'message' => Response::$statusTexts[Response::HTTP_BAD_REQUEST]], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
            'error' => $validate->messages()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Participant $participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate =  Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:255',
            'age' => 'required|min:0|max:128',
            'dob' => 'required|date',
            'profession' => 'required|in:employed,student',
            'locality' => 'required|string|min:1|max:255',
            'no_of_guests' => 'required|in:0,1,2',
            'address' => 'required|string|max:50'
        ]);

        if ($validate->passes()) {
            $participant = Participant::where('id', $id)->first();
            if ($participant) {
                $input = $request->all();
                $input['profession'] = $request->profession ? (strtolower($request->profession) == "employed" ? 0 : 1) : $participant->profession;
                $participant->name = $input['name'] ?? $participant->name;
                $participant->age = $input['age'] ?? $participant->age;
                $participant->dob = $input['dob'] ?? $participant->dob;
                $participant->profession = $input['profession'] ?? $participant->profession;
                $participant->locality = $input['locality'] ?? $participant->locality;
                $participant->no_of_guests = $input['no_of_guests'] ?? $participant->no_of_guests;
                $participant->address = $input['address'] ?? $participant->address;
                $participant->save();
                return response()->json(['status' => Response::HTTP_OK, 'message' => "Participant data update successfully"], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                    'error' => ""
                ], Response::HTTP_BAD_REQUEST);
            }
        }
        return response()->json([
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
            'error' => $validate->messages()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

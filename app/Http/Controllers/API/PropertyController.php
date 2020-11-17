<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Answer;
use App\Models\User;
use App\Models\Property;
use App\Repositories\PropertyRepository;


class PropertyController extends Controller
{
    private $properties;

    public function __construct(PropertyRepository $properties)
    {
        $this->properties = $properties;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties= $this->properties->allWith('users');
        if($properties->count())
            return new Answer($properties);
        return new Answer(['ملکی وجود ندارد.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        request instance:
//        {
//            "house_name_number" : "maznadaran",
//            "postcode" : "123",
//            "users" : [
//                {
//                    "id" : 1,
//                    "main_owner" : true
//                },
//                {
//                    "id" : 2,
//                    "main_owner" : false
//                }
//            ]
//        }

        $property=$this->properties->create($request->all());
        foreach($request['users'] as $item)
            $property->users()->attach($item['id'],['main_owner'=>$item['main_owner']]);

        return new Answer(['ملک با موفقیت ثبت شد']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property=$this->properties->findWith($id,'users');
        if($property)
            return new Answer($property);
        return new Answer(['چنین ملکی وجود ندارد.']);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //request instance:
//        {
//            "house_name_number" : "1",
//            "postcode" : "jjj",
//            "users" : [
//                        {
//                            "id" : 1,
//                            "main_owner" : false
//                        },
//                        {
//                            "id" : 2,
//                            "main_owner" : false
//                        },
//                        {
//                            "id" : 3,
//                            "main_owner" : true
//                        }
//            ]
//        }

        $property=$this->properties->find($id);

        if($property){
            $this->properties->update($property,[
                'house_name_number' => $request['house_name_number'],
                'postcode' => $request['postcode']
            ]);

            foreach($request['users'] as $item){
                foreach($item as $userId=>$main_owner)
                    $property->users()->updateExistingPivot($userId, ['main_owner'=>$main_owner]);
            }

            $property->users()->detach($property->users->pluck('id'));
            foreach($request['users'] as $item)
                $property->users()->attach($item['id'],['main_owner'=>$item['main_owner']]);

            return new Answer(['ملک با موفقیت ویرایش شد']);
        }
        return new Answer(['چنین ملکی وجود ندارد.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ($this->properties->delete($id))
            ? new Answer(['ملک با موفقیت حذف شد'])
            : new Answer(['چنین ملکی وجود ندارد.']);

    }
}

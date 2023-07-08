<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomImages;
use App\Models\Room;
class RoomImagesController extends Controller
{
    
    /**
     * Store image
     *
     * @param Request $request
     * @param int $roomId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function storeImage(Request $request,int $roomId){
        
        if($request->file('image')){

            $file= $request->file('image');
            $imageName = time().'.'.$request->image->extension();  
            $file-> move(public_path('Images'), $imageName);
            return RoomImages::create([
                'filename' => $imageName,
                'room_id' => $roomId,
            ]);
        
        

        $file = $request->file('image');

        if ($file != null) {
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
    
            $roomImage = new RoomImages();
            $roomImage->filename = $imageName;
    
            $room = Room::find($roomId);
            $room->images()->save($roomImage);
    
            return $roomImage;
        } else {
            return response()->json(['error' => 'Image is null.']);
        }
    }
       
    
	
}
}

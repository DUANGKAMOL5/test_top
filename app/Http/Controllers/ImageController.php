<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Catalog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Image;
use Illuminate\Support\Facades\File;
class ImageController extends Controller
{
    public function index()
    {
    
        $images = Image::orderBy('created_at', 'desc')->paginate(5);
        $totalSize = Image::sum('size');
        $groupedImages = $images->groupBy('mime');
    
        // ...
    
        return view('image.index', compact('images', 'groupedImages', 'totalSize'));






    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
           
            'image_name.*' => 'mimes:jpeg,png,jpg,gif',
        ]);
    


       $name_gen = hexdec(uniqid());
        $image_files = $request->file('image_name'); 

        $upload_location = 'image/images/';
        $image_files = $request->file('image_name'); 

       

        if ($image_files) {
            foreach ($image_files as $image_name) {
                $img_ext = strtolower($image_name->getClientOriginalExtension());
                $unique_image_name = $name_gen . '_' . rand() . '.' . $img_ext;
                $full_path = $upload_location . $unique_image_name;
        
                // Check if the generated filename already exists in the database
                while (Image::where('image_name', $full_path)->exists()) {
                    $unique_image_name = $name_gen . '_' . rand() . '.' . $img_ext;
                    $full_path = $upload_location . $unique_image_name;
                }


               
                
                // ทำการอัปเดตค่า catalog_id
              


            $image = Image::create([
            'user_id' => Auth::user()->id,
            'catalog_id' => null, 
            'image_name' => $full_path,
            'size' => $image_name->getSize(),
            'mime' => $image_name->getMimeType(),
            'created_at' => Carbon::now(),
        ]);
       
     $image_name->move($upload_location, $unique_image_name);
    
   

       
    }
}
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อยแล้ว");
    }

    public function edit($id)
    {
        $image = Image::findOrFail($id);
        if ($image->user_id != Auth::user()->id) {
            return redirect()->route('image')->with('error', 'You do not have permission to edit this catalog.');
        }
    
        return view('image.edit', compact('image'));
    }
    public function update(Request $request, $id)
    {
        // ค้นหาข้อมูลรูปภาพที่ต้องการแก้ไข
        $image = Image::findOrFail($id);
    
        // ตรวจสอบสิทธิ์การแก้ไข
        if ($image->user_id != Auth::user()->id) {
            return redirect()->route('image')->with('error', 'You do not have permission to edit this image.');
        }
    
        // ตรวจสอบว่าผู้ใช้อัปโหลดรูปภาพใหม่หรือไม่
        if ($request->hasFile('new_image')) {
            $validatedData = $request->validate([
                'new_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // กำหนดเงื่อนไขสำหรับรูปภาพใหม่
            ]);
    
            // ลบรูปภาพเก่า (ถ้ามี)
            if (File::exists($image->image_name)) {
                File::delete($image->image_name);
            }
    
            // อัปโหลดรูปภาพใหม่และบันทึกเป็นชื่อไฟล์ใหม่
            $newImageName = time() . '.' . $validatedData['new_image']->getClientOriginalExtension();
            $validatedData['new_image']->move(public_path('images'), $newImageName);
    
            $image->image_name = 'images/' . $newImageName;
        }
    
        $image->save();
    
        return redirect()->route('image')->with('success', 'Image updated successfully');
    }

    public function delete($id){  
        $image = Image::find($id);
    
        if ($image) {
            $image->images()->delete(); // ลบรูปภาพที่เกี่ยวข้องกับแคตตาล็อก
            $image->delete(); // ลบแคตตาล็อก
    
            return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อยแล้ว");
       
}

    }
}
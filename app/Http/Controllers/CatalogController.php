<?php

namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Catalog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class CatalogController extends Controller

{
    public function index()
    {
        $catalogs = Catalog::paginate(5);
        return view('catalog.index', compact('catalogs'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'catalog_name' => 'required|unique:catalogs|max:255',
            'image_name.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $catalog = new Catalog;
        $catalog->catalog_name = $request->catalog_name;
        $catalog->user_id = Auth::user()->id;
        $catalog->save();
    
        $name_gen = hexdec(uniqid());
        $image_files = $request->file('image_name'); // Array of image files
    
        $upload_location = 'image/images/';
        $image_files = $request->file('image_name'); // Array of image files

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

        // Create the image record in the database

       $user_id =  Auth::user()->id;
        $image = Image::create([
            'user_id' => $user_id,
            'catalog_id' => $catalog->id,
             'image_name' => $full_path,
             'size' => $image_name->getSize(),
              'mime' => $image_name->getMimeType(),
             'created_at' => Carbon::now(),
        ]);
      

        // Move image to upload location
        $image_name->move($upload_location, $unique_image_name);
    }
}
        return redirect()->back()->with('success', "บันทึกข้อมูลเรียบร้อยแล้ว");
    }
    











    public function edit($id)
{
    $catalog = Catalog::findOrFail($id);
    if ($catalog->user_id != Auth::user()->id) {
        return redirect()->route('catalog')->with('error', 'You do not have permission to edit this catalog.');
    }

    return view('catalog.edit', compact('catalog'));
}














public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'catalog_name' => 'required',
    ]);

    $catalog = Catalog::findOrFail($id); 
    if ($catalog->user_id != Auth::user()->id) {
        return redirect()->route('catalog')->with('error', 'You do not have permission to edit this catalog.');
    }

    $catalog->catalog_name = $validatedData['catalog_name'];
    $catalog->save();

    return redirect()->route('catalog')->with('success', 'Catalog updated successfully');
}



public function delete($id){  
    $catalog = Catalog::find($id);

    if ($catalog) {
        $catalog->images()->delete(); // ลบรูปภาพที่เกี่ยวข้องกับแคตตาล็อก
        $catalog->delete(); // ลบแคตตาล็อก

        return redirect()->back()->with('success', "ลบข้อมูลเรียบร้อยแล้ว");
    } else {
        return redirect()->back()->with('error', "ไม่พบข้อมูลที่ต้องการลบ");
    }


}     public function show($id)
  {


    $catalog = Catalog::with(['images' => function ($query) {
        $query->whereIn('mime', ['image/jpeg', 'image/png', 'image/gif']); // ค้นหารูปภาพที่มี MIME type ตรงกับเงื่อนไข
    }])->findOrFail($id);

    return view('catalog.show', compact('catalog'));

    
   // $catalog = Catalog::with('images')->findOrFail($id);

    return view('catalog.show', compact('catalog'));
}

}
    




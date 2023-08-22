<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        สวัสดี, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
           
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                  

                  

                
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                        <form action="{{ route('image.update', ['id' => $image->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="image_name">รูปภาพเดิม</label><br>
                                    <img src="{{ asset($image->image_name) }}" alt="" width="350px" height="350px">
                                </div>
                                <div class="form-group">
                                    <label for="new_image">รูปภาพใหม่</label>
                                    <input type="file" class="form-control" id="new_image" name="new_image" style="max-width: 250px;">
                                </div>

                              

                                <br>
                                <input type="submit" value="บันทึกการแก้ไข" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                















                    
            </div>
        </div>
    </div>
</x-app-layout>

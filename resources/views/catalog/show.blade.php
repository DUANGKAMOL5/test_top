<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif


                    <div class="col-md-4">

         <form action="{{ route('catalog.show', $catalog->id) }}" method="GET" class="mb-3">
            <div class="input-group">
                <select name="mime_filter" class="form-select">
                    <option value="">ทั้งหมด</option>
                    <option value="image/jpeg">JPEG</option>
                    <option value="image/png">PNG</option>
                    <option value="image/gif">GIF</option>
                </select>
                <button type="submit" class="btn btn-primary">ค้นหา</button>
            </div>
        </form>
    </div>






                    <h3>Catalog</h3>
                    <div class="row">

                    @foreach ($catalog->images as $image)
            @if (empty(request('mime_filter')) || $image->mime === request('mime_filter'))
                <div class="col-md-4">
                    <div class="card mb-3">
                    <div style="width: 100%; height: 250px; overflow: hidden;">
                        <img src="{{ asset($image->image_name) }}" alt="Image" class="card-img-top">
                     </div>
                        <div class="card-body">
                            <p class="card-text">ชื่อไฟล์: {{ $image->image_name }}</p>
                            <p class="card-text">ขนาด: {{ $image->size }} bytes</p>
                            <p class="card-text">ประเภท: {{ $image->mime }}</p>

                            
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

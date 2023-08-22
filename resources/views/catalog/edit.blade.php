<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                   
        
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
       
                        <form action="{{ route('catalog.update', ['id' => $catalog->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
        <label for="catalog_name">NAME</label>
        <input type="text" class="form-control" id="catalog_name" name="catalog_name" value="{{ $catalog->catalog_name }}" required>
    </div>
    @error('catalog_name')
        <span class="text-danger my-2">{{ $message }}</span>
    @enderror
    

    <br>
    <input type="submit" value="บันทึกการแก้ไข" class="btn btn-primary">
</form>



                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

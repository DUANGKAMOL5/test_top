<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        สวัสดี, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                  

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">





                        <form action="{{route('addCatalog')}}" method="post" enctype="multipart/form-data">
                                @csrf
                               
                                <div class="form-group">
                                    <label for="catalog_name">Naw catalog</label>
                                    <input type="text" class="form-control" id="catalog_name" name="catalog_name" required>
                                </div>
                                @error('catalog_name')
                                    <span class="text-danger my-2">{{ $message }}</span>
                                @enderror
                                <div class="form-group">
                                <label for="images">Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                                </div>
                                
                                <br>
                                <input type="submit" value="บันทึก" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

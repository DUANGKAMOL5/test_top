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

                    <div class="card">
                        <div class="card-header bg-blue-500 ">Catalogs</div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($catalogs as $row)
                                    <tr>
                                        <td>{{ $catalogs->firstItem() + $loop->index }}</td>
                                        <td>
                                            <a href="{{ route('catalogs.show', ['id' => $row->id]) }}"
                                               class="text-blue-500 hover:underline">{{ $row->catalog_name }}</a>
                                        </td>
                                        <td><a href="{{ url('/catalog/edit/'. $row->id) }}" class="btn btn-primary">Edit</a></td>
                                        <td><a href="{{ url('/catalog/delete/'. $row->id) }}" class="btn btn-danger"
                                               onclick="return confirm('ต้องการลบข้อมูล')">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $catalogs->links() }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-green-500 ">New Catalogs</div>
                        <div class="card-body">
                            <form action="{{ route('addCatalog') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="catalog_name">Catalog Name</label>
                                    <input type="text" class="form-control" id="catalog_name" name="catalog_name" required>
                                    @error('catalog_name')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image_name">Image</label>
                                    <input type="file" class="form-control" id="image_name" name="image_name[]" multiple>
                                    @error('image_name')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
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

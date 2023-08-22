<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            สวัสดี, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="text-right mb-4">
                    <p class="text-lg text-gray-600">Total Image Size: {{ $totalSize }} bytes</p>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-blue-500 ">Image Gallery</div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Images</th>
                                    <th scope="col">MIME Type</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($images as $row)
                                    <tr>
                                        <td>{{ $images->firstItem() + $loop->index }}</td>
                                        <td>
                                            <img src="{{ asset($row->image_name) }}" alt="" class="rounded" width="100px" height="100px">
                                        </td>
                                        <td>{{ $row->mime }}</td>
                                        <td>{{ $row->size }}</td>
                                        <td>{{ $row->created_at }}</td>
                                        <td><a href="{{ url('/image/edit/'. $row->id) }}" class="btn btn-primary">Edit</a></td>
                                        <td><a href="{{ url('/image/delete/'. $row->id) }}" class="btn btn-danger"
                                               onclick="return confirm('ต้องการลบข้อมูล')">Delete</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $images->links() }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-green-500 ">Add New Image</div>

                        <form action="{{ route('addimage') }}" method="post" enctype="multipart/form-data" class="p-4">
                            @csrf

                            <div class="form-group">
                                <label for="image_name">Images</label>
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
</x-app-layout>

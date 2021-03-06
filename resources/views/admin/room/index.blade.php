@extends('layouts.app', ['title' => 'HRI-HOTEL | Room'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  @include('layouts.partials.error')
                  <div class="d-flex justify-content-between">
                    @if(request('query'))
                      <a href="{{ route('admin.room.index') }}" class="btn btn-danger btn-md"><i class="fa fa-arrow-left"></i></a>
                    @else
                      <button type="submit" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i></button>
                    @endif
                      <form action="{{ route('admin.searchroom') }}" method="GET">
                        <div class="input-group">
                          <input class="form-control" id="validationTooltip02" type="search" name="query" placeholder="Search here..." required="">
                          <div class="valid-tooltip">Search</div>
                          <button type="submit" class="btn btn-secondary ml-2"><i class="fa fa-search"></i></button>
                        </div>            
                      </form>
                  </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Floor</th>
                                    <th>Category</th>
                                    <th>Price/Day</th>
                                    <th>Rating</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @forelse ($rooms as $room)
                            <tbody>
                                <tr>
                                    <th>{{ $loop->iteration + $rooms->firstItem() - 1 . '.' }}</th>
                                    <td>{!! $room->RoomStatus !!}</td>
                                    <td>{{ $room->room_code }}</td>
                                    <td>{{ $room->name }}</td>
                                    <td><img src="{{ $room->RoomThumbnail }}" style="width: 60px; height: 60px; object-fit: cover; object-position: center;" alt="thumbnail"></td>
                                    <td>{{ $room->floor }}</td>
                                    <td>{{ $room->category->name }}</td>
                                    <td>{{ "Rp. " . number_format($room->price, 0,',','.') }}</td>
                                    <td>{!! $room->RatingCount !!}</td>
                                    <td>
                                      <a href="{{ route('admin.room.edit', $room->id) }}" style="float: left;" class="mr-1"><i class="fa fa-pencil-square-o" style="color: rgb(0, 241, 12);"></i></a>
                                      <button type="submit" onclick="deleteRoom('{{ $room->id }}')" style="background-color: transparent; border: none;"><i class="icon-trash" style="color: red;"></i></button>     
                                      <form action="{{ route('admin.room.destroy', $room->id) }}" method="post" id="DeleteRoom{{ $room->id }}">
                                        @csrf
                                        @method('DELETE')
                                      </form>
                                    </td>
                                </tr>
                            </tbody>
                            @empty
                                <tbody>
                                  <tr>
                                    <th colspan="10" style="color: red; text-align: center;">Data Empty!</th>
                                  </tr>
                                </tbody>
                            @endforelse
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $rooms->links() }}
                </div>
            </div>
        </div>
    </div>
    {{-- add data modal --}}
    @if(!request('query'))
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel2">Add New Room</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('admin.room.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-form-label" for="room">Room Code:</label>
                        <input class="form-control" type="text" value="{{ $kode }}" name="room_code" id="room" readonly required>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="col-form-label" for="thumbnail">Image:</label>
                        <input class="form-control" type="file" name="thumbnail" id="thumbnail" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="col-form-label" for="name">Name:</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="room name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="col-form-label" for="floor">Floor:</label>
                        <input class="form-control" type="number" name="floor" maxlength="3" id="floor" placeholder="floor" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="col-form-label" for="category_id">Category:</label>
                        <select name="category_id" id="category_id" class="form-control custom-select" required>
                            <option disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="col-form-label" for="price">Price/Day:</label>
                        <input class="form-control" type="text" name="price" id="price" placeholder="price" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                        <label class="col-form-label" for="rating">Rating(nullable):</label>
                          <select name="rating" id="rating" class="form-control custom-select">
                              <option value=""> - </option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                          </select>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-light for-light" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-secondary for-dark" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    @endif
@endsection
@section('script')
    <script>
      function deleteRoom(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "is Removing Room",
                        showConfirmButton: false,
                        timer: 2300,
                        timerProgressBar: true,
                        onOpen: () => {
                            document.getElementById(`DeleteRoom${id}`).submit();
                            Swal.showLoading();
                        }
                    });
                  }
            })
        }
        var rupiah = document.getElementById("price");
        rupiah.addEventListener("keyup", function(e) {
          rupiah.value = formatRupiah(this.value, "Rp. ");
        });
        function formatRupiah(angka, prefix) {
          var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
          if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
          }
          rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
          return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }
    </script>
@endsection
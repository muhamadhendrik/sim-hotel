@extends('layouts.app', ['title' => 'HRI-HOTEL | Manager Account'])
@section('breadcrumb')
    <li class="breadcrumb-item">Manager Account Edit</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.account.register.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @include('admin.account.form-control')
                        <div class="modal-footer">
                            <a href="{{ route('admin.account.boss') }}" class="btn btn-light for-light">Back</a>
                            <a href="{{ route('admin.account.boss') }}" class="btn btn-secondary for-dark">Back</a>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.admin')
@section('title', 'Admin')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Change password</div>
            <div class="panel-body">
                <form action="" method="post"  role="form" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-4">
                    <div class="form-group">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" disabled="" class="form-control" value="{{$auth->email}}">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{$auth->username}}">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Change">
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
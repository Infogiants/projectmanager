@extends('base')

@section('title', 'Account Settings')

@section('main')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cogs text-gray-300"></i> Account Settings </h1>

</div>
<div class="card shadow mb-4">
<div class="card-header">Account Settings</div>
<div class="card-body">
    <div>
        @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif

        @if(session()->get('errors'))
        <div class="alert alert-danger">
            {{ session()->get('errors') }}
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Account Settings</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('saveaccountsetting')}}">
                        @method('PATCH')
                        @csrf
                        @foreach($configurations as $configuration)
                            <div class="form-group">
                                <label for="alert_system_notification">{{$configuration->name}}: <input type="checkbox" class="form-control" name="{{$configuration->path}}" value="{{ $configuration->value }}" {{$configuration->value == "1" ? "checked": ""}} /></label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
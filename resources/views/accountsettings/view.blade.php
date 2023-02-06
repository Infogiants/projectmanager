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
        <form method="post" action="{{ route('saveaccountsetting')}}">
                        @method('PATCH')
                        @csrf
                        @foreach($configurations as $configuration)
                            <div class="form-group">
                                <label for="alert_system_notification">{{$configuration->name}}:
                                    <select class="form-control {{ $errors->has($configuration->path) ? 'is-invalid' : '' }}" id="{{$configuration->path}}" name="{{$configuration->id}}" value="{{ old($configuration->path) }}">
                                        <option value="1" <?php echo ($configuration->user_value == "1" ? "selected": "") ?>>Enabled</option>
                                        <option value="0" <?php echo ($configuration->user_value == "0" ? "selected": "") ?>>Disabled</option>
                                    </select>
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
        </div>
    </div>
</div>
</div>
@endsection
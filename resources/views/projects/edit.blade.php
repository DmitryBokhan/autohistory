@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Project</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('projects.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.update',$project->id) }}" method="POST">
    	@csrf
        @method('PUT')

         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Name:</strong>
		            <input type="text" name="name" value="{{ $project->name }}" class="form-control" placeholder="Name">
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Description:</strong>
		            <textarea class="form-control" style="height:150px" name="description" placeholder="Desctiption">{{ $project->description }}</textarea>
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Balance:</strong>
		            <input type="text" class="form-control" name="balance" value="{{ $project->balance }}" placeholder="Balance">
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                <div class="form-group">
                    <strong>Active:</strong>
                    <select class="form-select" aria-label="Default select example"  name="is_active">
                        <option {{ $project->is_active == false ?'selected': '' }} value="0">false</option>
                        <option {{ $project->is_active == true ?'selected': '' }} value="1">true</option>
                    </select>
                </div>
            </div>
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
		      <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>

    </form>


@endsection

@extends('backend.layout.master')
@section('site-title')
    {{ __('Edit Project') }}
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.project.update', $project->id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="title">{{ __('Project Title') }}</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $project->title }}">
                </div>

                <div class="form-group mb-3">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', strip_tags($project->description)) }}</textarea>
                </div>
                <button class="btn btn-primary" type="submit">{{ __('Update Project') }}</button>
            </form>
        </div>
    </div>
@endsection

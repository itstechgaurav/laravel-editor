@extends('layouts.admin')

@section('nav-body')
    <div class="nav-body ml-3">
        <a href="{{url()->previous()}}" class="btn btn-white btn-s mr-1">Go Back</a>
    </div>
@endsection

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            <div class="card col-6 col-8-md col-10-sm col-12-sm">
                <div class="card-head text-center">
                    <div class="heading-ter">Edit Project</div>
                </div>
                <div class="card-body w-9 mx-a">
                    <form action="" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                        <input spellcheck="false" name="name" value="{{$project->name}}" type="text" class="input-input" placeholder="Project Name">
                            <div class="input-a-anm input-a-anm-center"></div>
                        </div>
                        <div class="form-group">
                        <textarea name="meta" class="textarea" placeholder="Brief Discription About This Project">{{$project->meta}}</textarea>
                        </div>
                        @if(Auth::user()->role_id < 3)
                            <div class="form-group v-center my-3">
                                <span style="margin-right: 1rem !important;">Make Private</span>
                                <label class="button-toggle bg-dark">
                                    <input type="checkbox" name="is_private" {{$project->is_private ? 'checked' : ''}}>
                                    <div class="button-toggle-inner"></div>
                                </label>
                            </div>
                        @endif
                        <div class="form-group d-f space-b" style="flex-wrap: wrap;">
                                <?php $colors = ['prime', 'sec', 'ter', 'warn', 'danger'] ?>
                                @foreach ($project->tags as $tag)
                                    <label class="badge badge-{{$colors[rand(0,4)]}} mb-1 mr-1">
                                    <input type="checkbox" name="tags[]" true-value="{{$tag->id}}" checked class="checkbox text-dark" style="outline: none !important;">
                                    <span class="d-ib mr-1">{{$tag->name}}</span>
                                    </label>
                                @endforeach
                                @foreach ($project->nonSelectedTags as $tag)
                                    <label class="badge badge-{{$colors[rand(0,4)]}} mb-1 mr-1">
                                    <input type="checkbox" name="tags[]" true-value="{{$tag->id}}" class="checkbox text-dark" style="outline: none !important;">
                                    <span class="d-ib mr-1">{{$tag->name}}</span>
                                    </label>
                                @endforeach
                            </div>
                        <div class="form-group text-center">
                            <button class="btn btn-ter ripple">Save Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
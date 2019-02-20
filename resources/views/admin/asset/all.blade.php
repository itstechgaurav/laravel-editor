@extends('layouts.admin')

@section('nav-body')
    <div class="nav-body ml-3">
        <form action="{{route('assets-store', ['project_slug' => $project_slug])}}" id="uploadForm" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <label class="btn btn-white-dark btn-s mr-1 ripple">Select Files
                <input type="file" name="assets[]" id="assetsFiles" class="d-none" multiple>
            </label>
            <input type="submit" class="btn btn-s btn-prime" value="Upload">
        </form>
    </div>
@endsection

<?php $colors = ['prime', 'sec', 'ter', 'warn', 'danger'] ?>

@section('content')
    <div class="class mt-4">
        <div class="row space-a">
            @foreach ($user->assets as $asset)
                <div class="card col-4 my-3 col-6-md col-10-sm col-12-xs">
                    <div class="card-head row v-center px-0">
                        <div class="col-9 mb-0 v-center">
                            <div class="heading-ter">{{$asset->name}}</div>
                        </div>
                        <div class="col-2 mb-0">
                            <div class="dropdown dropdown-white-dark dropdown-icon-hide">
                                    <div class="dropdown-head ion ion-ios-arrow-down"></div>
                                    <div class="dropdown-body" style="top: 100%;right: 0;max-height: auto !important;overflow: hidden !important;">
                                    <div class="dropdown-item">
                                        <input type="text" class="input-input copy-input" value="{{url('')}}/uploads/{{$asset->url}}">
                                        <a class="btn btn-prime btn-s v-center text-white copy tooltip" data-tooltip="Click TO Copy" style="text-decoration: none;">Copy</a>
                                    </div>
                                    <a href="{{route('asset-del-confirm', ['project_slug' => $project_slug, 'url' => $asset->url])}}" class="dropdown-item v-center text-dark" style="text-decoration: none;">
                                        <i class="ion ion-trash-a btn btn-danger btn-s"></i>
                                        <span class="mx-2">
                                            Delete Asset
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row p-0">
                        <div class="w-10 projects-iframe-conteiner">
                            <img src="/uploads/{{$asset->url}}" class="w-10" style="height: 100%;">
                        </div>
                    </div>
                </div>  
            @endforeach  
        </div>
        </div>
    </div>
@endsection
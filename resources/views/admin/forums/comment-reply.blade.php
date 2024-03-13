@extends('admin.layouts.admin-layout')

@section('title', 'Forums Group')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ trans('label.forum_comments_group') }}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('dashboard') }}">{{ trans('label.dashboard') }}</a> </li>
                        <li class="breadcrumb-item active"> <a
                                href="{{ route('forumcomments.index') }}">{{ trans('label.forum_comments_group') }}</a> </li>
                        <li class="breadcrumb-item active">{{ trans('label.admin_reply') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Clients Card --}}
    <div class="col-md-12">
        <div class="card">

            <form class="form" action="{{ route('forumcomments.reply.store') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="{{ encrypt($forumComment->id) }}">
                <div class="card-body">
                    @csrf
                    <div class="form_box">
                        <div class="form_box_inr">
                            <div class="box_title">
                                <h2>{{ trans('label.forums_group') }}</h2>
                            </div>
                            <div class="form_box_info">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="description"
                                                class="form-label"><strong>{{ trans('label.admin_reply') }}</strong>
                                                <span class="text-danger"></span></label>
                                            <textarea name="reply" id="reply" placeholder="Enter Reply On Forum (Optional)" rows="5"
                                                class="form-control {{ $errors->has('reply') ? 'is-invalid' : '' }}">{{ $forumComment->admin_reply ?? '' }}</textarea>
                                            @if ($errors->has('description'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('description') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn form_button">{{ trans('label.Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </section>

@endsection


@section('page-js')

@endsection

@extends('admin.layouts.admin-layout')

@section('title', 'Roles')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{trans('label.Roles')}}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{trans('label.dashboard')}}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('roles') }}">{{trans('label.Roles')}}</a></li>
                        <li class="breadcrumb-item active">{{trans('label.create')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- New Clients add Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Error Message Section --}}
            @if (session()->has('error'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Success Message Section --}}
            @if (session()->has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">

                    <form class="form" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="form_box">
                                <div class="form_box_inr">
                                    <div class="box_title">
                                        <h2>{{trans('label.Role_Details')}}</h2>
                                    </div>
                                    <div class="form_box_info">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="firstname" class="form-label"><strong>{{trans('label.Name')}}</strong><span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                        placeholder="Enter Name">
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>                 
                                        <div class="prmission_box">
                                            <h3><strong>{{trans('label.Permission')}}</strong><span class="text-danger">*</span></h3>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionOne">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                    aria-expanded="false" aria-controls="collapseOne">
                                                                    {{trans('label.Roles')}}
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                                aria-labelledby="headingOne" data-bs-parent="#accordionOne">
                                                                @foreach ($permission->slice(0, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}" class="mr-3">
                                                                            @if ($value->name == 'roles')
                                                                            {{trans('label.view')}}
                                                                            @elseif($value->name == 'roles.create')
                                                                            {{trans('label.Add')}} 
                                                                            @elseif($value->name == 'roles.edit')
                                                                            {{trans('label.Update')}}
                                                                            @else
                                                                            {{trans('label.Delete')}} 
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionTwo">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingTwo">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                                    {{trans('label.Users')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                                aria-labelledby="headingTwo"
                                                                data-bs-parent="#accordionTwo">
                                                                @foreach ($permission->slice(4, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label> 
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'users')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'users.create')
                                                                                    {{trans('label.Add')}} 
                                                                                    @elseif($value->name == 'users.edit')
                                                                                    {{trans('label.Update')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionThree">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingThree">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                                    aria-expanded="false" aria-controls="collapseThree">
                                                                    {{trans('label.Age_Group')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                                aria-labelledby="headingThree"
                                                                data-bs-parent="#accordionThree">
                                                                @foreach ($permission->slice(8, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'age.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'age.create')
                                                                                    {{trans('label.Add')}} 
                                                                                    @elseif($value->name == 'age.edit')
                                                                                    {{trans('label.Update')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionfour">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingfour">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsefour"
                                                                    aria-expanded="false" aria-controls="collapsefour">
                                                                    {{trans('label.Question')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapsefour" class="accordion-collapse collapse"
                                                                aria-labelledby="headingfour"
                                                                data-bs-parent="#accordionfour">
                                                                @foreach ($permission->slice(12, 5) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'question.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'question.create')
                                                                                    {{trans('label.Add')}} 
                                                                                    @elseif($value->name == 'question.edit')
                                                                                    {{trans('label.Update')}}
                                                                                    @elseif($value->name == 'question.optionView')
                                                                                    {{trans('label.Option_View')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionfive">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingfive">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsefive"
                                                                    aria-expanded="false" aria-controls="collapsefive">
                                                                    {{trans('label.news')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapsefive" class="accordion-collapse collapse"
                                                                aria-labelledby="headingfive"
                                                                data-bs-parent="#accordionfive">
                                                                @foreach ($permission->slice(17, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'news.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'news.create')
                                                                                    {{trans('label.Add')}} 
                                                                                    @elseif($value->name == 'news.edit')
                                                                                    {{trans('label.Update')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionsix">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingsix">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsesix"
                                                                    aria-expanded="false" aria-controls="collapsesix">
                                                                    {{trans('label.HealthMix')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapsesix" class="accordion-collapse collapse"
                                                                aria-labelledby="headingsix"
                                                                data-bs-parent="#accordionsix">
                                                                @foreach ($permission->slice(21, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'healthMix.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'healthMix.create')
                                                                                    {{trans('label.Add')}} 
                                                                                    @elseif($value->name == 'healthMix.edit')
                                                                                    {{trans('label.Update')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionSeven">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingSeven">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseSeven"
                                                                    aria-expanded="false" aria-controls="collapseSeven">
                                                                    {{trans('label.posts')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapseSeven" class="accordion-collapse collapse"
                                                                aria-labelledby="headingSeven"
                                                                data-bs-parent="#accordionSeven">
                                                                @foreach ($permission->slice(25, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'posts.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'posts.create')
                                                                                    {{trans('label.Add')}} 
                                                                                    @elseif($value->name == 'posts.edit')
                                                                                    {{trans('label.Update')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionEight">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingEight">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseEight"
                                                                    aria-expanded="false" aria-controls="collapseEight">
                                                                    {{trans('label.Medicine')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapseEight" class="accordion-collapse collapse"
                                                                aria-labelledby="headingEight"
                                                                data-bs-parent="#accordionEight">
                                                                @foreach ($permission->slice(29, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'medicine.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'medicine.create')
                                                                                    {{trans('label.Add')}} 
                                                                                    @elseif($value->name == 'medicine.edit')
                                                                                    {{trans('label.Update')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionNine">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingNine">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseNine"
                                                                    aria-expanded="false" aria-controls="collapseNine">
                                                                    {{trans('label.ailments')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapseNine" class="accordion-collapse collapse"
                                                                aria-labelledby="headingNine"
                                                                data-bs-parent="#accordionNine">
                                                                @foreach ($permission->slice(33, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'ailments.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'ailments.create')
                                                                                    {{trans('label.Add')}} 
                                                                                    @elseif($value->name == 'ailments.edit')
                                                                                    {{trans('label.Update')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionten">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingten">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseten"
                                                                    aria-expanded="false" aria-controls="collapseten">
                                                                    {{trans('label.askquestion')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapseten" class="accordion-collapse collapse"
                                                                aria-labelledby="headingten"
                                                                data-bs-parent="#accordionten">
                                                                @foreach ($permission->slice(37, 3) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'userAskQuestion.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'userAskQuestion.edit')
                                                                                    {{trans('label.reply')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionten">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingten">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseten"
                                                                    aria-expanded="false" aria-controls="collapseten">
                                                                    {{trans('label.askquestion')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapseten" class="accordion-collapse collapse"
                                                                aria-labelledby="headingten"
                                                                data-bs-parent="#accordionten">
                                                                @foreach ($permission->slice(37, 3) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                                value="{{ $value->id }}"
                                                                                class="mr-3">
                                                                                    @if ($value->name == 'userAskQuestion.index')
                                                                                    {{trans('label.view')}}
                                                                                    @elseif($value->name == 'userAskQuestion.edit')
                                                                                    {{trans('label.reply')}}
                                                                                    @else
                                                                                    {{trans('label.Delete')}}
                                                                                    @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordioneleven">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingeleven">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseeleven"
                                                                    aria-expanded="false" aria-controls="collapseeleven">
                                                                    {{trans('label.questionType')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapseeleven" class="accordion-collapse collapse"
                                                                aria-labelledby="headingeleven"
                                                                data-bs-parent="#accordioneleven">
                                                                @foreach ($permission->slice(40, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                            value="{{ $value->id }}"
                                                                            class="mr-3">
                                                                                @if ($value->name == 'questionType.index')
                                                                                {{trans('label.view')}}
                                                                                @elseif($value->name == 'questionType.create')
                                                                                {{trans('label.Add')}} 
                                                                                @elseif($value->name == 'questionType.edit')
                                                                                {{trans('label.Update')}}
                                                                                @else
                                                                                {{trans('label.Delete')}}
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordiontwelve">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingtwelve">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsetwelve"
                                                                    aria-expanded="false" aria-controls="collapsetwelve">
                                                                    {{trans('label.forums')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapsetwelve" class="accordion-collapse collapse"
                                                                aria-labelledby="headingtwelve"
                                                                data-bs-parent="#accordiontwelve">
                                                                @foreach ($permission->slice(44, 4) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                            value="{{ $value->id }}"
                                                                            class="mr-3">
                                                                                @if ($value->name == 'forums.index')
                                                                                {{trans('label.view')}}
                                                                                @elseif($value->name == 'forums.create')
                                                                                {{trans('label.Add')}} 
                                                                                @elseif($value->name == 'forums.edit')
                                                                                {{trans('label.Update')}}
                                                                                @else
                                                                                {{trans('label.Delete')}}
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="accordion" id="accordionthirteen">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingthirteen">
                                                                <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsethirteen"
                                                                    aria-expanded="false" aria-controls="collapsethirteen">
                                                                    {{trans('label.forum_comments')}}   
                                                                </button>
                                                            </h2>
                                                            <div id="collapsethirteen" class="accordion-collapse collapse"
                                                                aria-labelledby="headingthirteen"
                                                                data-bs-parent="#accordionthirteen">
                                                                @foreach ($permission->slice(48, 3) as $value)
                                                                    <div class="accordion-body">
                                                                        <label>
                                                                            <input type="checkbox" name="permission[]"
                                                                            value="{{ $value->id }}"
                                                                            class="mr-3">
                                                                                @if ($value->name == 'forumcomments.index')
                                                                                {{trans('label.view')}}
                                                                                @elseif($value->name == 'forumcomments.reply')
                                                                                {{trans('label.reply')}}
                                                                                @else
                                                                                {{trans('label.Delete')}}
                                                                                @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn form_button">{{ trans('label.Save')}}</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

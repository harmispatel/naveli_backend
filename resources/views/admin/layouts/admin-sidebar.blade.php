@php

    $currentRouteName = Route::currentRouteName();
    $isCollQuickQuestion = !in_array($currentRouteName, [
        'questionType.index',
        'questionType.create',
        'questionType.edit',
        'question.index',
        'question.create',
        'question.edit',
        'question.optionView',
    ]);
    $isCollForum = !in_array($currentRouteName, [
        'forums.index',
        'forums.create',
        'forums.edit',
        'forumcomments.index',
        'forumcomments.reply',
    ]);
    $isCollSettings = !in_array($currentRouteName, [
        'roles',
        'roles.create',
        'roles.edit',
        'notification',
        'generalSetting',
        'ContentUpload',
    ]); 
    $isCollAllAboutPeriods = !in_array($currentRouteName, [
        'aap.category.index',
        'aap.category.create',
        'aap.category.edit',
        'aap.posts.index',
        'aap.posts.create',
        'aap.posts.edit',
    ]);
@endphp

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link {{ $currentRouteName == 'dashboard' ? 'active-tab' : '' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid {{ $currentRouteName == 'dashboard' ? 'icon-tab' : '' }}"></i>
                <span>{{ trans('label.dashboard') }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('home.index') }}"
                class="nav-link {{ in_array($currentRouteName, ['home.index', 'home.create']) ? 'active-tab' : '' }}">
                <i
                    class="bi bi-house {{ in_array($currentRouteName, ['home.index', 'home.create']) ? 'icon-tab' : '' }}"></i>
                <span>{{ trans('label.home') }}</span>
            </a>
        </li>

        {{-- Age Group --}}
        <!-- @can('age.index')
            <li class="nav-item">
                <a class="nav-link {{ in_array($currentRouteName, ['age.index', 'age.create', 'age.edit']) ? 'active-tab' : '' }}"
                    href="{{ route('age.index') }}">
                    <i
                        class="bi bi-emoji-expressionless-fill {{ in_array($currentRouteName, ['age.index', 'age.create', 'age.edit']) ? 'icon-tab' : '' }}"></i>
                    <span>{{ trans('label.Age_Group') }}</span>
                </a>
            </li>
        @endcan -->

        {{-- festival --}}
        @can('festival.index')
            <li class="nav-item">
                <a href="{{ route('festival.index') }}"
                    class="nav-link {{ in_array($currentRouteName, ['festival.index', 'festival.create', 'festival.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="bi bi-tree {{ in_array($currentRouteName, ['festival.index', 'festival.create', 'festival.edit']) ? 'icon-tab' : '' }}"></i>
                    <span>{{ trans('label.festival') }}</span>
                </a>
            </li>
        @endcan

        {{-- Users --}}
        @can('users')
            <li class="nav-item">
                <a href="{{ route('users') }}"
                    class="nav-link {{ in_array($currentRouteName, ['users', 'users.create', 'users.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="fa-solid fa-users {{ in_array($currentRouteName, ['users', 'users.create', 'users.edit']) ? 'icon-tab' : '' }}"></i>
                    <span>{{ trans('label.Users') }}</span>
                </a>
            </li>
        @endcan

        {{-- Ask Your Question --}}
        @can('userAskQuestion.index')
            <li class="nav-item">
                <a href="{{ route('userAskQuestion.index') }}"
                    class="nav-link {{ in_array($currentRouteName, ['userAskQuestion.index', 'userAskQuestion.create', 'userAskQuestion.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="fa-solid fa-person-circle-question {{ in_array($currentRouteName, ['userAskQuestion.index', 'userAskQuestion.create', 'userAskQuestion.edit']) ? 'icon-tab' : '' }}">
                    </i>
                    <span>{{ trans('label.askquestion') }}</span>
                </a>
            </li>
        @endcan


        {{-- Quick Questions --}}
        @canany(['questionType.index', 'question.index'])
            <li class="nav-item">
                <a class="nav-link {{ $isCollQuickQuestion ? 'collapsed' : '' }} {{ $isCollQuickQuestion ? '' : 'active-tab' }}"
                    data-bs-target="#question-nav" data-bs-toggle="collapse" href="#"
                    aria-expanded="{{ !$isCollQuickQuestion }}">
                    <i class="bi bi-question-circle {{ !$isCollQuickQuestion ? 'icon-tab' : '' }}"></i>
                    <span>{{ trans('label.quick_question') }}</span>
                    <i class="bi bi-chevron-down ms-auto {{ !$isCollQuickQuestion ? 'icon-tab' : '' }}"></i>
                </a>
                <ul id="question-nav" class="nav-content sidebar-ul collapse {{ !$isCollQuickQuestion ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">

                    {{-- Question Type --}}
                    @can('questionType.index')
                        <li>
                            <a href="{{ route('questionType.index') }}"
                                class="{{ in_array($currentRouteName, ['questionType.index', 'questionType.create', 'questionType.edit']) ? 'active-tab' : '' }}">
                                <i
                                    class="bi bi-gear-fill {{ in_array($currentRouteName, ['questionType.index', 'questionType.create', 'questionType.edit']) ? 'icon-tab' : '' }}"></i>
                                <span>{{ trans('label.questionType') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Questions --}}
                    @can('question.index')
                        <li class="nav-item">
                            <a href="{{ route('question.index') }}"
                                class="{{ in_array($currentRouteName, ['question.index', 'question.create', 'question.edit', 'question.optionView']) ? 'active-tab' : '' }}">
                                <i
                                    class="bi bi-gear-fill {{ in_array($currentRouteName, ['question.index', 'question.create', 'question.edit', 'question.optionView']) ? 'icon-tab' : '' }}"></i>
                                <span>{{ trans('label.Question') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- Forums --}}
        @canany(['forums.index', 'forumcomments.index'])
            <li class="nav-item">
                <a class="nav-link {{ $isCollForum ? 'collapsed' : '' }} {{ $isCollForum ? '' : 'active-tab' }}"
                    data-bs-target="#forums-nav" data-bs-toggle="collapse" href="#"
                    aria-expanded="{{ !$isCollForum }}">
                    <i class="bi bi-book-fill {{ !$isCollForum ? 'icon-tab' : '' }}"></i>
                    <span>{{ trans('label.forums') }}</span>
                    <i class="bi bi-chevron-down ms-auto {{ !$isCollForum ? 'icon-tab' : '' }}"></i>
                </a>
                <ul id="forums-nav" class="nav-content sidebar-ul collapse {{ !$isCollForum ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">

                    {{-- Forums --}}
                    @can('forums.index')
                        <li>
                            <a href="{{ route('forums.index') }}"
                                class="{{ in_array($currentRouteName, ['forums.index', 'forums.create', 'forums.edit']) ? 'active-tab' : '' }}">
                                <i
                                    class="bi bi-gear-fill {{ in_array($currentRouteName, ['forums.index', 'forums.create', 'forums.edit']) ? 'icon-tab' : '' }}"></i>
                                <span>{{ trans('label.forums') }}</span>
                            </a>
                        </li>
                    @endcan

                    {{-- Forum Comment --}}
                    @can('forumcomments.index')
                        <li class="nav-item">
                            <a href="{{ route('forumcomments.index') }}"
                                class="{{ in_array($currentRouteName, ['forumcomments.index', 'forumcomments.reply']) ? 'active-tab' : '' }}">
                                <i
                                    class="bi bi-chat {{ in_array($currentRouteName, ['forumcomments.index', 'forumcomments.reply']) ? 'icon-tab' : '' }}"></i>
                                <span>{{ trans('label.forum_comments') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        {{-- All About Periods --}}
        <!-- <li class="nav-item">
                <a class="nav-link {{ $isCollAllAboutPeriods ? 'collapsed' : '' }} {{ $isCollAllAboutPeriods ? '' : 'active-tab' }}" data-bs-target="#all-about-periods-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ !$isCollForum }}">
                    <i class="bi bi-file-text-fill {{ !$isCollAllAboutPeriods ? 'icon-tab' : '' }}"></i>
                    <span>{{ trans('label.all_about_periods') }}</span>
                    <i class="bi bi-chevron-down ms-auto {{ !$isCollAllAboutPeriods ? 'icon-tab' : '' }}"></i>
                </a>
                <ul id="all-about-periods-nav" class="nav-content sidebar-ul collapse {{ !$isCollAllAboutPeriods ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

                    {{-- periods posts --}}
                        <li class="nav-item">
                            <a href="{{ route('aap.posts.index') }}" class="{{ in_array($currentRouteName, ['aap.posts.index', 'aap.posts.create', 'aap.posts.edit']) ? 'active-tab' : '' }}">
                                <i class="bi bi-gear-fill {{ in_array($currentRouteName, ['aap.posts.index', 'aap.posts.create', 'aap.posts.edit']) ? 'icon-tab' : '' }}"></i>
                                <span>{{ trans('label.posts') }}</span>
                            </a>
                        </li>


                    {{-- All About periods category

                        <li class="nav-item">
                            <a href="{{ route('aap.category.index') }}" class="{{ (in_array($currentRouteName, ['aap.category.index', 'aap.category.create','aap.category.edit'])) ? 'active-tab' : '' }}">
                                <i class="bi bi-chat {{ (in_array($currentRouteName,['aap.category.index', 'aap.category.create','aap.category.edit'])) ? 'icon-tab' : '' }}"></i>
                                <span>{{ trans('label.forums_category') }}</span>
                            </a>
                        </li>
                    --}}
                </ul>
            </li> -->
        @can('aap.posts.index')
            <li class="nav-item">
                <a href="{{ route('aap.posts.index') }}"
                    class="nav-link {{ in_array($currentRouteName, ['aap.posts.index', 'aap.posts.create', 'aap.posts.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="fa-solid fa-seedling {{ in_array($currentRouteName, ['aap.posts.index', 'aap.posts.create', 'aap.posts.edit']) ? 'active-tab' : '' }}"></i>
                    <span>{{ trans('label.all_about_periods') }}</span>
                </a>
            </li>
        @endcan

        {{-- Woman in News --}}
        @can('woman-in-news.index')
            <li class="nav-item">
                <a href="{{ route('woman-in-news.index') }}"
                    class="nav-link {{ in_array($currentRouteName, ['woman-in-news.index', 'woman-in-news.create', 'woman-in-news.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="bi bi-newspaper {{ in_array($currentRouteName, ['woman-in-news.index', 'woman-in-news.create', 'woman-in-news.edit']) ? 'active-tab' : '' }}">
                    </i>
                    <span>{{ trans('label.news') }}</span>
                </a>
            </li>
        @endcan

        {{-- Health profile --}}

        <li class="nav-item">
            <a href="{{ route('healthProfile') }}"
                class="nav-link {{ in_array($currentRouteName, ['healthProfile','healthProfile.users']) ? 'active-tab' : '' }}">
                <i
                    class="fa-solid fa-heart-pulse {{ in_array($currentRouteName, ['healthProfile','healthProfile.users']) ? 'active-tab' : '' }}">
                </i>
                <span>{{ trans('label.healthProfile') }}</span>
            </a>
        </li>


        {{-- Health Mix --}}
        @can('healthMix.index')
            <li class="nav-item">
                <a href="{{ route('healthMix.index') }}"
                    class="nav-link {{ in_array($currentRouteName, ['healthMix.index', 'healthMix.create', 'healthMix.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="fa-solid fa-hand-holding-heart {{ in_array($currentRouteName, ['healthMix.index', 'healthMix.create', 'healthMix.edit']) ? 'active-tab' : '' }}">
                    </i>
                    <span>{{ trans('label.HealthMix') }}</span>
                </a>
            </li>
        @endcan

        {{-- Posts --}}
        @can('posts.index')
            <li class="nav-item">
                <a href="{{ route('posts.index') }}"
                    class="nav-link {{ in_array($currentRouteName, ['posts.index', 'posts.create', 'posts.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="bi bi-calendar2-heart {{ in_array($currentRouteName, ['posts.index', 'posts.create', 'posts.edit']) ? 'active-tab' : '' }}"></i>
                    <span>{{ trans('label.posts') }}</span>
                </a>
            </li>
        @endcan

        {{-- Medicine --}}
        @can('medicine.index')
            <li class="nav-item">
                <a href="{{ route('medicine.index') }}"
                    class="nav-link {{ in_array($currentRouteName, ['medicine.index', 'medicine.create', 'medicine.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="fa-solid fa-capsules {{ in_array($currentRouteName, ['medicine.index', 'medicine.create', 'medicine.edit']) ? 'active-tab' : '' }}"></i>
                    <span>{{ trans('label.Medicine') }}</span>
                </a>
            </li>
        @endcan

        {{-- Alignment --}}
        @can('ailments.index')
            <li class="nav-item">
                <a href="{{ route('ailments.index') }}"
                    class="nav-link {{ in_array($currentRouteName, ['ailments.index', 'ailments.create', 'ailments.edit']) ? 'active-tab' : '' }}">
                    <i
                        class="bi bi-lungs-fill {{ in_array($currentRouteName, ['ailments.index', 'ailments.create', 'ailments.edit']) ? 'active-tab' : '' }}"></i>
                    <span>{{ trans('label.ailments') }}</span>
                </a>
            </li>
        @endcan

        {{-- Settings --}}
        @if (auth()->user()->role_id == 1)

            @canany(['roles', 'notification', 'generalSetting'])
                <li class="nav-item">
                    <a class="nav-link {{ $isCollSettings ? 'collapsed' : '' }} {{ $isCollSettings ? '' : 'active-tab' }}"
                        data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#"
                        aria-expanded="{{ !$isCollSettings }}">
                        <i class="bi bi-gear-fill {{ !$isCollSettings ? 'icon-tab' : '' }}"></i>
                        <span>{{ trans('label.Setting') }}</span>
                        <i class="bi bi-chevron-down ms-auto {{ !$isCollSettings ? 'icon-tab' : '' }}"></i>
                    </a>
                    <ul id="setting-nav" class="nav-content sidebar-ul collapse {{ !$isCollSettings ? 'show' : '' }}"
                        data-bs-parent="#sidebar-nav">

                        {{-- Roles --}}
                        @can('roles')
                            <li>
                                <a href="{{ route('roles') }}"
                                    class="{{ in_array($currentRouteName, ['roles', 'roles.create', 'roles.edit']) ? 'active-tab' : '' }}">
                                    <i
                                        class="bi bi-gear-fill {{ in_array($currentRouteName, ['roles', 'roles.create', 'roles.edit']) ? 'icon-tab' : '' }}"></i>
                                    <span>{{ trans('label.Roles') }}</span>
                                </a>
                            </li>
                        @endcan

                        {{-- Notification --}}
                        {{-- @can('notification') --}}
                        <li class="nav-item">
                            <a class="nav-link {{ $currentRouteName == 'notification' ? 'active-tab' : '' }}"
                                href="{{ route('notification') }}">
                                <i
                                    class="bi bi-gear-fill {{ $currentRouteName == 'notification' ? 'icon-tab' : '' }}"></i>
                                <span>{{ trans('label.notification') }}</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- General Settings --}}
                        {{-- @can('generalSetting') --}}
                        <li class="nav-item">
                            <a href="{{ route('generalSetting') }}"
                                class="nav-link {{ $currentRouteName == 'generalSetting' ? 'active-tab' : '' }}">
                                <i
                                    class="bi bi-gear-fill {{ $currentRouteName == 'generalSetting' ? 'icon-tab' : '' }}"></i>
                                <span>{{ trans('label.generalSetting') }}</span>
                            </a>
                        </li>
                        {{-- @endcan --}}



                    </ul>
                </li>
            @endcanany

        @endif

    </ul>

</aside>
<!-- End Sidebar-->

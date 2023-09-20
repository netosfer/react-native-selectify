<div class="sidebar">
    <div class="sidebar-widget">
        <h3 class="sidebar-widget-title">{{ __('frontend.other_actions') }}</h3>
        <ul class="category-list-one list-style">
            @if(Auth::user()->is_admin)
            <li><a href="{{ route('admin.dashboard') }}">
                    <ion-icon
                        name="arrow-forward-circle-outline"></ion-icon>{{ __('frontend.admin_panel') }}
                </a></li>
            @endif
            <li><a href="{{ route('auth.dashboard') }}">
                    <ion-icon
                        name="arrow-forward-circle-outline"></ion-icon>{{ __('frontend.my_appointments') }}
                </a></li>
            <li><a href="{{ route('auth.informations') }}">
                    <ion-icon
                        name="arrow-forward-circle-outline"></ion-icon>{{ __('frontend.personal_informations') }}
                </a></li>
            <li><a href="{{ route('auth.logout') }}" class="text-danger">
                    <ion-icon
                        name="arrow-forward-circle-outline"></ion-icon>{{ __('frontend.logout') }}
                </a></li>
        </ul>
    </div>
    @include('blocks.online_approve')
</div>

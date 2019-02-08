<div class="bg-white">
    <div class="row space-b p-1">
        <div class="col-2 v-center m-0">
            <?php $usr = Auth::user() ?>
            <img src="{{'/uploads/' . $usr->profile->image}}" width="20" alt="">
        </div>
        <div class="col-10 v-center m-0">
        <h2 class="heading-ter mute" style="font-size: 1.6rem;">{{Auth::user()->name}}</h2>
        </div>
    </div>
</div>
<div class="admin-nav text-white">
    @if($usr->role_id < 2)
        <a href="{{ route('admin-dash') }}" class="admin-nav-item link link-white text-white">Dashboard</a>
        <a href="{{ route('roles') }}" class="admin-nav-item link link-white text-white">Roles</a>
        <a href="{{ route('tags') }}" class="admin-nav-item link link-white text-white">Tags</a>
        <a href="{{ route('users') }}" class="admin-nav-item link link-white text-white">Users</a>
    @endif
    <a href="{{ route('proj') }}" class="admin-nav-item link link-white text-white">Projects</a>
    <a href="{{ route('profile') }}" class="admin-nav-item link link-white text-white">Profile</a>
    <a class="admin-nav-item link link-white text-white" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
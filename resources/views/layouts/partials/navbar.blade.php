<div class="page-header">
    <div class="header-wrapper row m-0">
        <form class="form-inline search-full" action="#" method="get">
            <div class="form-group w-100">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                            placeholder="Search Cuba .." name="q" title="" autofocus>
                        <div class="spinner-border Typeahead-spinner" role="status"><span
                                class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                    </div>
                    <div class="Typeahead-menu"></div>
                </div>
            </div>
        </form>
        <div class="header-logo-wrapper">
            <div class="logo-wrapper">
                <a href="index.html"><img class="img-fluid" src="{{ asset('assets/images/logo/logoweb.png') }}"
                        alt="logowebsite"></a>
            </div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="sliders"></i></div>
        </div>
        <div class="left-header col horizontal-wrapper pl-0">
            <ul class="horizontal-menu">
            </ul>
        </div>
        <div class="nav-right col-8 pull-right right-header p-0">
            <ul class="nav-menus">
                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>
                <li class="maximize"><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                            data-feather="maximize"></i></a></li>
                <li class="profile-nav onhover-dropdown p-0 mr-0">
                    <div class="media profile-media">
                        <div class="avatars">
                            <div class="avatar">
                                @empty(auth()->user()->avatar)
                                    <img class="rounded-circle" src="{{ asset('assets/images/avatar/avatar-default.png') }}" width="50" alt="avatar">
                                @else
                                    <img class="rounded-circle" src="{{ auth()->user()->ImgProfile }}" style="width: 50px; height: 50px; object-fit: cover; object-position: top;" alt="avatar">
                                @endempty
                                <div class="status"></div>
                            </div>
                        </div>
                        <div class="media-body"><span>{{ auth()->user()->name }}</span>
                            <p class="mb-0 font-roboto">
                                @role('admin') Admin @endrole 
                                @role('customer') Customer @endrole 
                                @role('boss') Manager @endrole 
                            <i class="middle fa fa-angle-down"></i></p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="{{ route('profile.setting') }}" class="active"><i
                                    data-feather="user"></i><span>My Profile</span></a></li>
                        <li><a onclick="logout()"><i data-feather="log-in"> </i></i><span>Log Out</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- modal logout --}}
{{-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message Information!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to exit the application? if yes click "Logout".</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Kembali</button>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div> --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>
<script>
    function logout()
    {
        Swal.fire({
            title: 'Message Information!',
            text: 'Are you sure you want to exit the application?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Logout...",
                        showConfirmButton: false,
                        timer: 2300,
                        timerProgressBar: true,
                        onOpen: () => {
                            document.getElementById('logout-form').submit();
                            Swal.showLoading();
                        }
                    });
                }
        })
    }
</script>

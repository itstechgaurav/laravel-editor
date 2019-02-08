@extends('layouts.main', ['title' => 'Epic Home Page'])

@section('seo')
    <meta name="description" content="This Page is the home page or main page of this site used to describe the site app and it's features also used For demo">
@endsection

@section('content')
<div id="editor-demo-container" class="p-2-md p-0-sm">
        <div class="editor-demo">
            <editor v-bind:demo="true"></editor>
        </div>
    </div>
    <div id="features-section" class="class">
        <h2 class="heading-sec d-b text-white text-center mb-5">Features</h2>
        <div class="class">
            <div class="row space-e">
                <div class="col-3 col-4-md col-6-sm col-12-xs">
                    <div class="card">
                        <div class="card-body f-card">
                            <div class="f-icon-outter">
                                <div class="f-icon">
                                    <i class="ion ion-ios-world-outline text-prime"></i>
                                </div>
                            </div>
                            <h3 class="heading-ter my-2 d-b text-center">
                                Web
                            </h3>
                            <p class="mute text-dark">
                                The Editor Who knows how The Web Works , also very intelligent Feature.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-4-md col-6-sm col-12-xs">
                    <div class="card">
                        <div class="card-body f-card">
                            <div class="f-icon-outter">
                                <div class="f-icon">
                                    <i class="ion ion-android-cloud-circle text-sec"></i>
                                </div>
                            </div>
                            <h3 class="heading-ter my-2 d-b text-center">
                                Cloud
                            </h3>
                            <p class="mute text-dark">
                                The Code You write always Stored in cloud so you can access the code anywhere.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-4-md col-6-sm col-12-xs">
                    <div class="card">
                        <div class="card-body f-card">
                            <div class="f-icon-outter">
                                <div class="f-icon">
                                    <i class="ion ion-ios-grid-view-outline text-ter"></i>
                                </div>
                            </div>
                            <h3 class="heading-ter my-2 d-b text-center">
                               Multiple Views
                            </h3>
                            <p class="mute text-dark">
                                Boring with one view. but now you don't have to worry about it.
                                 we cover all thing for you so you can concentrate on only on your project.
                                 we have 6 views you can change these from settings tab.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-4-md col-6-sm col-12-xs">
                    <div class="card">
                        <div class="card-body f-card">
                            <div class="f-icon-outter">
                                <div class="f-icon">
                                    <i class="ion ion-flash text-warn"></i>
                                </div>
                            </div>
                            <h3 class="heading-ter my-2 d-b text-center">
                                Fast
                            </h3>
                            <p class="mute text-dark">
                                The Faster your editor is the faster you can Build.
                                And this is the editor you were waiting for.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-4-md col-6-sm col-12-xs">
                    <div class="card">
                        <div class="card-body f-card">
                            <div class="f-icon-outter">
                                <div class="f-icon">
                                    <i class="ion ion-ios-eye-outline text-danger"></i>
                                </div>
                            </div>
                            <h3 class="heading-ter my-2 d-b text-center">
                                Live Preview
                            </h3>
                            <p class="mute text-dark">
                                now You Don't Have to refresh your page every time you write.
                                Because you can preview what you write in real time.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-4-md col-6-sm col-12-xs">
                    <div class="card">
                        <div class="card-body f-card">
                            <div class="f-icon-outter">
                                <div class="f-icon">
                                    <i class="ion ion-tshirt-outline text-dark"></i>
                                </div>
                            </div>
                            <h3 class="heading-ter my-2 d-b text-center">
                                Themes
                            </h3>
                            <p class="mute text-dark">
                                Support multiple themes you can change themes whenever you want.
                                just navigate to settings tab and select you theme.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="user-section">
        <h1 class="my-3 d-b text-center text-white heading-sec">Creator</h1>
        <div class="class">
            <div class="row space-a">
                <div class="card col-6 col-8-md col-10-sm col-12-xs">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-3 col-12-sm v-center text-center">
                                <div class="user-img mx-a-sm"></div>
                            </div>
                            <div class="col-9 col-12-sm">
                                <h2 class="d-b my-2 heading-sec user-name text-prime">Gaurav BHardwaj</h2>
                                <p class="mute mb-2 text-justify">
                                    The Things i do , Make Diffrence.
                                    Because i do web work for passion. 
                                    Don't Know What You Are Thinking But,
                                     i do know some day these things will make diffrence for everyone.
                                </p>
                                <h4 class="d-b mt-3 heading-ter text-dark mute text-center">Follow Me On</h4>
                                <div class="class p-0 mt-4 text-center">
                                    <a href="" class="link mr-2 text-upr text-ter link-dark mb-2">Facebook</a>
                                    <a href="" class="link mr-2 text-upr text-ter link-dark mb-2">Twitter</a>
                                    <a href="" class="link mr-2 text-upr text-ter link-dark mb-2">Instagram</a>
                                    <a href="" class="link mr-2 text-upr text-ter link-dark mb-2">Slack</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer-section">
        <div class="text-white text-center">
            Made With <i class="ion ion-heart text-danger"></i> By Gaurav Bhardwaj
        </div>
    </div>
@endsection
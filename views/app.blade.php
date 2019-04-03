<!DOCTYPE html>
<html lang="en" data-ng-app="PatchChat">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @if (array_key_exists('title', View::getSections()))        
        <title>@yield('title', 'Community Driven') - PatchChat</title>
        @else
        <title>@yield('pagetitle', 'Community Driven') - PatchChat</title>
        @endif
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href='//fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">        
        <link href='//api.tiles.mapbox.com/mapbox.js/v2.2.0/mapbox.css' rel='stylesheet' />
        @yield('headerscripts')
        <link rel="stylesheet" href="//cdn.muut.com/1/moot.css">

        <link rel="alternate" hreflang="en-us" href="http://www.patchchat.us/{{Request::path()}}" />
        <link rel="alternate" hreflang="en-ca" href="http://www.patchchat.ca/{{Request::path()}}" />
        <link rel="alternate" hreflang="en-ru" href="http://www.patchchat.ru/{{Request::path()}}" />
        <link rel="alternate" hreflang="en-in" href="http://www.patchchat.in/{{Request::path()}}" />
        
        @if(!Config::get("app.debug"))
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');        
          ga('create', 'UA-65996079-1', 'auto');
          ga('send', 'pageview');        
        </script> 
        @endif
    </head>
    <body class="locale-{{ App::getLocale() }}" data-spy="scroll" data-target="#inner-nav">
        @if(!Config::get("app.debug"))
        <!-- Google Tag Manager --> 
        <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NZTV4H" 
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> 
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': 
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], 
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); 
        })(window,document,'script','dataLayer','GTM-NZTV4H');</script> 
        <!-- End Google Tag Manager --> 
        @endif
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="brand-logo" src="<?= asset('img/patchchat-logo.png') ?>" title="PatchChat"> 
                        PatchChat
                        <small>Connecting men and women working in the resource industry.</small>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::check())
                        <li class="hidden-sm hidden-xs hidden-md"><a href="{{ url('/home') }}">Dashboard</a></li>
                        @else
                        <li class="hidden-sm hidden-xs hidden-md"><a href="{{ url('/') }}">Home</a></li>                        
                        @endif
                        
                        <li><a href="{{ route('map') }}">Live Global Map</a></li>
                        
                        <?php /*?>@if (Auth::check() && Auth::user()->hasRole("jobseeker"))
                        <li><a href="{{ url('/applications') }}">Your Applications</a></li>                        
                        @elseif (Auth::check() && Auth::user()->hasRole("employer"))
                        <li><a href="{{ url('/jobs') }}">Your Jobs</a></li>                       
                        @endif*/?>
                        @if (!Auth::check())
                        <li><a href="{{ url('/auth/login') }}">Login</a></li>
                        <li><a href="{{ url('/auth/register') }}">Register</a></li>
                        @else                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }}<span class="caret"></span></a>
                                
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/user/profile') }}">Update Profile</a></li>
                                <li><a href="{{ url('/user/password') }}">Change Password</a></li>
                            </ul>
                        </li>

                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        @endif
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="sprite {{ App::GetLocale() }}-small"></span><span class="caret"></span></a>
                                
                            <ul class="dropdown-menu" role="menu">
                                <li><a rel="alternate" hreflang="en-us" href="http://www.patchchat.us/{{Request::path()}}"><span class="sprite en_us-small"></span> <span class="country-label">USA</span></a></li>
                                <li><a rel="alternate" hreflang="en-ca" href="http://www.patchchat.ca/{{Request::path()}}"><span class="sprite en_ca-small"></span> <span class="country-label">Canada</span></a></li>
                                <li><a rel="alternate" hreflang="en-in" href="http://www.patchchat.in/{{Request::path()}}"><span class="sprite en_in-small"></span> <span class="country-label">India</span></a></li>
                                <li><a rel="alternate" hreflang="en-ru" href="http://www.patchchat.ru/{{Request::path()}}"><span class="sprite en_ru-small"></span> <span class="country-label">Russia</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
                
        @if (array_key_exists('title', View::getSections()))
        <div class="page-header">
            <div class="container-fluid">
                <h1>
                @yield('title')
                </h1>
            </div>
        </div>
        @endif
        @if (array_key_exists('pageheader', View::getSections()))
        <div class="page-header">
            <div class="container-fluid">                
                @yield('pageheader')                
            </div>
        </div>
        @endif


        @if (array_key_exists('breadcrumb', View::getSections()))
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ trans('messages.locale') }}</a></li>
                    @yield('breadcrumb')
                </ol>
            </div>
        @endif 
        
        @if (Session::has('message') or $errors->any())
        <div class="section section-white">        
            <div class="container-fluid">
                <p>&nbsp;</p>
            	@if (Session::has('message'))
            		<div class="alert alert-success alert-dismissible" role="alert">
            		    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            		    <p>{{ Session::get('message') }}</p>
            		</div>
            	@endif
            	@if ($errors->any())
            		<div class="alert alert-danger" role="alert">
            			@foreach ( $errors->all() as $error )
            				<p>{{ $error }}</p>
            			@endforeach
            		</div>
            	@endif
            </div>
        </div>
        @endif
        @yield('content')
        
        <!-- Scripts -->
 
        <footer id="footer">
        
            <div class="container-fluid text-center">
                <ul class="nav-footer">
                    <li>
                        <h4>Company</h4>
                        <ul>
                            <li><a class="" href="{{ route('about') }}">About</a></li> 
                            <li><a class="" href="{{ route('press') }}">Press</a></li> 
                            <li><a class="" href="{{ route('contact') }}">Inquiries</a></li> 
                        </ul>                        
                    </li>
                    <li>
                        <h4>Map</h4>
                        <ul>
                            <li><a class="" href="{{ route('map') }}">Live Global Map</a></li> 
                            <li><a class="" href="{{ route('facility.add') }}">Add Location</a></li> 
                        </ul>                        
                    </li>
                    <li>
                        <h4>Wiki</h4>
                        <ul>
                            <li><a class="" href="{{ route('wiki') }}">Wiki Encyclopedia</a></li> 
                            <li><a class="" href="{{ route('wiki.add') }}">Add Wiki Page</a></li> 
                            <li><a class="" href="{{ route('wiki.guidelines') }}">Wiki Guidelines</a></li> 
                        </ul>                        
                    </li>
                    
                    <li>
                        <h4>Industry</h4>
                        <ul>
                            <li><a href="{{ route('industry', ['industry' => 'mining']) }}">Mining</a></li> 
                            <li><a href="{{ route('industry', ['industry' => 'energy']) }}">Energy</a></li> 
                            <li><a href="{{ route('industry', ['industry' => 'solar']) }}">Solar</a></li> 
                            <li><a href="{{ route('industry', ['industry' => 'wind']) }}">Wind farm</a></li> 
                            <li><a href="{{ route('industry', ['industry' => 'hydro']) }}">Hydro</a>
                            <li><a href="{{ route('industry', ['industry' => 'forestry']) }}">Forestry</a></li> 
                        </ul>                        
                    </li>
                    
                    <li>
                        <h4>Community</h4>
                        <ul>
                            <li><a href="{{route("community.industries")}}">Industry Communities</a></li> 
                            <li><a href="{{route("community.camp")}}">Camp Communities</a></li> 
                            <li><a href="{{route("community.map")}}">Map Editor Communities</a></li> 
                            <li><a href="{{route("community.wiki")}}">Wiki Communities</a></li> 
                            <li><a href="{{route("community.guidelines")}}">Community Guidelines</a></li>
                        </ul>                        
                    </li>
                    
                    <li>
                        <h4>Advertising</h4>
                        <ul>
                            <li><a class="" href="{{ route('advertising.guidelines') }}">General Guidelines</a></li> 
                            <li><a class="" href="{{ route('advertising.political') }}">Political Guidelines</a></li> 
                            <li><a class="" href="{{ route('advertising') }}">Inquiries</a></li> 
                        </ul>                        
                    </li>
                    
                    <li>
                        <h4>Legal</h4>
                        <ul>
                            <li><a class="" href="{{ route('terms') }}">Terms</a></li> 
                            <li><a class="" href="{{ route('privacy') }}">Privacy Policy</a></li> 
                            <li><a class="" href="{{ route('law-enforcement') }}">Law Enforcement</a></li> 
                        </ul>                        
                    </li>
                </ul>
                
                <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="sprite {{ App::GetLocale() }}-small"></span> <span class="country-label">{{ trans("messages.locale") }}</span><span class="caret"></span></a>
                            
                        <ul class="dropdown-menu" role="menu">
                            <li><a rel="alternate" hreflang="en-us" href="http://www.patchchat.us/{{Request::path()}}"><span class="sprite en_us-small"></span> <span class="country-label">USA</span></a></li>
                            <li><a rel="alternate" hreflang="en-ca" href="http://www.patchchat.ca/{{Request::path()}}"><span class="sprite en_ca-small"></span> <span class="country-label">Canada</span></a></li>
                                <li><a rel="alternate" hreflang="en-in" href="http://www.patchchat.in/{{Request::path()}}"><span class="sprite en_in-small"></span> <span class="country-label">India</span></a></li>
                                <li><a rel="alternate" hreflang="en-ru" href="http://www.patchchat.ru/{{Request::path()}}"><span class="sprite en_ru-small"></span> <span class="country-label">Russia</span></a></li>

                        </ul>
                    </div>                                    

                <p>Copyright © <?php echo date('Y');?> PatchChat. All rights reserved.</p>
            </div>            
        </footer>
        
        <script type="text/javascript">
            var app = {};app.url = "<?= asset('assets/css/') ?>";app.rpp = 200;
            @if (Auth::check())
            <?php
            $user = array(
              'user' => array(
                "id" => Auth::getUser()->id,
                "displayname" => Auth::getUser()->name,
                "email" => Auth::getUser()->email,
                //"avatar" => "//gravatar.com/avatar/e5fb96fe7ec4ac3d4fa675422f8d1fb9",
                "is_admin" => false,
              ),
            );
            $message = base64_encode(json_encode($user));
            $time = time();
            ?>
            var muutMessage = '{{ $message }}';
            var muutTimestamp = '{{ $time }}';
            var muutSignature = '{{ sha1('tGL0WFn7hw1kHphfCqcEsMC7' . ' ' . $message . ' ' . $time) }}';
            @endif;
        </script>
        <script src='//api.tiles.mapbox.com/mapbox.js/v2.2.0/mapbox.js'></script>        
        <script type="text/javascript" src="{{ URL::asset('js/all.js') }}"></script>     
        <script src='<?= asset('js/i18n/angular-locale_' . str_replace("_","-",App::getLocale()).'.js') ?>'></script>        
        <script src="//cdn.muut.com/1/moot.min.js"></script>
        
        @yield('scripts')         
        
        @if(!Config::get("app.debug"))
        <!-- Quantcast Tag --> <script type="text/javascript"> var _qevents = _qevents || []; (function() { var elem = document.createElement('script'); elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js"; elem.async = true; elem.type = "text/javascript"; var scpt = document.getElementsByTagName('script')[0]; scpt.parentNode.insertBefore(elem, scpt); })(); _qevents.push({ qacct:"p-qDkF_e_derLhS" }); </script> <noscript> <div style="display:none;"> <img src="//pixel.quantserve.com/pixel/p-qDkF_e_derLhS.gif" border="0" height="1" width="1" alt="Quantcast"/> </div> </noscript> <!-- End Quantcast tag --> 
        @endif
    </body>
</html>

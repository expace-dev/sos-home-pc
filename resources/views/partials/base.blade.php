<!DOCTYPE html>
<html class="wide wow-animation" lang="fr">
  <head>
    <!-- Site Title-->
    <title>Sos Home PC - @yield('titre')</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato:400,700%7CMontserrat:300,400,700%7CLato:300,400,700">
    
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
<!--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
-->
		<!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" href="css/app.css">    
  </head>
  <body id="resultat">
    <!-- Page Loader-->
    <div id="page-loader">
      <div class="page-loader-body"><img src="images/logo.png" alt="" width="200" height="108"/>
        <div class="cssload-wrapper">
          <div class="cssload-border">
            <div class="cssload-whitespace">
              <div class="cssload-line"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page">
      <!-- Page Header-->
      <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-sm-device-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-stick-up-clone="false" data-md-stick-up-offset="74px" data-lg-stick-up-offset="66px" data-md-stick-up="false" data-lg-stick-up="true"> 
            <div class="rd-navbar-outer">
              <div class="rd-navbar-inner">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand"><a class="brand" href="index.html">
                      <div class="brand__name"><img class="brand__logo-dark" src="images/logo.png" alt="" width="200" height="108"/>
                      </div></a></div>
                </div>

                <div class="rd-navbar-body">
                  <!-- RD Navbar Aside-->
                  <div class="rd-navbar-aside">
                    <div class="rd-navbar-content-outer">
                      <div class="rd-navbar-content__toggle rd-navbar-static--hidden" data-rd-navbar-toggle=".rd-navbar-content"><span></span></div>
                      <div class="rd-navbar-content">
                        <ul class="list-bordered list-inline">
                          <li>
                            <dl class="list-terms-inline">
                              <dt>Téléphone</dt>
                              <dd><a href="tel:0754535558">07 54 53 55 58</a></dd>
                            </dl>
                          </li>
                          <li>
                            <dl class="list-terms-inline">
                              <dt>E-mail</dt>
                              <dd><a href="mailto:contact@sos-home-pc.fr">contact@sos-home-pc.fr</a></dd>
                            </dl>
                          </li>
                          <li>
                            <ul class="list-inline list-inline-xs">
                              <li><a class="icon icon-gray-dark icon-style-brand fa fa-facebook" href="#"></a></li>
                              <li><a class="icon icon-gray-dark icon-style-brand fa fa-twitter" href="#"></a></li>
                              <li><a class="icon icon-gray-dark icon-style-brand fa fa-google-plus" href="#"></a></li>
                              <li><a class="icon icon-gray-dark icon-style-brand fa fa-pinterest-p" href="#"></a></li>
                            </ul>
                          </li>
                        </ul>
                      </div>
                    </div>
                    @if (Auth::guest())
                    <div class="rd-navbar-panel__button"><a class="button button-xs button-icon button-icon-left button-default button-ujarak" href="{{ route('login') }}"><span class="icon mdi mdi-account"></span>Espace client</a></div>
                    @else
                    <div class="rd-navbar-panel__button">
                      <a class="button button-xs button-icon button-icon-left button-default button-ujarak" href="{{ route('logout') }}" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();
                      ">
                        <span class="icon mdi mdi-logout"></span>
                        Déconnexion
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                      </form>
                    </div>
                    @endif  
                </div>
                  <!-- RD Navbar Nav Wrap-->
                  <div class="rd-navbar-nav-wrap">
                    <!-- RD Navbar Nav-->
                    <ul class="rd-navbar-nav">
                      <li><a href="{{ route('home') }}">Accueil</a></li>
                      <li><a href="{{ route('home') }}#services">Nos services</a></li>
                      <li><a href="{{ route('home') }}#offres">Nos offres</a></li>
                      <li><a href="{{ route('home') }}#choisir">Nous choisir</a></li>
                      <li><a href="index.html">Nos articles</a></li>
                      <li><a href="{{ route('contact') }}">Nous contacter</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>

      @yield('content')


      <!-- Partners-->
      <section class="section section-md bg-white text-center">
        <div class="container">
          <div class="row row-50 align-items-sm-center">
            <div class="col-sm-6 col-md-3 wow fadeIn"><a class="link-image" href="#"><img src="images/brand-1-126x68.png" alt="" width="126" height="68"/></a></div>
            <div class="col-sm-6 col-md-3 wow fadeIn"><a class="link-image" href="#"><img src="images/brand-2-126x100.png" alt="" width="126" height="100"/></a></div>
            <div class="col-sm-6 col-md-3 wow fadeIn"><a class="link-image" href="#"><img src="images/brand-3-134x83.png" alt="" width="134" height="83"/></a></div>
            <div class="col-sm-6 col-md-3 wow fadeIn"><a class="link-image" href="#"><img src="images/brand-4-138x55.png" alt="" width="138" height="55"/></a></div>
          </div>
        </div>
      </section>

      <!-- Page Footer-->
      <footer class="section footer-classic">
        <div class="footer-classic__main bg-black-1">
          <div class="container">
            <div class="row row-50 align-items-sm-end justify-content-sm-center justify-content-lg-start">
              <div class="col-lg-6">
                <div class="footer-classic__custom-column d-xl-inline-flex">
                  <div class="unit d-xl-inline-flex justify-content-center justify-content-lg-start">
                    <div class="unit__left"><span class="icon icon-md icon-default linearicons-headset text-primary"></span></div>
                    <div class="unit__body"><a class="link link-lg" href="tel:#">07 54 53 55 58</a>
                      <p>Notre service d'assistance est disponible 24 heures sur 24</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-10 col-lg-6">
                <div class="group-md">
                  <h3>Souscrire</h3>
                  <p class="large">Recevez les dernières offres et mises à jour</p>
                </div>
                      <!-- RD Mailform-->
                      <form class="rd-mailform form_inline form_lg" data-form-output="form-output-global" data-form-type="subscribe" method="post" action="test.php">
                        <div class="form-wrap">
                          <input class="form-input" id="subscribe-form-footer-form-email" type="email" name="email" data-constraints="@Email @Required">
                          <label class="form-label" for="subscribe-form-footer-form-email">Votre E-mail</label>
                        </div>
                        <div class="form-button">
                          <button class="button button-lg button-primary button-ujarak" type="submit">Inscription</button>
                        </div>
                      </form>
              </div>
            </div>
            <div class="row row-50 justify-content-md-center justify-content-lg-start justify-content-xl-between">
              <div class="col-md-5 col-lg-3">
                <p class="custom-heading-1 custom-heading-bordered">La société</p>
                <div class="divider"></div>
                <p class="ls-05">Notre entreprise propose du dépannage informatique pour les particulers et les professionnels depuis 2005.</p>
                <ul class="list-inline list-inline-xs">
                  <li><a class="icon icon-xxs icon-circle icon-filled icon-filled_brand fa fa-facebook" href="#"></a></li>
                  <li><a class="icon icon-xxs icon-circle icon-filled icon-filled_brand fa fa-twitter" href="#"></a></li>
                  <li><a class="icon icon-xxs icon-circle icon-filled icon-filled_brand fa fa-google-plus" href="#"></a></li>
                  <li><a class="icon icon-xxs icon-circle icon-filled icon-filled_brand fa fa-instagram" href="#"></a></li>
                </ul>
              </div>
              <div class="col-md-5 col-lg-4 col-xl-3">
                <p class="custom-heading-1 custom-heading-bordered">Derniers articles</p>
                <div class="divider"></div>
                <div class="post-small-wrap">
                        <!-- Post small-->
                        <article class="post-small">
                          <div class="post-small__aside"><a class="post-small__media" href="blog-post.html"><img class="post-small__image" src="images/post-small-1-80x68.jpg" alt="" width="80" height="68"/></a></div>
                          <div class="post-small__main">
                            <p class="post-small__title"><a href="blog-post.html">Benefits of Async/Await in Programming</a></p>
                            <time class="post-small__time" datetime="2018">January 12, 2018</time>
                          </div>
                        </article>
                        <!-- Post small-->
                        <article class="post-small">
                          <div class="post-small__aside"><a class="post-small__media" href="blog-post.html"><img class="post-small__image" src="images/post-small-2-80x68.jpg" alt="" width="80" height="68"/></a></div>
                          <div class="post-small__main">
                            <p class="post-small__title"><a href="blog-post.html">Key Considerations and Warnings of iPaaS</a></p>
                            <time class="post-small__time" datetime="2018">January 12, 2018</time>
                          </div>
                        </article>
                </div>
              </div>
              <div class="col-md-10 col-lg-5 col-xl-4"> 
                <p class="custom-heading-1 custom-heading-bordered">Liens utiles</p>
                <div class="divider"></div>
                <div class="row row-5">
                  <div class="col-sm-6">
                    <ul class="list-marked list-marked_primary">
                      <li><a href="#">DB Management</a></li>
                      <li><a href="#">iOS/MacOs Apps</a></li>
                      <li><a href="#">Android Apps</a></li>
                      <li><a href="#">Windows Apps</a></li>
                      <li><a href="#">UX Design</a></li>
                    </ul>
                  </div>
                  <div class="col-sm-6">
                    <ul class="list-marked list-marked_primary">
                      <li><a href="#">Tutorials</a></li>
                      <li><a href="#">Product Support</a></li>
                      <li><a href="contact-us.html">Contact Us</a></li>
                      <li><a href="blog.html">Blog</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-default__aside bg-gray-5">
          <div class="container">
            <div class="footer-default__aside-inner">
              <!-- Rights-->
              <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>Sos Home PC</span><span>.&nbsp;</span><a href="privacy-policy.html">Politique de confidentialité</a>. Design&nbsp;by&nbsp;<a href="https://zemez.io/">Zemez</a></p>
              <ul class="list-separated list-inline">
                <li><a href="faq.html">FAQ</a></li>
                <li><a href="#">Support</a></li>
              </ul>
            </div>
          </div>
        </div>
      </footer>

    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="js/core.min.js"></script>
    <!--
    <script src="{{ asset('js/app.js') }}"></script>
    
-->
    @yield('script')
  </body>
</html>
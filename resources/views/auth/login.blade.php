@extends('partials.base')

@section('titre')
Identification
@endsection

@section('navigation-header')
<ul class="breadcrumbs-custom__path">
    <li><a href="index.html">Accueil</a></li>
    <li class="active">Connexion</li>
</ul>
@endsection


@section('content')

    @include('partials.headerPage')

    <!-- Login Form-->
        <section class="section section-md bg-white text-center">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-10 col-lg-8 col-xl-6">
                        <div class="group-sm group-sm-justify group-middle">
                            <a class="button button-facebook button-icon button-icon-left" href="#">
                                <span class="icon fa fa-facebook"></span>
                                Facebook
                            </a>
                            <a class="button button-twitter button-icon button-icon-left" href="#">
                                <span class="icon fa fa-twitter"></span>
                                Twitter
                            </a>
                            <a class="button button-google button-icon button-icon-left" href="#">
                                <span class="icon fa fa-google-plus"></span>
                                Google+
                            </a>
                        </div>
                        <div class="text-decoration-lines"><span class="text-decoration-lines__content">Ou</span></div>
                        <!-- RD Mailform-->
                        <form class="rd-mailform rd-mailform_label-centered" data-form-output="form-output-global" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-wrap">
                                <label class="form-label-outside" for="login-email">E-mail</label>
                                <input class="form-input" name="email" value="{{ old('email') }}" id="email" type="email" name="email" data-constraints="@Email @Required">
                                <span style="color: red">
                                    <strong id="erreur"></strong>
                                </span>
                                @error('email')
                                    <span style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-wrap">
                                <label class="form-label-outside" for="login-password">Password</label>
                                <input class="form-input" id="password" type="password" name="password" data-constraints="@Required">
                                
                                @error('password')
                                    <span style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-wrap">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me
                                </label>
                            </div>
                            <div class="row row-20 form-wrap">
                                <div class="col-md-6">
                                    <button class="button button-primary button-block button-ujarak" type="submit">Connexion</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('register') }}" class="button button-default-outline button-block button-ujarak">Créer un compte</a>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="#">Retrouver mes identifiants</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

@endsection

@section('script')
<script src="js/script.js"></script>
@endsection

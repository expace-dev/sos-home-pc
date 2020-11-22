@extends('partials.base')

@section('titre')
Identification
@endsection

@section('navigation-header')
<ul class="breadcrumbs-custom__path">
    <li><a href="index.html">Accueil</a></li>
    <li class="active">Inscription</li>
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
                        <form class="rd-mailform rd-mailform_label-centered" data-form-output="form-output-global" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-wrap">
                                <label class="form-label-outside" for="login-email">Nom</label>
                                <input class="form-input" name="name" value="{{ old('name') }}" id="name" type="text" name="name" data-constraints="@Required">
                                @error('name')
                                    <span style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-wrap">
                                <label class="form-label-outside" for="login-email">E-mail</label>
                                <input class="form-input" name="email" value="{{ old('email') }}" id="email" type="email" name="email" data-constraints="@Email @Required">
                                <span style="color: red">
                                    <strong id="erreur_email"></strong>
                                </span>
                            </div>
                            <div class="form-wrap">
                                <label class="form-label-outside" for="login-password">Mot de passe</label>
                                <input class="form-input" id="password" type="password" name="password" data-constraints="@Required">
                                <span style="color: red">
                                    <strong id="erreur_password"></strong>
                                </span>
                            </div>
                            <div class="form-wrap">
                                <label class="form-label-outside" for="login-password">Confirmation</label>
                                <input class="form-input" id="password-confirm" type="password" name="password_confirmation" data-constraints="@Required">
                                <span style="color: red">
                                    <strong id="erreur_confirm"></strong>
                                </span>
                            </div>
                            <div class="row row-20 form-wrap">
                                <div class="col-md-6">
                                    <button class="button button-primary button-block button-ujarak" type="submit">Créer mon compte</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('login') }}" class="button button-default-outline button-block button-ujarak">Espace client</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>


@endsection

@section('script')
<script src="js/inscription.js"></script>
@endsection


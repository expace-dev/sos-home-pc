@extends('partials/base')

@section('titre')
Dépannage informatique
@endsection

@section('content')

    <!-- Carousel d'images-->
        <section class="section swiper-container swiper-slider swiper_style-1 swiper_height-1 swiper-controls-classic section-overlay" data-loop="true" data-autoplay="10000" data-simulate-touch="false">
            <div class="swiper-wrapper">
                <div class="swiper-slide bg-image-dark" data-slide-bg="images/carousel/slide-4.jpg">
                    <div class="swiper-slide-caption">
                        <div class="container">
                            <h1 data-caption-animate="fadeInUpSmall">
                                <span class="d-block font-weight-light">Bienvenue chez sos home pc</span>
                                <span class="d-block font-weight-bold">Dépannage informatique</span>
                            </h1>
                            <div class="col-12 offset-top-60" data-caption-animate="fadeInUpSmall">
                                <a class="button button-lg button-primary button-ujarak" href="{{ route('home') }}#services">En savoir plus</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide bg-image-dark" data-slide-bg="images/carousel/slide-3.jpg">
                    <div class="swiper-slide-caption">
                        <div class="container">
                            <h1 data-caption-animate="fadeInUpSmall">
                                <span class="d-block font-weight-light">Service client professionnel</span>
                                <span class="d-block font-weight-bold">Nous intervenons rapidement</span>
                            </h1>
                            <div class="col-12 offset-top-60" data-caption-animate="fadeInUpSmall">
                                <a class="button button-lg button-primary button-ujarak" href="{{ route('home') }}#services">En savoir plus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </section>


    <!-- Nos services-->
        <section id="services" class="section section-md bg-white text-center">
            <div class="container">
                <h2>Nos services</h2>
                <div class="row row-30 justify-content-md-center wow fadeInUpSmall">
                    <div class="col-md-6 col-lg-4">
                        <article class="box-chloe box-chloe_primary">
                            <div class="box-chloe__icon linearicons-speed-fast"></div>
                            <div class="box-chloe__main">
                                <h4 class="box-chloe__title">Optimisation</h4>
                                <p>Nous pouvons optimiser votre ordinateur afin de lui apporter des performances optimales.</p><a class="button button-sm button-default button-ujarak" href="services.html">En savoir plus</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-chloe box-chloe_primary">
                            <div class="box-chloe__icon linearicons-cog"></div>
                            <div class="box-chloe__main">
                                <h4 class="box-chloe__title">Configuration</h4>
                                <p>Nous pouvons aussi configurer votre ordinateur afin de vous simplifier les manipulations régulières.</p><a class="button button-sm button-default button-ujarak" href="services.html">En savoir plus</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-chloe box-chloe_primary">
                            <div class="box-chloe__icon linearicons-pencil-ruler2"></div>
                            <div class="box-chloe__main">
                                <h4 class="box-chloe__title">Diagnostics</h4>
                                <p>Nos experts peuvent diagnostiquer tout problème informatique et peuvent le résoudre rapidement.</p><a class="button button-sm button-default button-ujarak" href="services.html">En savoir plus</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                       <article class="box-chloe box-chloe_primary">
                            <div class="box-chloe__icon linearicons-lock"></div>
                            <div class="box-chloe__main">
                                <h4 class="box-chloe__title">Sécurité</h4>
                                <p>Nos experts peuvent aussi sécuriser votre ordinateur et supprimmer tous virus ou logiciel malveillant.</p><a class="button button-sm button-default button-ujarak" href="services.html">En savoir plus</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-chloe box-chloe_primary">
                            <div class="box-chloe__icon linearicons-screen"></div>
                            <div class="box-chloe__main">
                                <h4 class="box-chloe__title">Installation</h4>
                                <p>Nos experts peuvent installer vos applications ou réparer votre systeme d'exploitation rapidement.</p><a class="button button-sm button-default button-ujarak" href="services.html">En savoir plus</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-chloe box-chloe_primary">
                            <div class="box-chloe__icon linearicons-sync"></div>
                            <div class="box-chloe__main">
                                <h4 class="box-chloe__title">Internet & Box</h4>
                                <p>La configuration de box n'est plus un secret, nous pouvons vous configuer cela en un tour de main.</p><a class="button button-sm button-default button-ujarak" href="services.html">En savoir plus</a>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

    <!-- Nos offres-->
        <section id="offres" class="section section-md bg-gray-light text-center oh">
            <div class="container wow fadeInUpSmall">
                <h2>Nos offres</h2>
                <div class="pricing-table pricing-table-classic">
                    <!-- Pricing table item-->
                        <article class="pricing-table__item pricing-table-classic__item">
                            <div class="pricing-table__item-header">
                                <p class="pricing-table__item-title">Basic</p>
                            </div>
                            <div class="pricing-table__item-price">
                                <span class="pricing-table__item-price-value">Gratuit</span>
                            </div>
                            <ul class="pricing-table__item-features">
                                <li>Service gratuit</li>
                                <li>Consultation en ligne</li>
                                <li>Support 24H/24 et 7J/7</li>
                                <li>Disponible sur discord</li>
                            </ul>
                            <div class="pricing-table__item-control"><a class="button button-default button-ujarak" href="#">Valider cette offre</a></div>
                        </article>
                    <!-- Pricing table item-->
                        <article class="pricing-table__item pricing-table-classic__item pricing-table-classic__item_prefered">
                            <div class="pricing-table__item-header">
                                <p class="pricing-table__item-title">Standard</p>
                            </div>
                            <div class="pricing-table__item-price">
                                <span class="pricing-table__item-price-value">29 €</span>
                            </div>
                            <ul class="pricing-table__item-features">
                                <li>Suppression de virus</li>
                                <li>Configuration de périphériques</li>
                                <li>Installation de logiciels</li>
                                <li>Récupération de données</li>
                            </ul>
                            <div class="pricing-table__item-control"><a class="button button-primary button-ujarak" href="#">Valider cette offre</a></div>
                        </article>
                    <!-- Pricing table item-->
                        <article class="pricing-table__item pricing-table-classic__item">
                            <div class="pricing-table__item-header">
                                <p class="pricing-table__item-title">Ultimate</p>
                            </div>
                            <div class="pricing-table__item-price">
                                <span class="pricing-table__item-price-value">49 €</span>
                            </div>
                            <ul class="pricing-table__item-features">
                                <li>Réinstallation systeme</li>
                                <li>Installation de périphériques</li>
                                <li>Récupération du systeme</li>
                                <li>Formations utilisateur</li>
                            </ul>
                            <div class="pricing-table__item-control"><a class="button button-default button-ujarak" href="#">Valider cette offre</a></div>
                        </article>
                </div>
            </div>
        </section>

    <!-- Nous choisir-->
        <section id="choisir" class="section section-sm bg-white text-center">
            <div class="container">
                <h2>Pourquoi nous choisir</h2>
                <div class="row row-30 wow fadeInUpSmall">
                    <div class="col-md-6 col-lg-4">
                        <article class="box-alice">
                            <div class="box-alice__inner">
                                <div class="box-alice__aside">
                                    <div class="box-alice__icon-outer">
                                        <span class="box-alice__icon linearicons-laptop-phone"></span>
                                    </div>
                                </div>
                                <div class="box-alice__main">
                                    <h5 class="box-alice__title">Matériel de qualité</h5>
                                    <p>Les périphériques que nous vous proposont sont de bonne qualité et approuvé par tous les utilisateurs</p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-alice">
                            <div class="box-alice__inner">
                                <div class="box-alice__aside">
                                    <div class="box-alice__icon-outer">
                                        <span class="box-alice__icon linearicons-headset"></span>
                                    </div>
                                </div>
                                <div class="box-alice__main">
                                    <h5 class="box-alice__title">Support 24/7</h5>
                                    <p>Vous pouvez compter sur notre support technique 24/7 qui résoudra volontiers tous les problèmes que vous pourriez rencontrer.</p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-alice">
                            <div class="box-alice__inner">
                                <div class="box-alice__aside">
                                    <div class="box-alice__icon-outer">
                                        <span class="box-alice__icon linearicons-coin-dollar"></span>
                                    </div>
                                </div>
                                <div class="box-alice__main">
                                    <h5 class="box-alice__title">Garantie 30 jours</h5>
                                    <p>Si vous n'êtes pas satisfait de nos services, vous avez 30 jours pour être intégralement remboursé.</p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-alice">
                            <div class="box-alice__inner">
                                <div class="box-alice__aside">
                                    <div class="box-alice__icon-outer">
                                        <span class="box-alice__icon linearicons-thumbs-up"></span>
                                    </div>
                                </div>
                                <div class="box-alice__main">
                                    <h5 class="box-alice__title">Approche client</h5>
                                    <p>Notre approche des clients nous permet de vous apporter des solutions qui sauront répondrent à tous vos besoins.</p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-alice">
                            <div class="box-alice__inner">
                                <div class="box-alice__aside">
                                    <div class="box-alice__icon-outer">
                                        <span class="box-alice__icon linearicons-profile"></span>
                                    </div>
                                </div>
                                <div class="box-alice__main">
                                    <h5 class="box-alice__title">Nos technicien</h5>
                                    <p>Nos techniciens ont toutes les compétences requises afin de règler vos problèmes quels qu'ils soit.</p>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <article class="box-alice">
                            <div class="box-alice__inner">
                                <div class="box-alice__aside">
                                    <div class="box-alice__icon-outer">
                                        <span class="box-alice__icon linearicons-credit-card"></span>
                                    </div>
                                </div>
                                <div class="box-alice__main">
                                    <h5 class="box-alice__title">Paiement</h5>
                                    <p>Nous proposons une large gamme de méthodes de paiement, carte bancaire, espèce, chèque et paypal.</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>


    <!-- Nos clients-->
        <section class="section section-md bg-gray-light text-center">
            <div class="container">
                <h2>Nos clients</h2>
                <!-- Owl Carousel -->
                <div class="owl-outer-navigation-wrap owl-carousel_nav-modern wow fadeInUpSmall">
                    <div class="owl-carousel quote-creative-carousel" data-items="1" data-lg-items="2" data-dots="true" data-nav="true" data-stage-padding="0" data-loop="true" data-margin="20" data-mouse-drag="false" data-navigation-container="#owl-carousel-nav" data-dots-each="1">
                        <div class="item">
                            <!-- Quote Creative-->
                                <article class="quote-creative"> 
                                    <div class="quote-creative__header">
                                        <div class="quote-creative__media"><img src="images/client-1-112x99.jpg" alt="" width="112" height="99"/></div>
                                        <div class="quote-creative__info">
                                            <p class="quote-creative__title">Michael Johnson</p>
                                            <p class="quote-creative__subtitle">Regular Client</p>
                                        </div>
                                    </div>
                                    <div class="quote-creative__main">
                                        <div class="quote-creative__mark">
                                            <svg version="1.1" x="0px" y="0px" width="39px" height="21px" viewbox="0 0 39 21">
                                                <polyline points="8.955,21 0,14.031 0.002,0.001 15.984,0.001 15.984,13.984 8.969,14.016 "></polyline>
                                                <polyline points="31.97,20.999 23.016,14.031 23.018,0.001 39,0.001 39,13.984 31.984,14.015 "></polyline>
                                            </svg>
                                        </div>
                                        <div class="quote-creative__main-text">
                                            <p>Expace offers a high caliber of resources skilled in Microsoft Azure .NET, mobile and Quality Assurance. They became our true business partners over the past three years of our cooperation.</p>
                                        </div>
                                    </div>
                                </article>
                        </div>
                        <div class="item">
                            <!-- Quote Creative-->
                                <article class="quote-creative">
                                    <div class="quote-creative__header">
                                        <div class="quote-creative__media"><img src="images/client-2-112x99.jpg" alt="" width="112" height="99"/></div>
                                            <div class="quote-creative__info">
                                                <p class="quote-creative__title">Rachel Adams</p>
                                                <p class="quote-creative__subtitle">Regular Client</p>
                                            </div>
                                        </div>
                                        <div class="quote-creative__main">
                                            <div class="quote-creative__mark">
                                                <svg version="1.1" x="0px" y="0px" width="39px" height="21px" viewbox="0 0 39 21">
                                                    <polyline points="8.955,21 0,14.031 0.002,0.001 15.984,0.001 15.984,13.984 8.969,14.016 "></polyline>
                                                    <polyline points="31.97,20.999 23.016,14.031 23.018,0.001 39,0.001 39,13.984 31.984,14.015 "></polyline>
                                                </svg>
                                            </div>
                                            <div class="quote-creative__main-text">
                                                <p>Expace is a highly skilled and uniquely capable firm with multitudes of talent on-board. We have collaborated on a number of diverse projects that have been a great success.</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <div class="owl-outer-navigation" id="owl-carousel-nav"></div>
                        </div>
                    </div>
                </section>


@endsection

@section('script')
<script src="js/global.js"></script>
@endsection

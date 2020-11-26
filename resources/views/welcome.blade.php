<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Rabbit">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Rabbit</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/purple.css') }}" rel="stylesheet">


    </head>
    <body>
        <header class="header" id="home">
        <!-- COLOR OVER IMAGE -->
        <div class="color-overlay">
            <!-- STICKY NAVIGATION -->
            <div class="navbar navbar-inverse bs-docs-nav sticky-navigation">
                <div class="container">
                    <div class="navbar-header"></div>
                    <div class="navbar-collapse" id="kane-navigation">
                        <ul class="nav navbar-nav navbar-right main-navigation">
                            <li><a id="menu-why" href="#features">WHY GETİR?</a></li>
                            <li><a id="menu-getiryemek" target="_blank" href="/yemek/">GETİRYEMEK</a></li>
                            <li><a id="menu-career" target="_blank" href="https://getir.breezy.hr/">CAREERS</a></li>
                            <li><a id="menu-franchise" target="_blank" href="/bayilik-basvurusu/">FRANCHISE</a></li>
                            <li><a id="menu-contact" href="#contact-section">CONTACT US</a></li>
                            <li><a id="menu-announcement" target="_blank" href="/en/announcement/">COVID-19 ANNOUNCEMENT</a></li>
                            <!-- <li><a id="menu-en" href="/"><img src="../images/tr.png" class="header-flag">TR</a> -->
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /END STICKY NAVIGATION -->

            <!-- CONTAINER -->
            <div class="container header-container">
                <div class="row home-contents">
                    <div class="col-md-6 col-sm-6">
                        <!-- HEADING AND BUTTONS -->
                        <div class="intro-section">
                            <!-- WELCOM MESSAGE -->
                            <img src="https://getir.com/images/bimutluluk.png" class="rabbit-hero img-responsive" alt="getir bi mutluluk">
                            <p class="rabbit-hero-description">
                                1500+ items delivered almost instantly. Throughout Istanbul, Izmir, Ankara, Bursa, Kocaeli, Bodrum, Sakarya, Tekirdağ, Eskişehir and Yalova we deliver goods (and happiness!), in an average of 10 minutes, day and night!
                            </p>

                            <!-- DOWNLOAD BUTTONS AREA -->
                            <div class="download-container">
                                <div class="buttons">
                                    <a id="download-ios" href="https://itunes.apple.com/app/id995280265" target="_blank" class="appstore"></a>
                                    <!-- <a id="download-android" href="https://play.google.com/store/apps/details?id=com.getir" target="_blank" class="playstore"></a> -->
                                    <!-- <a id="download-appgallery" href="https://appgallery7.huawei.com/#/app/C100954039" target="_blank" class="appgallery"></a> -->
                                </div>
                                <!-- /END BUTTONS -->
                            </div>
                            <!-- END OF DOWNLOAD BUTTONS AREA -->
                        </div>
                        <!-- /END HEADNING AND BUTTONS -->
                    </div>
                    <div class="col-md-6 col-sm-6 hidden-xs">
                        <div class="phone-image">
                            <img src="https://getir.com/images/en-single-iphone-v2.png" class="img-responsive" alt="">
                        </div>
                    </div>
                </div>
                <!-- /END ROW -->
                <div class="row">
                    <br>
                </div>
                <div class="row">
                    <br>
                </div>
            </div>
            <!-- /END CONTAINER -->
        </div>
        <!-- /END COLOR OVERLAY -->
    </header>

        <section class="features" id="features">
        <div class="container">
            <!-- SECTION HEADER -->
            <div class="section-header">
                <!-- SECTION TITLE -->
                <h2 class="dark-text">Why Getir?</h2>
            </div>
        </div>
        <!-- /END SECTION HEADER -->
        <div class="row">
            <!-- FEATURES LEFT -->
            <div class="col-md-offset-2 col-xs-12 col-md-push-4 col-sm-push-6 col-md-4 col-sm-6 features-right">
                <!-- FEATURE -->
                <div class="feature">
                    <!-- FEATURE HEADING AND DESCRIPTION -->
                    <div class="fetaure-details">
                        <h4 class="main-color">Minutes matter.</h4>
                        <p>
                            Modern big-city life is complex and tiring. Getir saves people time and adds value to their life, enabling them to use their time for the things that make them happy.
                        </p>
                    </div>
                </div>
                <!-- /END SINGLE FEATURE -->
            </div>
            <div class="col-md-pull-4 col-sm-pull-6 col-xs-12 col-md-4 col-sm-6 features-right">
                <img src="https://getir.com/images/en-zaman.png">
            </div>
        </div>
        <div class="colored-line"></div>
        <div class="row">
            <div class="col-md-offset-2 col-xs-12 col-md-push-4 col-sm-push-6 col-md-4 col-sm-6 features-right">
                <!-- FEATURE -->
                <div class="feature">
                    <!-- FEATURE HEADING AND DESCRIPTION -->
                    <div class="fetaure-details">
                        <h4 class="main-color"> Don’t bother with carrying stuff…</h4>
                        <p>
                            Shopping can be a hassle. All those bags. Long distances. Lines. We don’t want you to bother with any of those. Sit back, select your items and keep doing what you were doing as we deliver in minutes.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-pull-4 col-sm-pull-6 col-xs-12 col-md-4 col-sm-6 features-right">
                <img src="https://getir.com/images/en-sepet.png">
            </div>
            <!-- /END SINGLE FEATURE -->
        </div>
        <div class="colored-line"></div>
        <div class="row">
            <div class="col-md-offset-2 col-xs-12 col-md-push-4 col-sm-push-6 col-md-4 col-sm-6 features-right">
                <!-- FEATURE -->
                <div class="feature">
                    <!-- FEATURE HEADING AND DESCRIPTION -->
                    <div class="fetaure-details">
                        <h4 class="main-color">Happiness delivered, anywhere.</h4>
                        <p>
                            Whether it’s your cozy home, your workplace, or that beautiful park… We deliver anywhere in Istanbul, at any time 😉
                        </p>
                    </div>
                </div>
            </div>
            <!-- /END FEATURES RIGHT -->
            <div class="col-md-pull-4 col-sm-pull-6 col-xs-12 col-md-4 col-sm-6 features-right">
                <img src="https://getir.com/images/en-takip.png">
            </div>
        </div>
        <!-- /END ROW -->
        <div class="colored-line"></div>
        <div class="row">
            <div class="col-md-offset-2  col-xs-12 col-md-push-4 col-sm-push-6 col-md-4 col-sm-6 features-right">
                <!-- FEATURE -->
                <div class="feature">
                    <!-- FEATURE HEADING AND DESCRIPTION -->
                    <div class="fetaure-details">
                        <h4 class="main-color">Secure payments = happy you</h4>
                        <p>
                            Happiness is not dealing with repetitive things. Payment should be one of them. Simply add your payment method once, never deal with cash and physical cards again! Don’t worry, be happy.
                        </p>
                    </div>
                </div>
            </div>
            <!-- /END FEATURES RIGHT -->
            <div class="ol-md-pull-4 col-sm-pull-6 col-md-offset-2 col-xs-12 col-md-4 col-sm-6 features-right">
                <img src="https://getir.com/images/en-kart.png">
            </div>
        </div>
        <!-- /END ROW -->
    </section>
    <footer class="grey-bg" id="contact-section">
        <div class="container">
            <div class="contact-box">
                <div class="section-header">
                    <h2> Contact us. Really. A human will respond.</h2>
                </div>

                <!-- EXPANDED CONTACT FORM -->
                <div class="row expanded-contact-form">
                    <div class="col-md-3 col-md-offset-1 col-sm-6 text-left margin-bottom-lg">
                        <table class="table-address">
                            <tbody>
                                <tr>
                                    <td class="contact-icon">
                                        <i class="icon_phone"></i>
                                    </td>
                                    <td>
                                        <a href="tel:+908505325050">+90 (850) 532 50 50</a>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                <tr>
                                    <td class="contact-icon">
                                        <i class="icon_mail_alt"></i>
                                    </td>
                                    <td>
                                        <a href="mailto:info@getir.com">info@getir.com</a>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                <tr>
                                    <td class="contact-icon">
                                        <i class="icon_house_alt">
                                    </i></td>
                                    <td>
                                        Etiler Mah. Tanburi Ali Efendi Sok. Maya Residences Sit. T Blok No:13/334
                                        Beşiktaş/İstanbul, Türkiye 34337
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-7">
                        <!-- FORM -->
                        <form class="contact-form" id="contact" role="form">
                            <!-- IF MAIL SENT SUCCESSFULLY -->
                            <h4 class="success">
                                <i class="icon_check"></i> We've got your message!
                            </h4>
                            <!-- IF MAIL SENDING UNSUCCESSFULL -->
                            <h4 class="error">
                                <i class="icon_error-circle_alt"></i> You need to have a valid email address, a message longer than 1 character and a choosen subject.
                            </h4>
                            <div class="col-md-6">
                                <input class="form-control input-box" id="name" type="text" name="name" placeholder="Name">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control input-box" id="email" type="email" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control input-box" id="contact-phone" type="text" name="phone" placeholder="Phone Number (5-- --- -- --)">
                            </div>
                            <div class="col-md-12">
                                <select class="form-control input-box" id="subject">
                                    <option value="" disabled="" selected="">Select a subject</option>
                                    <option value="JOB_APPLICATION">Job Application</option>
                                    <option value="RESTAURANT_APPLICATION">Restaurant Application</option>
                                    <option value="FRANCHISE_APPLICATION">Franchise Application</option>
                                    <option value="OTHER">Other</option>
                                </select>
                                <h4 id="restaurantApplicationWarning" style="display: none">
                                    You can file a restaurant application from <a href="https://restoran.getiryemek.com/form/on-basvuru/">here</a>.
                                </h4>
                                <h4 id="franchiseApplicationWarning" style="display: none">
                                    You can file a franchise application from <a href="https://getir.com/bayilik-basvurusu/">here</a>.
                                </h4>
                                <textarea class="form-control textarea-box" id="message" rows="8" placeholder="What do you want to tell us? These messages get us really excited."></textarea>
                            </div>
                            <div class="col-md-12">
                                <div class="g-recaptcha" data-sitekey="6LdQEg4TAAAAAN1WZ7vXr8EwSv3bS_O_6YIHIbyN"><div style="width: 304px; height: 78px;"><div><iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LdQEg4TAAAAAN1WZ7vXr8EwSv3bS_O_6YIHIbyN&amp;co=aHR0cHM6Ly9nZXRpci5jb206NDQz&amp;hl=tr&amp;v=UFwvoDBMjc8LiYc1DKXiAomK&amp;size=normal&amp;cb=54yy25r7p00k" width="304" height="78" role="presentation" name="a-xcacgl8g8w1e" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div>
                                <button class="btn btn-primary btn-lg" type="submit" id="submit" name="submit">Send</button>
                            </div>
                        </form>
                        <!-- /END FORM -->
                    </div>
                </div>
                <!-- /END EXPANDED CONTACT FORM -->
            </div>
            <!-- /END CONTACT BOX -->

            <!-- SOCIAL ICONS -->
            <ul class="social-icons">
                <li><a href="https://tr-tr.facebook.com/getir/"><i class="social_facebook_square"></i></a></li>
                <li><a href="https://twitter.com/getir"><i class="social_twitter_square"></i></a></li>
                <li><a href="https://www.instagram.com/getir"><i class="social_instagram_square"></i></a></li>
            </ul>

            <!-- COPYRIGHT TEXT -->
            <p class="copyright">
                ©2020 Getir - <a href="https://e-sirket.mkk.com.tr/esir/Dashboard.jsp#/sirketbilgileri/18806" target="_blank">Information Society Services</a>
            </p>
        </div>
        <!-- /END CONTAINER -->
    </footer>
    </body>
</html>

<section id="section-contact" class="page-section section m-0 border-0 d-flex overflow-hidden">
    <div class="vertical-middle">
        <div class="container">

            <div class="row">
                <!-- Contact Form Overlay
                ============================================= -->
                <div class="contact-form-overlay col-md-6 offset-md-6 col-lg-4 offset-lg-8 p-5">

                    <div class="fancy-title title-border">
                        <h3>Send us an Email</h3>
                    </div>

                    <!-- Contact Form
                    ============================================= -->
                    <div class="form-widget">

                        <div class="form-result"></div>

                        <form class="row mb-0" id="template-contactform" name="template-contactform" action="include/form.php" method="post">

                            <div class="col-12 form-group">
                                <label for="template-contactform-name">Name <small>*</small></label>
                                <input type="text" id="template-contactform-name" name="template-contactform-name" value="" class="sm-form-control required" />
                            </div>

                            <div class="col-12 form-group">
                                <label for="template-contactform-email">Email <small>*</small></label>
                                <input type="email" id="template-contactform-email" name="template-contactform-email" value="" class="required email sm-form-control" />
                            </div>

                            <div class="col-12 form-group">
                                <label for="template-contactform-subject">Subject <small>*</small></label>
                                <input type="text" id="template-contactform-subject" name="subject" value="" class="required sm-form-control" />
                            </div>

                            <div class="col-12 form-group">
                                <label for="template-contactform-message">Message <small>*</small></label>
                                <textarea class="required sm-form-control" id="template-contactform-message" name="template-contactform-message" rows="6" cols="30"></textarea>
                            </div>

                            <div class="col-12 form-group d-none">
                                <input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="sm-form-control" />
                            </div>

                            <div class="col-12 form-group">
                                <button class="button button-3d m-0" type="submit" id="template-contactform-submit" name="template-contactform-submit" value="submit">Send Message</button>
                            </div>

                            <input type="hidden" name="prefix" value="template-contactform-">

                        </form>

                    </div>

                </div><!-- Contact Form Overlay End -->
            </div>

        </div>
    </div>

    <div class="video-wrap">
        <!-- Google Map
        ============================================= -->
        <div class="gmap h-100" data-address="Melbourne, Australia"  data-scrollwheel="false"></div>
    </div>

</section>

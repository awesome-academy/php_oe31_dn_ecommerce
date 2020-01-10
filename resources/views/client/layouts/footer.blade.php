<footer class="footer bg-light">
    <div class="container py-3">
        <div class="row">
            <div class="col-xs-12 hasPhone col-sm-6 col-md-3 col-lg">
                <p class="title">{{ trans('custome.work_time_1') }}</p>
                <p class="number_phone">
                    <a href="tel:{{ trans('custome.number_phone_1') }}">
                        <i class="fa fa-phone"></i> {{ trans('custome.number_phone_1') }}
                    </a>
                </p>
            </div>
            <div class="col-xs-12 hasPhone col-sm-6 col-md-3 col-lg">
                <p class="title">{{ trans('custome.work_time_2') }}</p>
                <p class="number_phone">
                    <a href="tel:{{ trans('custome.number_phone_2') }}">
                        <i class="fa fa-phone"></i> {{ trans('custome.number_phone_2') }}
                    </a>
                </p>
            </div>
            <div class="col-xs-12 hasPhone col-sm-6 col-md-3 col-lg">
                <p class="title">{{ trans('custome.signup_to_receive') }}</p>
                <div class="form_newsletter">
                    <div class="input-group">
                        <input class="form-control" type="email" value="">
                        <button type="submit" class="ml-2 btn btn-template">{{ trans('custome.sign_up') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

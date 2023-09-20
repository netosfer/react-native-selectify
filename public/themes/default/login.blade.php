
                        <form class="login-form" action="{{ route('auth.login-post') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="redir" value="{{ request()->get('redir') }}">
                            <div class="form-group">
                                <input id="text" name="email" type="text" placeholder="{{ __('frontend.email_address') }}" required="">
                            </div>
                            <div class="form-group">
                                <input id="pwd" name="password" placeholder="{{ __('frontend.password') }}" type="password" required="">
                            </div>
                            <div class="row mb-30">
                                    <a href="my-account.html" class="right">{{ __('frontend.forgot_password') }}</a>
                            </div>
                            <div class="form-group">
                                <button class="btn-one w-100 d-block" type="submit">
                                    {{ __('frontend.login') }}
                                </button>
                            </div>
                        </form>


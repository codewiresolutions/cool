@php use Carbon\Carbon; @endphp
<div class="modal fade" id="buypack{{ $package->id }}" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
                <div class="invitereval">
                    <h3>{{ __('Please Choose Your Payment Method to Pay') }}</h3>
                    <div class="totalpay">
                        {{ __('Total Amount to pay') }}:
                        <strong>{{ $package->package_price }}</strong>
                    </div>
                    <ul class="btn2s">
                        @if((bool)$siteSetting->is_stripe_active)
                            @if($package->package_price > 0)
                                <li class="order">
                                    @if($existing_package && Carbon::parse($company->package_end_date)->isFuture())
                                        {{-- Company already has a package → upgrade --}}
                                        <a href="{{route('stripe.order.form', [$package->id, 'upgrade'])}}"
                                           data-turbolinks="false">
                                            <i class="fa fa-cc-stripe"
                                               aria-hidden="true"></i> {{ __('Stripe') }}
                                        </a>
                                    @else
                                        {{-- First time purchase --}}
                                        <a href="{{route('stripe.order.form', [$package->id, 'new'])}}"
                                           data-turbolinks="false">
                                            <i class="fa fa-cc-stripe"
                                               aria-hidden="true"></i> {{ __('Stripe') }}
                                        </a>
                                    @endif
                                </li>
                            @else
                                <li class="order paypal">
                                    <a href="{{ route('order.free.package', $package->id) }}">
                                        {{ __('Subscribe Free Package') }}
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
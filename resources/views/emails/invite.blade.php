@component('mail::message')
# You’ve been invited!

You have been invited to join a company account.  
Click the button below to accept:

@component('mail::button', ['url' => $url])
    Accept Invite
@endcomponent

If the button doesn’t work, copy and paste this link into your browser:

[{{ $url }}]({{ $url }})

This link will expire in 2 hours.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

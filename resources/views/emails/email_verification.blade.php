<x-mail::message>
# Email Verification

Click the button below to verify your email address.

<x-mail::button :url="$url">
    Click Here To Verify
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

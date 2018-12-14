@component('mail::message')
# Backup has been completed at {{ \Carbon\Carbon::now() }}

@component('mail::panel')
    Here are the records those are taken in backup : --- {{ $records && is_array($records) ? implode(', ', $records) : 'None' }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
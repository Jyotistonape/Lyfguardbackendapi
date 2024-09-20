@extends('layouts.panel')

@section('content')
    @include('incl.message')

    @switch(auth()->user()->role)
    @case('1')
    @include('layouts.dashboard.superadmin')
    @break
    @case('2')
    @include('layouts.dashboard.admin')
    @break
    @case('3')
    @include('layouts.dashboard.hospital-admin')
    @break
    @case('4')
    @include('layouts.dashboard.branch-admin')
    @break
    @case('9')
    @include('layouts.dashboard.private-ambulance-admin')
    @break
    @case('12')
    @include('layouts.dashboard.customer-support-manager')
    @break
    @default
    @endswitch

@endsection

@section('script')
<script>
    $('document').ready(function () {
        const storedNotifyUser = localStorage.getItem('notify_to');
        var redirect_id = $("#redirect_id").val();
        if(storedNotifyUser=='1' || storedNotifyUser=='2' )
        {
            $('.hideshowredirect').addClass('d-none');
        }
        else
        {
            $('.hideshowredirect').removeClass('d-none');
        }
    });

    $('#notifyuser').click(function () {

        $('.hideshowredirect').removeClass('d-none');

    });
</script>

<script>
$(document).ready(function () {
    // Retrieve and display the saved notify user from local storage
    const storedNotifyUser = localStorage.getItem('notify_to');
    if (storedNotifyUser == 1) {
        
        $('input[name="notify_to"][value="' + storedNotifyUser + '"]').prop('checked', true);
        document.getElementById('notify_check').textContent =  'Notify User: Driver' ;
    }
    else
    {
        document.getElementById('notify_check').textContent = 'Notify User: Booking Manager';
    }

    // Save the notify user to local storage when the form is submitted
    $('#savedata').click(function () {
        // Get the selected radio button value
        const selectedNotifyUser = $('input[name="notify_to"]:checked').val();

        if (selectedNotifyUser) {
            // Store the selected value in local storage
            localStorage.setItem('notify_to', selectedNotifyUser);
        }
    });
});
</script>
@endsection


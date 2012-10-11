$(document).ready(function() {
    show_view();

    $('#plan_all_day').click(function() {
        if ($(this).attr('checked')) {
            $('#plan_start_time').hide();
            $('#plan_end_time').hide();
        } else {
            $('#plan_start_time').show();
            $('#plan_end_time').show();
        }
    });

    $('#plan_repeat').click(function() {
        show_view();
    });
    $('#plan_plan_repeats_0_repeats').change(function() {
        show_view();
    });
    $('#plan_plan_repeats_0_ends_type').change(function() {
        show_view();
    });
});

function show_view()
{
    var repeat = $('#plan_repeat').attr('checked');
    if (repeat) {
        $('#repeat_form').show();
    } else {
        $('#repeat_form').hide();
    }

    var type = $('#plan_plan_repeats_0_repeats').val();
    if (type == 'hourly') {
        view_hourly();
    } else if (type == 'daily') {
        view_daily();
    } else if (type == 'weekly') {
        view_weekly();
    } else if (type == 'monthly') {
        view_monthly();
    } else if (type == 'yearly') {
        view_yearly();
    }

    var end_type = $('#plan_plan_repeats_0_ends_type').val();
    if (end_type == 'never') {
        $('#plan_plan_repeats_0_ends_after').closest('div.control-group').hide();
        $('#plan_plan_repeats_0_ends_on').closest('div.control-group').hide();
    } else if (end_type == 'after') {
        $('#plan_plan_repeats_0_ends_after').closest('div.control-group').show();
        $('#plan_plan_repeats_0_ends_on').closest('div.control-group').hide();
    } else if (end_type == 'on') {
        $('#plan_plan_repeats_0_ends_after').closest('div.control-group').hide();
        $('#plan_plan_repeats_0_ends_on').closest('div.control-group').show();
    }
}

function view_hourly()
{
    $('#plan_plan_repeats_0_repeat_on').closest('div.control-group').hide();
    $('#plan_plan_repeats_0_repeat_by').closest('div.control-group').hide();
}

function view_daily()
{
    $('#plan_plan_repeats_0_repeat_on').closest('div.control-group').hide();
    $('#plan_plan_repeats_0_repeat_by').closest('div.control-group').hide();
}

function view_weekly()
{
    $('#plan_plan_repeats_0_repeat_on').closest('div.control-group').show();
    $('#plan_plan_repeats_0_repeat_by').closest('div.control-group').hide();
}

function view_monthly()
{
    $('#plan_plan_repeats_0_repeat_on').closest('div.control-group').hide();
    $('#plan_plan_repeats_0_repeat_by').closest('div.control-group').show();
}

function view_yearly()
{
    $('#plan_plan_repeats_0_repeat_on').closest('div.control-group').hide();
    $('#plan_plan_repeats_0_repeat_by').closest('div.control-group').hide();
}

// css & scss

require('../vendor/HoldOn.js/HoldOn.min.css');
require('../vendor/jquery-steps/jquery-steps.css');

// js

require('../vendor/HoldOn.js/HoldOn.min.js');
require('../vendor/jquery-steps/jquery-steps.min.js');

$(document).ready(function () {

    $('#steps').steps({
        onChange: function (currentIndex, newIndex, stepDirection) {
            $('#next-step').removeClass('d-none');
            $('#finish-step').removeClass('d-none');
            if (newIndex == 1) {
                if ($('#step' + newIndex).data('test-passed') == '0') {
                    $('.step-steps > li > a[href="#step' + newIndex + '"]').closest('li').addClass('error');
                    $('#next-step').addClass('d-none');
                    $('#finish-step').addClass('d-none');
                }
            }
            if (newIndex == 2) {
                if ($('#step' + newIndex).data('test-passed') == '0') {
                    $('.step-steps > li > a[href="#step' + newIndex + '"]').closest('li').addClass('error');
                    $('#next-step').addClass('d-none');
                    $('#finish-step').addClass('d-none');
                }
            }
            if (newIndex == 3) {
                $('#next-step').addClass('d-none');
            }
            if (newIndex == 4) {
                $('#next-step').addClass('d-none');
                if ($('#step1').data('test-passed') == '0' || $('#step2').data('test-passed') == '0' || $('#step3').data('test-passed') == '0') {
                    $('#finish-step').addClass('d-none');
                }
            }
            return true;
        },
        onFinish: function () {
            HoldOn.open({
                theme: "sk-fading-circle",
                content: 'Please wait while saving your configuration...',
                backgroundColor: "#fff",
                textColor: "#f67611"
            });
            window.location = $('#finish-step').data('save-configuration-path') + '?host=' + $('#host').val() + '&username=' + $('#username').val() + '&password=' + $('#password').val() + '&name=' + $('#name').val();
        }
    });

    $('.step-steps a').each(function () {
        $(this).off("click");
        $(this).click(function (e) {
            e.preventDefault();
            return false;
        });
    });

    $('#test-database-connection').click(function () {
        var isFormValid = true;
        if ($('#host').val().length == 0) {
            $('#host').closest('.form-group').find('p').removeClass('d-none');
            $('#host').addClass('is-invalid');
            isFormValid = false;
        } else {
            $('#host').closest('.form-group').find('p').addClass('d-none');
            $('#host').removeClass('is-invalid');
        }
        if ($('#username').val().length == 0) {
            $('#username').closest('.form-group').find('p').removeClass('d-none');
            $('#username').addClass('is-invalid');
            isFormValid = false;
        } else {
            $('#username').closest('.form-group').find('p').addClass('d-none');
            $('#username').removeClass('is-invalid');
        }
        if ($('#name').val().length == 0) {
            $('#name').closest('.form-group').find('p').removeClass('d-none');
            $('#name').addClass('is-invalid');
            isFormValid = false;
        } else {
            $('#name').closest('.form-group').find('p').addClass('d-none');
            $('#name').removeClass('is-invalid');
        }
        if (isFormValid) {
            $('#test-database-connection').addClass('d-none');
            $.ajax({
                type: 'GET',
                url: $('#finish-step').data('test-database-connection-path'),
                data: {host: $('#host').val(), username: $('#username').val(), password: $('#password').val(), name: $('#name').val()},
                beforeSend: function () {
                    $('#database-connection-error').addClass('d-none');
                    $('#database-connection-success').addClass('d-none');
                    $('#testing-database-connection').removeClass('d-none');
                },
                success: function (response) {
                    $('#test-database-connection').removeClass('d-none');
                    $('#testing-database-connection').addClass('d-none');
                    if (response != '1') {
                        $('#database-connection-error').html('<i class="fas fa-exclamation-circle mr-1"></i>' + response);
                        $('#database-connection-error').removeClass('d-none');
                        $('#step3').attr('data-test-passed', '0');
                    } else {
                        $('#next-step').removeClass('d-none');
                        $('#database-connection-success').removeClass('d-none');
                        $('#step3').attr('data-test-passed', '1');
                    }
                }
            });
        }
    });

});
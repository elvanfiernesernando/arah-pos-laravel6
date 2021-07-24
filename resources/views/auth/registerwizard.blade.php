@extends('layouts.master')

@section('title')
<title>ARAH POS - Register</title>
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">

        <!--vertical wizard-->
        <div class="row">
            <div class="col-lg-8 grid-margin mx-auto">
                <div class="card">
                    <div class="card-body">

                        @if (session('error'))
                        @alert(['type' => 'danger'])
                        {!! session('error') !!}
                        @endalert
                        @endif

                        @if (session('success'))
                        @alert(['type' => 'success'])
                        {!! session('success') !!}
                        @endalert
                        @endif

                        @if ($errors->any())
                        @alert(['type' => 'danger'])
                        {{ $errors->first() }}
                        @endalert
                        @endif

                        <h4 class="card-title">Registration Wizard</h4>
                        <p class="mb-3">Complete your profile and enjoy our product</p>
                        <form id="vertical-registration-wizard" method="POST" action="{{ route('registration.wizard') }}">
                            @csrf
                            <div>
                                <h3>Company</h3>
                                <section>
                                    <h3 class="mb-3 mt-1">Company Information</h3>
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input id="company_name" name="company_name" type="text" class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="company_email">Company Email</label>
                                        <input id="company_email" name="company_email" type="email" class=" form-control">
                                    </div>
                                    <div class="form-check form-check-primary">
                                    </div>
                                    <div class="form-group">
                                        <label for="company_address">Address</label>
                                        <input id="company_address" name="company_address" type="text" class=" form-control">
                                    </div>
                                </section>
                                <h3>Business Unit</h3>
                                <section>
                                    <h3 class="mb-3 mt-1">Business Unit</h3>
                                    <div class="form-group">
                                        <label for="business_unit_name">Business Unit Name</label>
                                        <input id="business_unit_name" name="business_unit_name" type="text" class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="business_type">Business Type</label>
                                        <select name="business_type" id="business_type" class=" form-control">
                                            <option value="">Choose</option>
                                            <!-- Tambah Jenis Bisnis Disini -->
                                            <option value="Food & Beverages">Food & Beverages</option>
                                            <option value="Salon & Barbershop">Salon & Barbershop</option>
                                            <option value="Technology">Technology</option>
                                            <!-- Tambah Jenis Bisnis Disini END-->
                                        </select>
                                    </div>
                                </section>
                                <h3>Outlet</h3>
                                <section>
                                    <h3 class="mb-3 mt-1">Outlet</h3>
                                    <div class="form-group">
                                        <label for="branch_name">Outlet Name</label>
                                        <input id="branch_name" name="branch_name" type="text" class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="branch_address">Address</label>
                                        <input id="branch_address" name="branch_address" type="text" class=" form-control">
                                    </div>
                                </section>
                                <h3>Finish</h3>
                                <section>
                                    <h3 class="mb-3 mt-1">Finish</h3>
                                </section>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    (function($) {

        $('#cb-company-email').change(function() {
            alert($(this).prop('checked'))
        })

        'use strict';

        var verticalForm = $("#vertical-registration-wizard");
        // validate signup form on keyup and submit
        verticalForm.validate({
            rules: {
                company_name: {
                    required: true,
                    minlength: 5
                },
                company_email: {
                    required: true,
                    email: true
                },
                company_address: {
                    required: true,
                    minlength: 10
                },
                business_unit_name: {
                    required: true,
                    minlength: 5
                },
                business_type: {
                    required: true,
                },
                branch_name: {
                    required: true,
                    minlength: 5,
                },
                branch_address: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                company_name: {
                    required: "Please enter your company name",
                    minlength: "Your company name must consist of at least 5 characters"
                },
                company_address: {
                    required: "Please enter your company address",
                    minlength: "Your company address must consist of at least 10 characters"
                },
                business_unit_name: {
                    required: "Please enter your business unit name",
                },
                business_unit_address: {
                    required: "Please select your business unit type",
                },
                branch_name: {
                    required: "Please enter your branch name",
                    minlength: "Your branch name must consist of at least 5 characters"
                },
                branch_address: {
                    required: "Please enter your branch address",
                    minlength: "Your branch address must consist of at least 10 characters"
                }
            },
            errorPlacement: function(label, element) {
                label.addClass('ml-0 text-danger');
                label.insertAfter(element);
            },
            highlight: function(element, errorClass) {
                $(element).parent().addClass('has-danger')
                $(element).addClass('is-invalid')
            }
        });

        verticalForm.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            stepsOrientation: "vertical",
            onStepChanging: function(event, currentIndex, newIndex) {

                // Always allow previous action even if the current form is not valid!
                if (currentIndex > newIndex) {
                    return true;
                }

                verticalForm.validate().settings.ignore = ":disabled,:hidden";
                return verticalForm.valid();
            },
            onFinishing: function(event, currentIndex) {
                verticalForm.validate().settings.ignore = ":disabled";
                return verticalForm.valid();
            },
            onFinished: function(event, currentIndex) {
                // console.log(verticalForm.serialize());

                verticalForm.submit();
                // alert("Submitted!");
            }
        });



    })(jQuery);
</script>
@endsection
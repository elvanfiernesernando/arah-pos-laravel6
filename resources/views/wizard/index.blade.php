@extends('layouts.master')

@section('title')
<title>ARAH POS - Wizard</title>
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

                        <h4 class="card-title">Hello, {{ auth()->user()->name}}</h4>
                        <p class="mb-3">Just a few more steps, let's finish setting up your account</p>
                        <form id="vertical-registration-wizard" method="POST" action="{{ route('wizard.store') }}">
                            @csrf
                            <div>
                                <h3>Company</h3>
                                <section>
                                    <h3 class="mb-3 mt-1">Company Information</h3>
                                    <div class="form-group mb-2">
                                        <label for="company_name" class="required">Name</label>
                                        <input id="company_name" name="company_name" type="text" class="form-control" placeholder="ex: KopiKu Rayu / PT. Arah Melangkah">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="company_email" class="required">Email</label>
                                        <input id="company_email" name="company_email" type="email" class="form-control" placeholder="ex: example@mail.com" value="{{ auth()->user()->email }}">
                                    </div>
                                    <div class="form-check d-flex align-items-center mt-2">
                                        <label class="form-check-label text-muted">
                                            <input id="cb_company_email" type="checkbox" class="form-check-input" checked>
                                            Use current email
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_address" class="required">Address</label>
                                        <textarea id="company_address" name="company_address" type="text" class="form-control" rows="4"  placeholder="ex: Jl. Palmerah Barat 21 Gelora, Tanah Abang, Jakarta"></textarea>
                                    </div>
                                </section>
                                <h3>Business Unit</h3>
                                <section>
                                    <h3 class="mb-3 mt-1">Business Unit</h3>
                                    <div class="form-group">
                                        <label for="business_unit_name" class="required">Business Unit Name</label>
                                        <input id="business_unit_name" name="business_unit_name" type="text" class=" form-control" placeholder="ex: KopiKu Rayu">
                                    </div>
                                    <div class="form-group">
                                        <label for="business_type" class="required">Business Type</label>
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
                                        <label for="branch_name" class="required">Outlet Name</label>
                                        <input id="branch_name" name="branch_name" type="text" class=" form-control" placeholder="ex: Cabang Jakarta">
                                    </div>
                                    <div class="form-group">
                                        <label for="branch_address" class="required">Address</label>
                                        <textarea id="branch_address" name="branch_address" type="text" class=" form-control" rows="4" placeholder="ex: Jl. Palmerah Barat 21 Gelora, Tanah Abang, Jakarta"></textarea>
                                    </div>
                                </section>
                                <h3>Finish</h3>
                                <section>
                                    <h3 class="mb-3 mt-1">Finish</h3>
                                    <div class="form-check d-flex align-items-center mt-2">
                                        <label class="form-check-label text-muted">
                                            <input id="cb_agreement" name="cb_agreement" type="checkbox" class="form-check-input">
                                            I hereby agree and confirm that all of my personal information and data filled in this form are accurate
                                        </label>
                                    </div>
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
    $(document).ready(function($) {

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
                },
                cb_agreement: {
                    required: true
                }
            },
            messages: {
                company_name: {
                    required: "This field is required",
                    minlength: "Your company name must consist of at least 5 characters"
                },
                company_email: {
                    required: "This field is required",
                },
                company_address: {
                    required: "This field is required",
                    minlength: "Your company address must consist of at least 10 characters"
                },
                business_unit_name: {
                    required: "This field is required",
                },
                business_type: {
                    required: "This field is required",
                },
                branch_name: {
                    required: "This field is required",
                    minlength: "Your outlet name must consist of at least 5 characters"
                },
                branch_address: {
                    required: "This field is required",
                    minlength: "Your outlet address must consist of at least 10 characters"
                },
                cb_agreement: {
                    required: "You must read and agree to the terms and conditions in order to proceed."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "cb_agreement") {
                    error.insertAfter(".form-check");
                } else {
                    error.addClass('ml-0 mt-2 text-danger');
                    error.insertAfter(element);
                }
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

                verticalForm.submit();
                // alert("Submitted!");
            }
        });

        $('#cb_company_email').change(function() {
            if(this.checked) {
                $('#company_email').val("{{ auth()->user()->email }}")
            } else{
                $('#company_email').val("")
            }
        })

    });
</script>
@endsection
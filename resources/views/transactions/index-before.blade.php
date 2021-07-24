@extends('layouts.master')

@section('title')
<title>ARAH POS - CATEGORY</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">

    <div class="content-header">

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

        <div class="row">

            <div class="col-lg-7 col-md-7 col-sm-12 mb-4">
                <div class="row">

                    <div class="col-12 mb-4">
                        <div class="card card-noborder b-radius">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-start align-items-center">
                                        <div class="cart-icon mr-3">
                                            <i class="mdi mdi-format-list-bulleted-type"></i>
                                        </div>
                                        <p class="m-0 text-black-50">Daftar Produk</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($products as $product)

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                        <div class="card card-noborder b-radius" style="cursor: pointer" onclick="this.closest('form').submit();return false;">
                            <div class="px-3 pt-3">
                                @if (!empty($product->product_photo))
                                <img class="card-img-top b-radius" src="{{ asset('uploads/product/' . $product->product_photo) }}" alt="{{ $product->product_name }}" width="100px" height="100px" style="cursor: pointer" onclick="this.closest('form').submit();return false;">
                                @else
                                <img src="http://via.placeholder.com/50x50" alt="{{ $product->product_name }}">
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <label class="card-text font-weight-bold">{{$product->product_name}}</label>
                                <p class="card-text text-secondary">Rp. {{ number_format($product->product_price) }},-</p>
                            </div>
                            <form action="{{url('/transaction/addtocart', $product->id)}}" method="POST" class="mx-auto">
                                @csrf
                                @if($product->product_stock == 0)
                                <button type="button" class="btn btn-secondary btn-icon-text btn-md mb-2" disabled>
                                    <i class="ti-shopping-cart btn-icon-append"></i>
                                    Add To Cart
                                </button>
                                @else
                                <button type="button" class="btn btn-primary btn-icon-text btn-md mb-2" onclick="this.closest('form').submit();return false;">
                                    <i class="ti-shopping-cart btn-icon-append"></i>
                                    Add To Cart
                                </button>
                                @endif
                            </form>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="card card-noborder b-radius">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-4 bg-dark-blue">
                                <div class="card card-noborder b-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between align-items-center transaction-header">
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <div class="icon-holder">
                                                        <i class="mdi mdi-swap-horizontal"></i>
                                                    </div>
                                                    <div class="transaction-code ml-3">
                                                        <p class="m-0 text-white">Customer Details</p>
                                                        <!-- <p class="m-0 text-white">INV-{{ date('dmY') }}{{ userCompanyId()}}{{ userBusinessUnitId()}}{{ userBranchId()}}{{ date('His')}}</p> -->
                                                        <p class="m-0 text-white">-</p>
                                                        <input type="text" name="kode_transaksi" value="T{{ date('dmYHis') }}" hidden="">
                                                    </div>
                                                </div>
                                                <div class="btn-group mt-h">
                                                    <button class="btn btn-search" data-toggle="modal" data-target="#searchCustomerModal" type="button">
                                                        <i class="mdi mdi-magnify"></i>
                                                    </button>
                                                    <button class="btn btn-scan" data-toggle="modal" data-target="#addCustomerModal" type="button">
                                                        <i class="mdi mdi-grease-pencil"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-12 mb-2 text-center ">
                                <h4 class="text-primary font-weight-bold mb-3">THE BOBA TIME INDONESIA</h4>
                                <p class="px-5">Ruko Vanda, Jl. Palem Raya, RT.001/RW.011, Bencongan Indah, Kec. Klp. Dua, Kota Tangerang, Banten 15810</p>
                            </div> -->
                            <div class="container">
                                <div class="col-12 payment-1">
                                    <table class="table-payment-1">
                                        <tr>
                                            <td class="text-left">Tanggal</td>
                                            <td class="text-right">{{ date('d M, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Waktu</td>
                                            <td class="text-right">{{ date('H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Kasir</td>
                                            <td class="text-right">{{ auth()->user()->name }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 mt-2 mb-5">
                                <table class="table table-striped table-sm" width="100%">
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @forelse($cart_data as $index=>$item)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{Str::words($item['name'],3)}}</td>
                                            <td class="text-center">
                                                <form action="{{url('/transaction/decreasecart', $item['rowId'])}}" method="POST" style='display:inline;'>
                                                    @csrf
                                                    <button class="btn" style="display: inline;padding:0.4rem 0.6rem!important"><i class="mdi mdi-minus"></i></button>
                                                </form>
                                                <a style="display: inline">{{$item['qty']}}</a>
                                                <form action="{{url('/transaction/increasecart', $item['rowId'])}}" method="POST" style='display:inline;'>
                                                    @csrf
                                                    <button class="btn" style="display: inline;padding:0.4rem 0.6rem!important"><i class="mdi mdi-plus"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 mt-4">
                                <table class="table-payment-2">
                                    <tr>
                                        <td class="text-left">
                                            <span class="subtotal-td">Subtotal</span>
                                            <span class="jml-barang-td">0 Barang</span>
                                        </td>
                                        <td class="text-right nilai-subtotal1-td">Rp.
                                            {{ number_format($data_total['sub_total'],2,',','.') }}
                                        </td>
                                        <td hidden=""><input type="text" class="nilai-subtotal2-td" name="subtotal" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                            <span class="diskon-td">Diskon</span>
                                            <a href="#" class="ubah-diskon-td">Ubah diskon</a>
                                            <a href="#" class="simpan-diskon-td" hidden="">Simpan</a>
                                        </td>
                                        <td class="text-right d-flex justify-content-end align-items-center pt-2">
                                            <input type="number" class="form-control diskon-input mr-2" min="0" max="100" name="diskon" value="0" hidden="">
                                            <span class="nilai-diskon-td mr-1">0</span>
                                            <span>%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center nilai-total1-td">Rp.
                                            {{ number_format($data_total['total'],2,',','.') }}
                                        </td>
                                        <td hidden=""><input type="text" class="nilai-total2-td" name="total" value="0"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 mt-2">
                                <form action="{{ url('/transaction/payout') }}" method="POST">
                                    @csrf
                                    <table class="table-payment-3">
                                        <tr>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Rp.</div>
                                                    </div>
                                                    <input type="text" class="form-control number-input input-notzero bayar-input" name="cash" placeholder="Masukkan nominal bayar">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="nominal-error" hidden="">
                                            <td class="text-danger nominal-min">Nominal bayar kurang</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                <button type="submit" class="btn btn-md btn-primary" type="button">Bayar</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @include('transactions.modal.customer.add')
        @include('transactions.modal.customer.search')

    </div>

</div>
@endsection
<?php

namespace App\Http\Controllers;

use App\Order;
use App\Order_detail;
use App\Product;
use DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Mendapatkan User Company ID
        // $user_company_id = userCompanyId();
        // $products = Product::inCompany($user_company_id)->orderBy('created_at', 'DESC')->get();

        $user_business_unit_id = userBusinessUnitId();
        $products = Product::inBusinessUnit($user_business_unit_id)->orderBy('created_at', 'DESC')->get();

        $items = \Cart::session(auth()->user()->id)->getContent();

        if (\Cart::isEmpty()) {
            $cart_data = [];
        } else {
            foreach ($items as $row) {
                $cart[] = [
                    'rowId' => $row->id,
                    'name' => $row->name,
                    'qty' => $row->quantity,
                    'pricesingle' => $row->price,
                    'price' => $row->getPriceSum(),
                    'created_at' => $row->attributes['created_at'],
                ];
            }

            $cart_data = collect($cart)->sortBy('created_at');
        }

        //total
        $sub_total = \Cart::session(auth()->user()->id)->getSubTotal();
        $total = \Cart::session(auth()->user()->id)->getTotal();

        $data_total = [
            'sub_total' => $sub_total,
            'total' => $total
        ];

        return view('transactions.index', compact('products', 'cart_data', 'data_total'));
    }

    public function show()
    {
    }

    public function getProductsData()
    {
        $user_business_unit_id = userBusinessUnitId();
        $products = Product::inBusinessUnit($user_business_unit_id)->orderBy('created_at', 'DESC')->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function addProductCart($id)
    {
        $product = Product::find($id);

        $cart = \Cart::session(auth()->user()->id)->getContent();
        $cek_itemId = $cart->whereIn('id', $id);

        if ($cek_itemId->isNotEmpty()) {
            if ($product->product_stock == $cek_itemId[$id]->quantity) {
                return redirect()->back()->with('error', 'Insufficient stock, please re-stock product first!');
            } else {
                \Cart::session(auth()->user()->id)->update($id, array(
                    'quantity' => 1
                ));
            }
        } else {
            \Cart::session(auth()->user()->id)->add(array(
                'id' => $id,
                'name' => $product->product_name,
                'price' => $product->product_price,
                'quantity' => 1,
                'attributes' => array(
                    'created_at' => date('Y-m-d H:i:s')
                )
            ));
        }

        return redirect()->back();
    }

    public function decreaseCart($id)
    {
        $product = Product::find($id);

        $cart = \Cart::session(auth()->user()->id)->getContent();
        $cek_itemId = $cart->whereIn('id', $id);

        if ($cek_itemId->isNotEmpty()) {
            if ($cek_itemId[$id]->quantity == 1) {
                \Cart::session(auth()->user()->id)->remove($id);
            } else {
                \Cart::session(auth()->user()->id)->update($id, array(
                    'quantity' => array(
                        'relative' => true,
                        'value' => -1
                    )
                ));
            }
        } else {
            return redirect()->back()->with('error', 'Product Removed!');
        }
        return redirect()->back();
    }


    public function increaseCart($id)
    {
        $product = Product::find($id);

        $cart = \Cart::session(auth()->user()->id)->getContent();
        $cek_itemId = $cart->whereIn('id', $id);

        if ($product->product_stock == $cek_itemId[$id]->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock, please re-stock product first');
        } else {
            \Cart::session(auth()->user()->id)->update($id, array(
                'quantity' => array(
                    'relative' => true,
                    'value' => 1
                )
            ));

            return redirect()->back();
        }
    }

    public function payout()
    {

        $cart_total = \Cart::session(auth()->user()->id)->getTotal();

        $cash = request()->cash;
        $change = (int)$cash - (int)$cart_total;

        if ($change >= 0) {
            DB::beginTransaction();

            try {

                $all_cart = \Cart::session(auth()->user()->id)->getContent();

                $filterCart = $all_cart->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'qty' => $item->quantity,
                        'price' => $item->price
                    ];
                });

                foreach ($filterCart as $cart) {
                    $product = Product::find($cart['id']);

                    if ($product->product_stock == 0) {
                        return redirect()->back()->with('error', 'Insufficient Stock! Please Re-Stock Product');
                    }

                    // ProductHistory::create([
                    //     'product_id' => $cart['id'],
                    //     'user_id' => auth()->user()->id,
                    //     'qty' => $product->stock,
                    //     'qty_change' => -$cart['qty'],
                    //     'note' => 'Decrease from transaction by ' . auth()->user()->name
                    // ]);

                    $product->decrement('product_stock', $cart['qty']);
                }

                // $id = IdGenerator::generate(['table' => 'transcations', 'length' => 10, 'prefix' => 'INV-', 'field' => 'invoices_number']);

                // $id = 'INV-' . date('dmY') . userCompanyId() . userBusinessUnitId() . userBranchId() . date('His');

                $order = Order::create([
                    'invoice' => 'INV-100',
                    'user_id' => auth()->user()->id,
                    'total' => $cart_total
                ]);

                $current_order_id = Order::where('invoice', 'INV-100')->get()->pluck('id')->first();

                foreach ($filterCart as $cart) {

                    Order_detail::create([
                        'order_id' => $order->id,
                        'product_id' => $cart['id'],
                        'qty' => $cart['qty'],
                        'price' => $cart['price']
                    ]);
                }

                \Cart::session(auth()->user()->id)->clear();

                DB::commit();
                return redirect()->back()->with('success', 'Transaksi Berhasil dilakukan | Klik History untuk print');
            } catch (\Exeception $e) {
                DB::rollback();
                return redirect()->back()->with('errorTransaksi', 'Error, coba lagi');
            }
        }
        return redirect()->back()->with('errorTransaksi', 'Masukan nominal yang benar');
    }
}

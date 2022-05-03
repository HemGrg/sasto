<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function addToCart(Request $request)
    {
    //     if (is_numeric($request->quantity)) {
    //         $product = Product::find($request->product_id);
    //         if (!$this->product) {
    //             return response()->json(['success' => false, 'data' => null, 'message' => 'Product Not Found.']);
    //         }

    //     $cart = session()->get('cart');

    //     // if cart is empty then this the first product
    //     if(!$cart) {

    //         $cart = [
    //                     'id' => $this->product->id,
    //                     'title' => $this->product->title,
    //                     'original_price' => $this->product->price,
    //                     'image' => asset('/uploads/product/thumbnail/' . $this->product->image),
    //                     'price' => $price['price'],
    //                     'url'   => route('product-detail', $this->product->slug),
    //         ];
            

    //         session()->put('cart', $cart);

    //         return redirect()->back()->with('success', 'Product added to cart successfully!');
    //     }

    //     // if cart not empty then check if this product exist then increment quantity
    //     if(isset($cart[$id])) {

    //         $cart[$id]['quantity']++;

    //         session()->put('cart', $cart);

    //         return redirect()->back()->with('success', 'Product added to cart successfully!');

    //     }

    //     // if item not exist in cart then add to cart with quantity = 1
    //     $cart[$id] = [
    //         "name" => $product->name,
    //         "quantity" => 1,
    //         "price" => $product->price,
    //         "photo" => $product->photo
    //     ];

    //     session()->put('cart', $cart);

    //     return redirect()->back()->with('success', 'Product added to cart successfully!');
    // }
    if (is_numeric($request->quantity)) {
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['success' => false, 'data' => null, 'message' => 'Product Not Found.']);
        }
        // $cart = []; first created this
        $cart = $request->session()->get('cart');
        // dd($cart);
        // $args = ['price' => $this->product->price, 'discount' => $this->product->discount];
        // $price = discountChecker($args);
        $current_item = [
            'id' => $product->id,
            'title' => $product->title,
            'original_price' => $product->price,
            'image' => asset('/images/thumbnail/' . $product->image),
            'price' => $product->price,
            // 'url'   => route('product-detail', $product->slug),
        ];

        if (!empty($cart)) {
            $index = null;
            foreach ($cart as $key => $cart_items) {
                // dd($cart_items['id']);
                if ($cart_items['id'] == $request->product_id) {
                    $index = $key;
                    break;
                }
            }
            if ($index !== null) {
                // dd($request->quantity);
                // cart item exists item also exists
                
                    $cart[$index]['quantity'] += (int) $request->quantity;
                    $cart[$index]['amount'] = $price['price'] * $cart[$index]['quantity'];
                    $product_quantity = $cart[$index]['quantity'];
                
            } else {
                // case cart exists  but item not exists
                $current_item['quantity'] = (int) $request->quantity;
                $current_item['amount'] = $price['price'] * $request->quantity;
                $cart[] = $current_item;
            }
        } else {
            // initial insert
            $current_item['quantity'] = (int) $request->quantity;
            $current_item['amount'] = $price['price'] * $request->quantity;
            $cart[] = $current_item;
        }
        
        Session::put('__cart', $cart);
        $total = 0;
        foreach ($cart as $key => $value) {
            $total += $value['quantity'];
        }
        // dd($cart);
        return response()->json([
            'status' => true,
            'qty' => $cart,
            'max_stock_qty' => $this->product->stock->number_of_products,
            'html' => view('front.cart-body.cart-top-menu', compact('cart'))->render(),
            'cart_top_menu_total' => view('front.cart-body.cart_top_menu_total', compact('cart'))->render(),
            'message' => "Product added to the cart Successfully.", 'total' => $total
            // , 'product_quantity' => $product_quantity
        ]);
    } else {
        return response()->json(['success' => false, 'data' => null, 'message' => 'some thing went wrong.']);
    }
    }

    public function DeleteCart($id, Request $request)
    {
        $cart = session()->pull('__cart', []);
        // dd($cart);
        $cart_index = (int) $id;
        unset($cart[$cart_index]);

        session()->put('__cart', $cart);
        $total = 0;
        foreach ($cart as $key => $value) {
            $total += $value['quantity'];
        }
        return response()->json([
            'status' => true,
            'html' => view('front.cart-body.cart-top-menu', compact('cart'))->render(),
            'cart_list' => view('front.cart-body.cart-row', compact('cart'))->render(),
            'cart_total' => view('front.cart-body.cart-total', compact('cart'))->render(),
            'message' => "Cart item deleted successfully.", 'total' => $total
        ]);
    }

    public function index()
    {
        return view('front::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('front::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('front::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('front::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

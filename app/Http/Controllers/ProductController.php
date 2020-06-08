<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validatedData = $request->validate([
            'term' => 'nullable|max:' . Constants::MAX_TERM_LENGTH,
            'property' => ['nullable', Rule::in(Constants::PROPERTY_ARRAY)],
            'type' => ['nullable', Rule::in(Constants::TYPE_ARRAY)],
            'rent_type' => ['nullable', Rule::in(Constants::RENT_TYPE_ARRAY)],
            'country' => ['nullable', 'exists:countries,name'],
            'state' => 'nullable|exists:states,name',
            'division' => 'nullable|exists:divisions,name',
            'post_code' => 'nullable|max:' . Constants::MAX_POST_CODE_LENGTH,
            'photos' => 'nullable|boolean',
            'min_area' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_AREA],
            'max_area' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_AREA],
            'min_rooms' => ['nullable', 'numeric', 'min:1', 'max:' . Constants::MAX_ROOMS],
            'max_rooms' => ['nullable', 'numeric', 'min:1', 'max:' . Constants::MAX_ROOMS],
            'min_floor' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_FLOOR],
            'max_floor' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_FLOOR],
            'min_price' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_PRICE],
            'max_price' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_PRICE],
            'min_rent' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_RENT],
            'max_rent' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_RENT],
            'max_deposit' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_DEPOSIT],
            'max_compensation' => ['nullable', 'numeric', 'min:0', 'max:' . Constants::MAX_COMPENSATION],
            'bathtub' => 'nullable|boolean',
            'balcony' => 'nullable|boolean',
            'terrace' => 'nullable|boolean',
            'garden' => 'nullable|boolean',
            'furnished' => 'nullable|boolean',
            'equipped_kitchen' => 'nullable|boolean',
            'lift' => 'nullable|boolean',
            'wlan' => 'nullable|boolean',
        ]);

        $products = Product::where('id', '>', 0);

        // filter result list (if parameters present)
        if (isset($validatedData['term']) && strlen($validatedData['term']) > 0) {
            $products = $products->where('title', 'like', '%' . $validatedData['term'] . '%');
            $products = $products->where('description', 'like', '%' . $validatedData['term'] . '%');
        }
        if (isset($validatedData['property']) && strlen($validatedData['property']) > 0) {
            $products = $products->where('property', $validatedData['property']);
        }
        if (isset($validatedData['type']) && strlen($validatedData['type']) > 0) {
            $products = $products->where('type', $validatedData['type']);
        }
        if (isset($validatedData['rent_type']) && strlen($validatedData['rent_type']) > 0) {
            $products = $products->where('rent_type', $validatedData['rent_type']);
        }
        if (isset($validatedData['country']) && strlen($validatedData['country']) > 0) {
            $products = $products->where('country', $validatedData['country']);
        }
        if (isset($validatedData['state']) && strlen($validatedData['state']) > 0) {
            $products = $products->where('state', $validatedData['state']);
        }
        if (isset($validatedData['division']) && strlen($validatedData['division']) > 0) {
            $products = $products->where('division', $validatedData['division']);
        }

        // to-do photos

        if (isset($validatedData['post_code']) && strlen($validatedData['post_code']) > 0) {
            $products = $products->where('post_code', $validatedData['post_code']);
        }
        if (isset($validatedData['min_area']) && strlen($validatedData['min_area']) > 0) {
            $products = $products->where('area', '>', $validatedData['min_area']);
        }
        if (isset($validatedData['max_area']) && strlen($validatedData['max_area']) > 0) {
            $products = $products->where('area', '<', $validatedData['max_area']);
        }
        if (isset($validatedData['min_rooms']) && strlen($validatedData['min_rooms']) > 0) {
            $products = $products->where('rooms', '>', $validatedData['min_rooms']);
        }
        if (isset($validatedData['max_rooms']) && strlen($validatedData['max_rooms']) > 0) {
            $products = $products->where('rooms', '<', $validatedData['max_rooms']);
        }
        if (isset($validatedData['min_floor']) && strlen($validatedData['min_floor']) > 0) {
            $products = $products->where('floor', '>', $validatedData['min_floor']);
        }
        if (isset($validatedData['max_floor']) && strlen($validatedData['max_floor']) > 0) {
            $products = $products->where('floor', '<', $validatedData['max_floor']);
        }
        if (isset($validatedData['min_price']) && strlen($validatedData['min_price']) > 0) {
            $products = $products->where('price', '>', $validatedData['min_price']);
        }
        if (isset($validatedData['max_price']) && strlen($validatedData['max_price']) > 0) {
            $products = $products->where('price', '<', $validatedData['max_price']);
        }
        if (isset($validatedData['min_rent']) && strlen($validatedData['min_rent']) > 0) {
            $products = $products->where('rent', '>', $validatedData['min_rent']);
        }
        if (isset($validatedData['max_rent']) && strlen($validatedData['max_rent']) > 0) {
            $products = $products->where('rent', '<', $validatedData['max_rent']);
        }
        if (isset($validatedData['max_deposit']) && strlen($validatedData['max_deposit']) > 0) {
            $products = $products->where('deposit', '<', $validatedData['max_deposit']);
        }
        if (isset($validatedData['max_compensation']) && strlen($validatedData['max_compensation']) > 0) {
            $products = $products->where('compensation', '<', $validatedData['max_compensation']);
        }
        if (isset($validatedData['bathtub']) && strlen($validatedData['bathtub']) > 0) {
            $products = $products->where('bathtub', $validatedData['bathtub']);
        }
        if (isset($validatedData['balcony']) && strlen($validatedData['balcony']) > 0) {
            $products = $products->where('balcony', $validatedData['balcony']);
        }
        if (isset($validatedData['terrace']) && strlen($validatedData['terrace']) > 0) {
            $products = $products->where('terrace', $validatedData['terrace']);
        }
        if (isset($validatedData['garden']) && strlen($validatedData['garden']) > 0) {
            $products = $products->where('garden', $validatedData['garden']);
        }
        if (isset($validatedData['furnished']) && strlen($validatedData['furnished']) > 0) {
            $products = $products->where('furnished', $validatedData['furnished']);
        }
        if (isset($validatedData['equipped_kitchen']) && strlen($validatedData['equipped_kitchen']) > 0) {
            $products = $products->where('equipped_kitchen', $validatedData['equipped_kitchen']);
        }
        if (isset($validatedData['lift']) && strlen($validatedData['lift']) > 0) {
            $products = $products->where('lift', $validatedData['lift']);
        }
        if (isset($validatedData['wlan']) && strlen($validatedData['wlan']) > 0) {
            $products = $products->where('wlan', $validatedData['wlan']);
        }

        $products = $products->take(50)->get();
        // dd(Response()->json(['products' => $products]));
        return Response()->json(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:' . Constants::MAX_TITLE_LENGTH,
            'description' => 'nullable|MAX:' . Constants::MAX_DESCRIPTION_LENGTH,
            'property' => ['required', Rule::in(Constants::PROPERTY_ARRAY)],
            'type' => [Rule::requiredIf(in_array($request->property, ['house', 'apartment'])), Rule::in(Constants::TYPE_ARRAY)],
            'rent_type' => [Rule::requiredIf(in_array($request->type, ['rent'])), Rule::in(Constants::RENT_TYPE_ARRAY)],
            'country' => ['required', 'exists:countries,name'],
            'state' => 'required|exists:states,name',
            'division' => 'exists:divisions,name',
            'street' => ['required', 'max:' . Constants::MAX_STREET_LENGTH],
            'house_no' => 'max:' . Constants::MAX_HOUSE_NO_LENGTH,
            'post_code' => 'required|max:' . Constants::MAX_POST_CODE_LENGTH,
            'street_and_house_no_visible' => 'boolean',
            'photos' => '',
            'area' => ['numeric', 'min:0', 'max:' . Constants::MAX_AREA, Rule::requiredIf(in_array($request->property, ['house', 'apartment', 'room']))],
            'rooms' => ['numeric', 'min:1', 'max:' . Constants::MAX_ROOMS, Rule::requiredIf(in_array($request->property, ['house', 'apartment']))],
            'floor' => ['numeric', 'min:0', 'max:' . Constants::MAX_FLOOR, Rule::requiredIf(in_array($request->property, ['house', 'apartment', 'room', 'bed']))],
            'build_year' => ['numeric', 'min:' . Constants::MIN_BUILD_YEAR, 'max:' . Constants::MAX_BUILD_YEAR],
            'available_from' => ['nullable', 'date_format:' . Constants::DATE_FORMAT, 'after:today'],
            'price' => [Rule::requiredIf(in_array($request->type, ['sell'])), 'numeric', 'min:0', 'max:' . Constants::MAX_PRICE],
            'rent' => [Rule::requiredIf(in_array($request->type, ['rent'])), 'numeric', 'min:0', 'max:' . Constants::MAX_RENT],
            'deposit' => ['numeric', 'min:0', 'max:' . Constants::MAX_DEPOSIT],
            'compensation' => ['numeric', 'min:0', 'max:' . Constants::MAX_COMPENSATION],
            'bathtub' => 'boolean',
            'balcony' => 'boolean',
            'terrace' => 'boolean',
            'garden' => 'boolean',
            'furnished' => 'boolean',
            'equipped_kitchen' => 'boolean',
            'lift' => 'boolean',
            'wlan' => 'boolean',
            'email_visible' => 'boolean',
            'phone_visible' => 'boolean',
        ]);

        // remove null values from request
        $validatedData = array_filter($validatedData);
        $validatedData['user_id'] = Auth::user()->id;
        $product = Product::create($validatedData)->save();
        return Response()->json(['message' => 'success', 'product' => $product]);
    }

    public function toggleFavorite(Product $product)
    {
        return Response()->json(['message' => $product->favorites()->toggle(Auth::id())]);
    }

    public function favorites()
    {
        return Auth::user()->favorites;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        return Response()->json(['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::user()->id) {
            return Response()->json([], Constants::codes()::UNAUTHORIZED);
        }
        $product->delete();
        return Response()->json(['message' => 'Item Deleted']);
    }
}

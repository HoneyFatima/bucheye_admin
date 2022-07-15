<div class="card-body">

    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Customer Details
            <address>
                <strong>{{ $order->user->name }}</strong><br>
                {{ @$order->address->area }},{{ @$order->address->area }},{{ @$order->address->city }}<br>
                Phone: (+91) {{ $order->user->mobile }}<br>
                Email: {{ $order->user->email }}
            </address>

        </div>
        {{-- <div class="col-sm-4 invoice-col">
            Vendor Details
            @foreach ($order->vendor as $vendor)
                <address>
                    <strong>{{ $vendor->name }}</strong><br>
                    {{ $vendor->location ? $vendor->location : 'NA' }}<br>
                    Phone: (+91) {{ $vendor->mobile }}<br>
                    Email: {{ $vendor->email }}<br>
                </address>
            @endforeach
            

        </div> --}}
        <div class="col-sm-4 invoice-col">
            <address>
                Order ID: {{ $order->order_number }}<br>
                Order Date: {{ $order->created_at }}<br>
                Order Status: {{ $order->order_status }}<br>
                Payment Method:Cash <br>
                Payment Status:Done
            </address>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Vendor Name</th>
                        <th>Product Price</th>
                        <th>Discount Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $key => $ord)
                        <tr>
                            <td>{{ @$ord->product_quantity }}
                            <td>
                                <img src="{{ $ord->product ? url($ord->product->thumnails) : '' }}"
                                    alt="{{ @$ord->product->name }}" width="30px;">
                                {{ @$ord->product->name }}
                            </td>
                            <td>{{ @$ord->product->user->name }}</td>
                            <td> ₹ {{ @$ord->product_price + @$ord->discount_price }}
                            </td>
                            <td> ₹ {{ $ord->discount_price }}
                            </td>
                            <td> ₹ {{ $ord->product_price }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
          
        </div>
        <div class="col-sm-6">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td> ₹ {{ $order->order_amount }}</td>
                    </tr>
                    <tr>
                        <th>Shipping:</th>
                        <td>₹ {{ $order->delivery_charge ? $order->delivery_charge : 0 }}</td>
                    </tr>
                    <tr>
                        <th>Total Discount:</th>
                        <td>₹ {{ $order->discount_price  ? $order->discount_price  : 0}}</td>
                    </tr>
                    <tr>
                        <th>Tip Amount:</th>
                        <td>₹ {{ $order->tip_amount  ? $order->tip_amount : 0}}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td> ₹ {{ $order->order_amount + $order->delivery_charge -$order->discount_price +$order->tip_amount }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

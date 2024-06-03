@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-black">
        <div class="text-center">
            <div class="flex flex-col text-neon-green">
                <h1 class="text-3xl">Pizza Order Form</h1>
                <div class="form mb-30">
                <form id="orderForm" action="{{ route('pizza.order') }}" method="post">
                    @csrf
                    <div>
                        <label for="size">Pizza Size:</label>
                        <select class="text-neon-green bg-black border border-neon-green" name="size" id="size">
                            <option value="small">Small (RM15)</option>
                            <option value="medium">Medium (RM22)</option>
                            <option value="large">Large (RM30)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label>
                            <input type="checkbox" name="pepperoni" id="pepperoni">
                            Pepperoni (+RM3)
                        </label>
                    </div>

                    <div>
                        <label>
                            <input type="checkbox" name="extra_cheese" id="extra_cheese">
                            Extra Cheese (+RM6)
                        </label>
                    </div>

                    <button type="submit" id="addOrderBtn" class="border border-neon-green text-neon-green hover:text-black hover:bg-neon-green font-bold px-4 py-2 rounded mt-4">Add Order</button>
                </form>
                </div>
                <div id="placeOrderForm" class="form mb-30 hidden">
                    <form id="placeOrderForm" action="{{ route('pizza.order') }}" method="post">
                        @csrf                    
                        <button type="submit" class="border border-neon-green text-neon-green hover:text-black hover:bg-neon-green font-bold px-4 py-2 rounded mt-4">Place Order</button>
                    </form>
                </div>
            </div>
            <div id="orderSummary" class="hidden">
                <h2 class="text-2xl">Order Summary</h2>
                <p><strong>Pizza Size:</strong> <span id="sizeValue"></span></p>
                <p><strong>Pepperoni:</strong> <span id="pepperoniValue"></span></p>
                <p><strong>Extra Cheese:</strong> <span id="extraCheeseValue"></span></p>                
            </div>
            @if(isset($total_price) && $total_price)
                <p class="text-2xl text-neon-green">Bill Total:</p>
                <div class="flex items-center justify-center">
                    <p id="totalBill" class="text-3xl text-neon-green font-bold">RM {{ $total_price }}</p>
                </div>
            @endif
        </div>
</div>

    <script>
        let orderData = {};

        document.getElementById('addOrderBtn').addEventListener('click', function(event) {
            event.preventDefault();
            orderData = {
                size: document.getElementById('size').value,
                pepperoni: document.getElementById('pepperoni').checked,
                extraCheese: document.getElementById('extra_cheese').checked,
            };

            console.log('Order data captured:', orderData);
            document.getElementById('placeOrderForm').classList.remove('hidden');
            document.getElementById('orderSummary').classList.remove('hidden');
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Set initial values for form inputs based on orderData
            document.getElementById('size').value = orderData.size;
            document.getElementById('pepperoni').checked = orderData.pepperoni;
            document.getElementById('extra_cheese').checked = orderData.extraCheese;

            // Set initial values for order summary
            document.getElementById('sizeValue').innerText = orderData.size;
            document.getElementById('pepperoniValue').innerText = orderData.pepperoni ? 'Yes' : 'No';
            document.getElementById('extraCheeseValue').innerText = orderData.extraCheese ? 'Yes' : 'No';
        })
    </script>
@endsection
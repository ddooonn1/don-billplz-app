@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-black">
    <div class="text-center">
        <div class="flex flex-col text-neon-green">
            <a href="/" class="text-l absolute top-10 left-10 text-neon-green font-bold mr-1 mb-1 transition duration-300 ease-in-out hover:text-l">↰ Back</a>
            <h1 class="text-5xl text-neon-green font-bold">Pizza</h1>
            <div class="form mb-30">
                <form id="orderForm">
                    @csrf
                    <div>
                        <label for="size">Pizza Size:</label>
                        <select class="text-neon-green bg-black border border-neon-green" name="size" id="size">
                            <option value="Small" data-price="15" >Small (RM15)</option>
                            <option value="Medium" data-price="22">Medium (RM22)</option>
                            <option value="Large" data-price="30">Large (RM30)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label>
                            <input type="checkbox" name="pepperoni" id="pepperoni" data-small-price="3" data-medium-price="5">
                            Pepperoni (Small +RM3 / Medium +RM5)
                        </label>
                    </div>

                    <div>
                        <label>
                            <input type="checkbox" name="extra_cheese" id="extra_cheese" data-price="6">
                            Extra Cheese (+RM6)
                        </label>
                    </div>

                    <button type="button" id="addOrderBtn" class="border border-neon-green text-neon-green hover:text-black hover:bg-neon-green font-bold px-4 py-2 rounded mt-4">Add Order</button>
                </form>
            </div>

            <div id="orderSummary" class="hidden">
                <h2 class="text-2xl">Order Summary</h2>
                <ul id="orderList"></ul>
                <button type="button" id="placeOrderBtn" class="border border-neon-green text-neon-green hover:text-black hover:bg-neon-green font-bold px-4 py-2 rounded mt-4">Confirm and Place Order</button>
            </div>

        </div>
    </div>
</div>

    <script>
        let orders = [];

        function toggleOrderSummary() {
            const orderSummary = document.getElementById('orderSummary');
            if (orders.length > 0) {
                orderSummary.classList.remove('hidden');
            } else {
                orderSummary.classList.add('hidden');
            }
        }

        function calculatePrice() {
            const sizeElement = document.getElementById('size');
            const size = sizeElement.value;
            const sizePrice = parseFloat(sizeElement.selectedOptions[0].getAttribute('data-price'));

            let pepperoniPrice = 0;
            if (document.getElementById('pepperoni').checked) {
                if (size === 'small') {
                    pepperoniPrice = parseFloat(document.getElementById('pepperoni').getAttribute('data-small-price'));
                } else if (size === 'medium') {
                    pepperoniPrice = parseFloat(document.getElementById('pepperoni').getAttribute('data-medium-price'));
                }
            }
            const extraCheesePrice = document.getElementById('extra_cheese').checked ? parseFloat(document.getElementById('extra_cheese').getAttribute('data-price')) : 0;
            const totalPrice = sizePrice + pepperoniPrice + extraCheesePrice;
            return totalPrice;
        }

        // When clicked 'Add Order' btn
        document.getElementById('addOrderBtn').addEventListener('click', function(event) {
            event.preventDefault();
            
            const orderData = {
                size: document.getElementById('size').value,
                pepperoni: document.getElementById('pepperoni').checked,
                extraCheese: document.getElementById('extra_cheese').checked,
            };
            
            if (orderData.size === 'large' && orderData.pepperoni) {
                alert("Extra Pepperoni is not available for Large size pizza.");
                return;
            }

            orders.push(orderData);
            toggleOrderSummary();

            document.getElementById('orderSummary').classList.remove('hidden');
            const orderList = document.getElementById('orderList');
            const orderItem = document.createElement('li');
            orderItem.innerHTML = `
                Size: ${orderData.size}, 
                Pepperoni: ${orderData.pepperoni ? 'Yes' : 'No'}, 
                Extra Cheese: ${orderData.extraCheese ? 'Yes' : 'No'}
                <span class="orderValue">Total: RM${calculatePrice(orderData).toFixed(2)}</span>
                <button class="removeOrderBtn border border-neon-green text-neon-green hover:text-black hover:bg-neon-green font-bold px-2 py-1 rounded ml-2">Remove</button>
            `;
            orderList.appendChild(orderItem);

            orderItem.querySelector('.removeOrderBtn').addEventListener('click', function() {
                const index = Array.from(orderList.children).indexOf(orderItem);
                orders.splice(index, 1);
                orderList.removeChild(orderItem);
                toggleOrderSummary();
            });

            console.log('Order data captured:', orders);
        });        

        // When order 'Place Order' btn.
        document.getElementById('placeOrderBtn').addEventListener('click', function(event) {
            event.preventDefault();

            fetch('{{ route('order.pizza') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({ orders: orders }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                alert(`Total Bill: RM${data.total}`);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });
    </script>
@endsection
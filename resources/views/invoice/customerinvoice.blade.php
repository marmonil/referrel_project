<!DOCTYPE html>
<html>

<head>
    <title>Invoice Example</title>
</head>

<body>
    <div style="font-family: Arial, sans-serif; font-size: 16px;">
        <h1 style="text-align: center;">Invoice</h1>
        <hr>
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h2>Billing Details</h2>
                <p>{{ App\Models\billing::where('order_id', $order_id)->first()->name }}</p>

                <p>{{ App\Models\billing::where('order_id', $order_id)->first()->address }}</p>
                <p>{{ App\Models\billing::where('order_id', $order_id)->first()->phpne }}</p>

            </div>
            <div>
                <h2>Invoice Details</h2>
                <p>Invoice ID:{{ App\Models\billing::where('order_id', $order_id)->first()->order_id }}</p>
                <p>Invoice Date:
                    {{ App\Models\billing::where('order_id', $order_id)->first()->created_at->format('d-m-y') }}</p>

            </div>
        </div>
        <hr>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">



            <tr>
                <th style="text-align: left; border-bottom: 1px solid #ddd;">Description</th>
                <th style="text-align: right; border-bottom: 1px solid #ddd;">Amount</th>
            </tr>

            <tr>
                <td style="padding: 10px 0;">Product 1</td>
                <td style="padding: 10px 0; text-align: right;">$100.00</td>
            </tr>
            <tr>
                <td style="padding: 10px 0;">Product 2</td>
                <td style="padding: 10px 0; text-align: right;">$50.00</td>
            </tr>
            <tr>
                <td style="padding: 10px 0;">Product 3</td>
                <td style="padding: 10px 0; text-align: right;">$75.00</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; font-weight: bold;">Total</td>
                <td style="padding: 10px 0; font-weight: bold; text-align: right;">$225.00</td>
            </tr>

        </table>
        <p style="text-align: center;">Thank you for your business!</p>
    </div>
</body>

</html>

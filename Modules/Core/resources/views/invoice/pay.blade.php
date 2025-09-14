<p style="text-align: center;font-size: 70px">Amount: {{ $virtualGateway->amount }}</p>
<p style="text-align: center;font-size: 70px">Virtual Gateway Id: {{ $virtualGateway->id }}</p>
<a href="{{ $virtualGateway->callback }}?success=1&transaction_id={{ $virtualGateway->transaction_id }}">
    <button style="font-size:80px;width: 100vw; height: 20vh;background: #1ec310">success</button></a>
<a href="{{ $virtualGateway->callback }}?success=0&transaction_id={{ $virtualGateway->transaction_id }}">
    <button style="font-size:80px;width: 100vw; height: 20vh;background: #de2f2f">failed</button></a>

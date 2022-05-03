<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connect IPS payment</title>
    <link rel="icon" href="{{ asset('/images/favicon.png') }}" type="image/gif" />
</head>
<body>
    <form action="{{ $nchl->core->gatewayUrl() }}" method="post">
        <label>MERCHANT ID</label>
        <input type="text" name="MERCHANTID" id="MERCHANTID" value="{{ $nchl->core->getMerchantId() }}"/>
        <label>APP ID</label>
        <input type="text" name="APPID" id="APPID" value="{{ $nchl->core->getAppId() }}"/>
        <label>APP NAME</label>
        <input type="text" name="APPNAME" id="APPNAME" value="{{ $nchl->core->getAppName() }}"/>
        <label>TXN ID</label>
        <input type="text" name="TXNID" id="TXNID" value="{{ $nchl->core->getTxnId() }}"/>
        <label>TXN DATE</label>
        <input type="text" name="TXNDATE" id="TXNDATE" value="{{ $nchl->core->getTxnDate() }}"/>
        <label>TXN CRNCY</label>
        <input type="text" name="TXNCRNCY" id="TXNCRNCY" value="{{ $nchl->core->getCurrency() }}"/>
        <label>TXN AMT</label>
        <input type="text" name="TXNAMT" id="TXNAMT" value="{{ $nchl->core->getTxnAmount() }}"/>
        <label>REFERENCE ID</label>
        <input type="text" name="REFERENCEID" id="REFERENCEID" value="{{ $nchl->core->getReferenceId() }}"/>
        <label>REMARKS</label>
        <input type="text" name="REMARKS" id="REMARKS" value="{{ $nchl->core->getRemarks() }}"/>
        <label>PARTICULARS</label>
        <input type="text" name="PARTICULARS" id="PARTICULARS" value="{{ $nchl->core->getParticulars() }}"/>
        <label>TOKEN</label>
        <input type="text" name="TOKEN" id="TOKEN" value="{{ $nchl->core->token() }}"/>
        <input type="submit" value="Submit">
    </form>
    
</body>
</html>
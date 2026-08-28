# Transaction


## Lister les transactions

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transactionsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":10,"idSection":9,"type":"aut","filter_value":"distinctio"}'

```

```javascript
const url = new URL(
    "http://localhost/api/transactionsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 10,
    "idSection": 9,
    "type": "aut",
    "filter_value": "distinctio"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/transactionsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 10,
            'idSection' => 9,
            'type' => 'aut',
            'filter_value' => 'distinctio',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-transactionsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transactionsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transactionsall"></code></pre>
</div>
<div id="execution-error-POSTapi-transactionsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transactionsall"></code></pre>
</div>
<form id="form-POSTapi-transactionsall" data-method="POST" data-path="api/transactionsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transactionsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transactionsall</code></b>
</p>
<p>
<label id="auth-POSTapi-transactionsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transactionsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-transactionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-transactionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-transactionsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-transactionsall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les détails d&#039;une transaction

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/transactions/sit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/transactions/sit"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/transactions/sit',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-GETapi-transactions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-transactions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-transactions--id-"></code></pre>
</div>
<div id="execution-error-GETapi-transactions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-transactions--id-"></code></pre>
</div>
<form id="form-GETapi-transactions--id-" data-method="GET" data-path="api/transactions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-transactions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/transactions/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-transactions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-transactions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-transactions--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Créer une transaction

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transactions" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"access_token":"natus","expires_in":"incidunt","order_id":{},"amount":{},"reference":{},"status":{},"message":{},"pay_token":{},"payment_url":{},"notif_token":{},"payment_mode":{},"payment_date":{},"tnxid":{},"idFee":1,"idLevel":5,"idStudent":20,"idInvoice":1,"type":{},"idSchool":19,"idSection":11,"idInscription":4,"idPension":12,"idTranche":7,"idEnseignant":8,"compteEmeteur":{},"compteRecepteur":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/transactions"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "access_token": "natus",
    "expires_in": "incidunt",
    "order_id": {},
    "amount": {},
    "reference": {},
    "status": {},
    "message": {},
    "pay_token": {},
    "payment_url": {},
    "notif_token": {},
    "payment_mode": {},
    "payment_date": {},
    "tnxid": {},
    "idFee": 1,
    "idLevel": 5,
    "idStudent": 20,
    "idInvoice": 1,
    "type": {},
    "idSchool": 19,
    "idSection": 11,
    "idInscription": 4,
    "idPension": 12,
    "idTranche": 7,
    "idEnseignant": 8,
    "compteEmeteur": {},
    "compteRecepteur": {}
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/transactions',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'access_token' => 'natus',
            'expires_in' => 'incidunt',
            'order_id' => [],
            'amount' => [],
            'reference' => [],
            'status' => [],
            'message' => [],
            'pay_token' => [],
            'payment_url' => [],
            'notif_token' => [],
            'payment_mode' => [],
            'payment_date' => [],
            'tnxid' => [],
            'idFee' => 1,
            'idLevel' => 5,
            'idStudent' => 20,
            'idInvoice' => 1,
            'type' => [],
            'idSchool' => 19,
            'idSection' => 11,
            'idInscription' => 4,
            'idPension' => 12,
            'idTranche' => 7,
            'idEnseignant' => 8,
            'compteEmeteur' => [],
            'compteRecepteur' => [],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-transactions" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transactions"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transactions"></code></pre>
</div>
<div id="execution-error-POSTapi-transactions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transactions"></code></pre>
</div>
<form id="form-POSTapi-transactions" data-method="POST" data-path="api/transactions" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transactions', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transactions</code></b>
</p>
<p>
<label id="auth-POSTapi-transactions" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transactions" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>access_token</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="access_token" data-endpoint="POSTapi-transactions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>expires_in</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="expires_in" data-endpoint="POSTapi-transactions" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>order_id</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="order_id" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="amount" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>message</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="message" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pay_token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="pay_token" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_url</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_url" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>notif_token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="notif_token" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_date" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>tnxid</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="tnxid" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idFee" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idInvoice</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idInvoice" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idInscription</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idInscription" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTranche</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTranche" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idEnseignant</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idEnseignant" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>compteEmeteur</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="compteEmeteur" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>compteRecepteur</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="compteRecepteur" data-endpoint="POSTapi-transactions" data-component="body"  hidden>
<br>

</p>

</form>


## maj des infos d&#039;une transaction

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/transactions/6" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"access_token":"odit","expires_in":"vitae","order_id":{},"amount":{},"reference":{},"status":{},"message":{},"pay_token":{},"payment_url":{},"notif_token":{},"payment_mode":{},"payment_date":{},"tnxid":{},"idFee":20,"idLevel":16,"idStudent":13,"idInvoice":4,"type":{},"idSchool":11,"idSection":12,"idInscription":20,"idPension":16,"idTranche":10,"idEnseignant":2,"compteEmeteur":{},"compteRecepteur":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/transactions/6"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "access_token": "odit",
    "expires_in": "vitae",
    "order_id": {},
    "amount": {},
    "reference": {},
    "status": {},
    "message": {},
    "pay_token": {},
    "payment_url": {},
    "notif_token": {},
    "payment_mode": {},
    "payment_date": {},
    "tnxid": {},
    "idFee": 20,
    "idLevel": 16,
    "idStudent": 13,
    "idInvoice": 4,
    "type": {},
    "idSchool": 11,
    "idSection": 12,
    "idInscription": 20,
    "idPension": 16,
    "idTranche": 10,
    "idEnseignant": 2,
    "compteEmeteur": {},
    "compteRecepteur": {}
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/transactions/6',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'access_token' => 'odit',
            'expires_in' => 'vitae',
            'order_id' => [],
            'amount' => [],
            'reference' => [],
            'status' => [],
            'message' => [],
            'pay_token' => [],
            'payment_url' => [],
            'notif_token' => [],
            'payment_mode' => [],
            'payment_date' => [],
            'tnxid' => [],
            'idFee' => 20,
            'idLevel' => 16,
            'idStudent' => 13,
            'idInvoice' => 4,
            'type' => [],
            'idSchool' => 11,
            'idSection' => 12,
            'idInscription' => 20,
            'idPension' => 16,
            'idTranche' => 10,
            'idEnseignant' => 2,
            'compteEmeteur' => [],
            'compteRecepteur' => [],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-PUTapi-transactions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-transactions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-transactions--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-transactions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-transactions--id-"></code></pre>
</div>
<form id="form-PUTapi-transactions--id-" data-method="PUT" data-path="api/transactions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-transactions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/transactions/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-transactions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-transactions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="PUTapi-transactions--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>access_token</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="access_token" data-endpoint="PUTapi-transactions--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>expires_in</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="expires_in" data-endpoint="PUTapi-transactions--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>order_id</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="order_id" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="amount" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>message</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="message" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pay_token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="pay_token" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_url</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_url" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>notif_token</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="notif_token" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_date" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>tnxid</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="tnxid" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idFee</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idFee" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idInvoice</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idInvoice" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idInscription</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idInscription" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idPension</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idPension" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTranche</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTranche" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idEnseignant</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idEnseignant" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>compteEmeteur</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="compteEmeteur" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>compteRecepteur</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="compteRecepteur" data-endpoint="PUTapi-transactions--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprimer une transaction

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/transactions/17" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/transactions/17"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/transactions/17',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-DELETEapi-transactions--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-transactions--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-transactions--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-transactions--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-transactions--id-"></code></pre>
</div>
<form id="form-DELETEapi-transactions--id-" data-method="DELETE" data-path="api/transactions/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-transactions--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/transactions/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-transactions--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-transactions--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="DELETEapi-transactions--id-" data-component="url" required  hidden>
<br>

</p>
</form>




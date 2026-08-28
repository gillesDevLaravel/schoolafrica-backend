# Gestion des Paiements des Utilisateurs de Transport


## Récupère la liste paginée des paiements.

<small class="badge badge-darkred">requires authentication</small>

Permet de filtrer par `student_id` et `transport_id`.
 La pagination est configurable via `pageItems` (page actuelle) et `nbreItems` (nombre d'éléments par page).

> Example request:

```bash
curl -X POST \
    "http://localhost/api/payment-transport-usersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"nbreItems":16,"pageItems":14,"transport_user_id":7,"payment_date":"2025-11-22T14:46:53+0000","payment_mode":"corporis","solvable":"accusantium","receipt_number":"laboriosam","telephone":"commodi","reference":"doloribus","created_by":8,"updated_by":1,"deleted_by":9}'

```

```javascript
const url = new URL(
    "http://localhost/api/payment-transport-usersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "nbreItems": 16,
    "pageItems": 14,
    "transport_user_id": 7,
    "payment_date": "2025-11-22T14:46:53+0000",
    "payment_mode": "corporis",
    "solvable": "accusantium",
    "receipt_number": "laboriosam",
    "telephone": "commodi",
    "reference": "doloribus",
    "created_by": 8,
    "updated_by": 1,
    "deleted_by": 9
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
    'http://localhost/api/payment-transport-usersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'nbreItems' => 16,
            'pageItems' => 14,
            'transport_user_id' => 7,
            'payment_date' => '2025-11-22T14:46:53+0000',
            'payment_mode' => 'corporis',
            'solvable' => 'accusantium',
            'receipt_number' => 'laboriosam',
            'telephone' => 'commodi',
            'reference' => 'doloribus',
            'created_by' => 8,
            'updated_by' => 1,
            'deleted_by' => 9,
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
<div id="execution-results-POSTapi-payment-transport-usersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-payment-transport-usersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-payment-transport-usersall"></code></pre>
</div>
<div id="execution-error-POSTapi-payment-transport-usersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-payment-transport-usersall"></code></pre>
</div>
<form id="form-POSTapi-payment-transport-usersall" data-method="POST" data-path="api/payment-transport-usersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-payment-transport-usersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/payment-transport-usersall</code></b>
</p>
<p>
<label id="auth-POSTapi-payment-transport-usersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-payment-transport-usersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>transport_user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="transport_user_id" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_date" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>solvable</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="solvable" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>created_by</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="created_by" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>updated_by</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="updated_by" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>deleted_by</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="deleted_by" data-endpoint="POSTapi-payment-transport-usersall" data-component="body"  hidden>
<br>

</p>

</form>


## Crée un nouveau paiement pour un utilisateur de transport.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/payment-transport-users" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"transport_user_id":7,"advance_payment":0,"balance_payment":45.2,"payment_date":"2025-11-22T14:46:54+0000","payment_mode":"eveniet","scan_receipt":"quas","photo":"et","reason":"consequatur","receipt_number":"assumenda","telephone":"quos","reference":"sed"}'

```

```javascript
const url = new URL(
    "http://localhost/api/payment-transport-users"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "transport_user_id": 7,
    "advance_payment": 0,
    "balance_payment": 45.2,
    "payment_date": "2025-11-22T14:46:54+0000",
    "payment_mode": "eveniet",
    "scan_receipt": "quas",
    "photo": "et",
    "reason": "consequatur",
    "receipt_number": "assumenda",
    "telephone": "quos",
    "reference": "sed"
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
    'http://localhost/api/payment-transport-users',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'transport_user_id' => 7,
            'advance_payment' => 0.0,
            'balance_payment' => 45.2,
            'payment_date' => '2025-11-22T14:46:54+0000',
            'payment_mode' => 'eveniet',
            'scan_receipt' => 'quas',
            'photo' => 'et',
            'reason' => 'consequatur',
            'receipt_number' => 'assumenda',
            'telephone' => 'quos',
            'reference' => 'sed',
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
<div id="execution-results-POSTapi-payment-transport-users" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-payment-transport-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-payment-transport-users"></code></pre>
</div>
<div id="execution-error-POSTapi-payment-transport-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-payment-transport-users"></code></pre>
</div>
<form id="form-POSTapi-payment-transport-users" data-method="POST" data-path="api/payment-transport-users" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-payment-transport-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/payment-transport-users</code></b>
</p>
<p>
<label id="auth-POSTapi-payment-transport-users" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-payment-transport-users" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>transport_user_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="transport_user_id" data-endpoint="POSTapi-payment-transport-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>advance_payment</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="advance_payment" data-endpoint="POSTapi-payment-transport-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>balance_payment</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="balance_payment" data-endpoint="POSTapi-payment-transport-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_date" data-endpoint="POSTapi-payment-transport-users" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_mode" data-endpoint="POSTapi-payment-transport-users" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>scan_receipt</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="scan_receipt" data-endpoint="POSTapi-payment-transport-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>photo</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="photo" data-endpoint="POSTapi-payment-transport-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-payment-transport-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="POSTapi-payment-transport-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="POSTapi-payment-transport-users" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="POSTapi-payment-transport-users" data-component="body"  hidden>
<br>

</p>

</form>


## Affiche les détails d&#039;un paiement spécifique.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/payment-transport-users/molestiae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/payment-transport-users/molestiae"
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
    'http://localhost/api/payment-transport-users/molestiae',
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
<div id="execution-results-GETapi-payment-transport-users--payment_transport_user-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-payment-transport-users--payment_transport_user-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-payment-transport-users--payment_transport_user-"></code></pre>
</div>
<div id="execution-error-GETapi-payment-transport-users--payment_transport_user-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-payment-transport-users--payment_transport_user-"></code></pre>
</div>
<form id="form-GETapi-payment-transport-users--payment_transport_user-" data-method="GET" data-path="api/payment-transport-users/{payment_transport_user}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-payment-transport-users--payment_transport_user-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/payment-transport-users/{payment_transport_user}</code></b>
</p>
<p>
<label id="auth-GETapi-payment-transport-users--payment_transport_user-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-payment-transport-users--payment_transport_user-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>payment_transport_user</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_transport_user" data-endpoint="GETapi-payment-transport-users--payment_transport_user-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour un paiement existant.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/payment-transport-users/quas" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"transport_user_id":1,"advance_payment":32410.351952927,"balance_payment":19019.576700867,"payment_date":"2025-11-22T14:46:54+0000","payment_mode":"ut","solvable":"aut","scan_receipt":"ut","photo":"quibusdam","reason":"quis","receipt_number":"dolor","telephone":"veritatis","reference":"quisquam"}'

```

```javascript
const url = new URL(
    "http://localhost/api/payment-transport-users/quas"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "transport_user_id": 1,
    "advance_payment": 32410.351952927,
    "balance_payment": 19019.576700867,
    "payment_date": "2025-11-22T14:46:54+0000",
    "payment_mode": "ut",
    "solvable": "aut",
    "scan_receipt": "ut",
    "photo": "quibusdam",
    "reason": "quis",
    "receipt_number": "dolor",
    "telephone": "veritatis",
    "reference": "quisquam"
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
    'http://localhost/api/payment-transport-users/quas',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'transport_user_id' => 1,
            'advance_payment' => 32410.351952927,
            'balance_payment' => 19019.576700867,
            'payment_date' => '2025-11-22T14:46:54+0000',
            'payment_mode' => 'ut',
            'solvable' => 'aut',
            'scan_receipt' => 'ut',
            'photo' => 'quibusdam',
            'reason' => 'quis',
            'receipt_number' => 'dolor',
            'telephone' => 'veritatis',
            'reference' => 'quisquam',
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
<div id="execution-results-PUTapi-payment-transport-users--payment_transport_user-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-payment-transport-users--payment_transport_user-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-payment-transport-users--payment_transport_user-"></code></pre>
</div>
<div id="execution-error-PUTapi-payment-transport-users--payment_transport_user-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-payment-transport-users--payment_transport_user-"></code></pre>
</div>
<form id="form-PUTapi-payment-transport-users--payment_transport_user-" data-method="PUT" data-path="api/payment-transport-users/{payment_transport_user}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-payment-transport-users--payment_transport_user-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/payment-transport-users/{payment_transport_user}</code></b>
</p>
<p>
<label id="auth-PUTapi-payment-transport-users--payment_transport_user-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>payment_transport_user</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_transport_user" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>transport_user_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="transport_user_id" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>advance_payment</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="advance_payment" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>balance_payment</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="balance_payment" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_date" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>payment_mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_mode" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>solvable</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="solvable" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>scan_receipt</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="scan_receipt" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>photo</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="photo" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>telephone</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="telephone" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reference</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reference" data-endpoint="PUTapi-payment-transport-users--payment_transport_user-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprime temporairement un ou plusieurs paiements (mise à la corbeille).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/payment-transport-users/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[14,2]}'

```

```javascript
const url = new URL(
    "http://localhost/api/payment-transport-users/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        14,
        2
    ]
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
    'http://localhost/api/payment-transport-users/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                14,
                2,
            ],
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
<div id="execution-results-POSTapi-payment-transport-users-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-payment-transport-users-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-payment-transport-users-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-payment-transport-users-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-payment-transport-users-trash"></code></pre>
</div>
<form id="form-POSTapi-payment-transport-users-trash" data-method="POST" data-path="api/payment-transport-users/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-payment-transport-users-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/payment-transport-users/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-payment-transport-users-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-payment-transport-users-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-payment-transport-users-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-payment-transport-users-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure un ou plusieurs paiements supprimés.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/payment-transport-users/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[1,1]}'

```

```javascript
const url = new URL(
    "http://localhost/api/payment-transport-users/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        1,
        1
    ]
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
    'http://localhost/api/payment-transport-users/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                1,
                1,
            ],
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
<div id="execution-results-POSTapi-payment-transport-users-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-payment-transport-users-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-payment-transport-users-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-payment-transport-users-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-payment-transport-users-restore"></code></pre>
</div>
<form id="form-POSTapi-payment-transport-users-restore" data-method="POST" data-path="api/payment-transport-users/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-payment-transport-users-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/payment-transport-users/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-payment-transport-users-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-payment-transport-users-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-payment-transport-users-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-payment-transport-users-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement un ou plusieurs paiements.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/payment-transport-users/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[16,1]}'

```

```javascript
const url = new URL(
    "http://localhost/api/payment-transport-users/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        16,
        1
    ]
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
    'http://localhost/api/payment-transport-users/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                16,
                1,
            ],
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
<div id="execution-results-POSTapi-payment-transport-users-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-payment-transport-users-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-payment-transport-users-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-payment-transport-users-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-payment-transport-users-delete"></code></pre>
</div>
<form id="form-POSTapi-payment-transport-users-delete" data-method="POST" data-path="api/payment-transport-users/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-payment-transport-users-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/payment-transport-users/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-payment-transport-users-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-payment-transport-users-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-payment-transport-users-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-payment-transport-users-delete" data-component="body" hidden>
<br>

</p>

</form>




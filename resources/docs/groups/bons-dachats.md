# Bons d'achats

Gestion des bons d'achat

## Afficher une liste filtrée des bons d&#039;achat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/purchase-ordersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":16,"nbreItems":5,"filter_value":"sit","status":"delivered","priority":"low","supplier_id":{},"responsible_id":{},"article_ids":[2,16]}'

```

```javascript
const url = new URL(
    "http://localhost/api/purchase-ordersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 16,
    "nbreItems": 5,
    "filter_value": "sit",
    "status": "delivered",
    "priority": "low",
    "supplier_id": {},
    "responsible_id": {},
    "article_ids": [
        2,
        16
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
    'http://localhost/api/purchase-ordersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 16,
            'nbreItems' => 5,
            'filter_value' => 'sit',
            'status' => 'delivered',
            'priority' => 'low',
            'supplier_id' => [],
            'responsible_id' => [],
            'article_ids' => [
                2,
                16,
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
<div id="execution-results-POSTapi-purchase-ordersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-purchase-ordersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-purchase-ordersall"></code></pre>
</div>
<div id="execution-error-POSTapi-purchase-ordersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-purchase-ordersall"></code></pre>
</div>
<form id="form-POSTapi-purchase-ordersall" data-method="POST" data-path="api/purchase-ordersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-purchase-ordersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/purchase-ordersall</code></b>
</p>
<p>
<label id="auth-POSTapi-purchase-ordersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-purchase-ordersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-purchase-ordersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-purchase-ordersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-purchase-ordersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-purchase-ordersall" data-component="body"  hidden>
<br>
The value must be one of <code>requesting_price</code>, <code>purchase_order</code>, <code>paid</code>, or <code>delivered</code>.
</p>
<p>
<b><code>priority</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="priority" data-endpoint="POSTapi-purchase-ordersall" data-component="body"  hidden>
<br>
The value must be one of <code>low</code>, <code>medium</code>, or <code>high</code>.
</p>
<p>
<b><code>supplier_id</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="supplier_id" data-endpoint="POSTapi-purchase-ordersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>responsible_id</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="responsible_id" data-endpoint="POSTapi-purchase-ordersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>article_ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="article_ids.0" data-endpoint="POSTapi-purchase-ordersall" data-component="body"  hidden>
<input type="number" name="article_ids.1" data-endpoint="POSTapi-purchase-ordersall" data-component="body" hidden>
<br>

</p>

</form>


## Enregistrer un bon d&#039;achat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/purchase-orders" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"supplier_id":5,"responsible_id":12,"description":"aut","status":"delivered","payment_method":"OM","priority":"high","quotation_file":"autem","articles":[{"id":17,"unit_price":5,"quantity":4}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/purchase-orders"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "supplier_id": 5,
    "responsible_id": 12,
    "description": "aut",
    "status": "delivered",
    "payment_method": "OM",
    "priority": "high",
    "quotation_file": "autem",
    "articles": [
        {
            "id": 17,
            "unit_price": 5,
            "quantity": 4
        }
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
    'http://localhost/api/purchase-orders',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'supplier_id' => 5,
            'responsible_id' => 12,
            'description' => 'aut',
            'status' => 'delivered',
            'payment_method' => 'OM',
            'priority' => 'high',
            'quotation_file' => 'autem',
            'articles' => [
                [
                    'id' => 17,
                    'unit_price' => 5,
                    'quantity' => 4,
                ],
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
<div id="execution-results-POSTapi-purchase-orders" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-purchase-orders"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-purchase-orders"></code></pre>
</div>
<div id="execution-error-POSTapi-purchase-orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-purchase-orders"></code></pre>
</div>
<form id="form-POSTapi-purchase-orders" data-method="POST" data-path="api/purchase-orders" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-purchase-orders', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/purchase-orders</code></b>
</p>
<p>
<label id="auth-POSTapi-purchase-orders" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-purchase-orders" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>supplier_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="supplier_id" data-endpoint="POSTapi-purchase-orders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>responsible_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="responsible_id" data-endpoint="POSTapi-purchase-orders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-purchase-orders" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-purchase-orders" data-component="body"  hidden>
<br>
The value must be one of <code>requesting_price</code>, <code>purchase_order</code>, <code>paid</code>, or <code>delivered</code>.
</p>
<p>
<b><code>payment_method</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_method" data-endpoint="POSTapi-purchase-orders" data-component="body"  hidden>
<br>
The value must be one of <code>Cash</code>, <code>Bank</code>, <code>OM</code>, or <code>MOMO</code>.
</p>
<p>
<b><code>priority</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="priority" data-endpoint="POSTapi-purchase-orders" data-component="body" required  hidden>
<br>
The value must be one of <code>low</code>, <code>medium</code>, or <code>high</code>.
</p>
<p>
<b><code>quotation_file</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="quotation_file" data-endpoint="POSTapi-purchase-orders" data-component="body"  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>articles</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>articles[].id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.id" data-endpoint="POSTapi-purchase-orders" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>articles[].unit_price</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.unit_price" data-endpoint="POSTapi-purchase-orders" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].quantity</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="articles.0.quantity" data-endpoint="POSTapi-purchase-orders" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher un bon d&#039;achat spécifique

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/purchase-orders/expedita" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/purchase-orders/expedita"
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
    'http://localhost/api/purchase-orders/expedita',
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
<div id="execution-results-GETapi-purchase-orders--purchase_order-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-purchase-orders--purchase_order-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-purchase-orders--purchase_order-"></code></pre>
</div>
<div id="execution-error-GETapi-purchase-orders--purchase_order-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-purchase-orders--purchase_order-"></code></pre>
</div>
<form id="form-GETapi-purchase-orders--purchase_order-" data-method="GET" data-path="api/purchase-orders/{purchase_order}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-purchase-orders--purchase_order-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/purchase-orders/{purchase_order}</code></b>
</p>
<p>
<label id="auth-GETapi-purchase-orders--purchase_order-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-purchase-orders--purchase_order-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>purchase_order</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="purchase_order" data-endpoint="GETapi-purchase-orders--purchase_order-" data-component="url" required  hidden>
<br>

</p>
</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/purchase-orders/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"supplier_id":1,"responsible_id":15,"description":"aut","status":"purchase_order","payment_method":"MOMO","priority":"low","quotation_file":"iusto","articles":[{"id":15,"unit_price":3,"quantity":19}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/purchase-orders/et"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "supplier_id": 1,
    "responsible_id": 15,
    "description": "aut",
    "status": "purchase_order",
    "payment_method": "MOMO",
    "priority": "low",
    "quotation_file": "iusto",
    "articles": [
        {
            "id": 15,
            "unit_price": 3,
            "quantity": 19
        }
    ]
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
    'http://localhost/api/purchase-orders/et',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'supplier_id' => 1,
            'responsible_id' => 15,
            'description' => 'aut',
            'status' => 'purchase_order',
            'payment_method' => 'MOMO',
            'priority' => 'low',
            'quotation_file' => 'iusto',
            'articles' => [
                [
                    'id' => 15,
                    'unit_price' => 3,
                    'quantity' => 19,
                ],
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
<div id="execution-results-PUTapi-purchase-orders--purchase_order-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-purchase-orders--purchase_order-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-purchase-orders--purchase_order-"></code></pre>
</div>
<div id="execution-error-PUTapi-purchase-orders--purchase_order-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-purchase-orders--purchase_order-"></code></pre>
</div>
<form id="form-PUTapi-purchase-orders--purchase_order-" data-method="PUT" data-path="api/purchase-orders/{purchase_order}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-purchase-orders--purchase_order-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/purchase-orders/{purchase_order}</code></b>
</p>
<p>
<label id="auth-PUTapi-purchase-orders--purchase_order-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>purchase_order</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="purchase_order" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>supplier_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="supplier_id" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>responsible_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="responsible_id" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>
The value must be one of <code>requesting_price</code>, <code>purchase_order</code>, <code>paid</code>, or <code>delivered</code>.
</p>
<p>
<b><code>payment_method</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_method" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>
The value must be one of <code>Cash</code>, <code>Bank</code>, <code>OM</code>, or <code>MOMO</code>.
</p>
<p>
<b><code>priority</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="priority" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>
The value must be one of <code>low</code>, <code>medium</code>, or <code>high</code>.
</p>
<p>
<b><code>quotation_file</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="quotation_file" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>

</p>
<p>
<details>
<summary>
<b><code>articles</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>articles[].id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.id" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].unit_price</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.unit_price" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>articles[].quantity</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="articles.0.quantity" data-endpoint="PUTapi-purchase-orders--purchase_order-" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Fonction pour le multiple archivage des bonds d&#039;achat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/purchase-orders/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[2,11]}'

```

```javascript
const url = new URL(
    "http://localhost/api/purchase-orders/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        2,
        11
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
    'http://localhost/api/purchase-orders/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                2,
                11,
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
<div id="execution-results-POSTapi-purchase-orders-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-purchase-orders-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-purchase-orders-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-purchase-orders-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-purchase-orders-trash"></code></pre>
</div>
<form id="form-POSTapi-purchase-orders-trash" data-method="POST" data-path="api/purchase-orders/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-purchase-orders-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/purchase-orders/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-purchase-orders-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-purchase-orders-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-purchase-orders-trash" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-purchase-orders-trash" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de restauration multiples des bonds d&#039;achat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/purchase-orders/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[12,8]}'

```

```javascript
const url = new URL(
    "http://localhost/api/purchase-orders/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        12,
        8
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
    'http://localhost/api/purchase-orders/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                12,
                8,
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
<div id="execution-results-POSTapi-purchase-orders-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-purchase-orders-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-purchase-orders-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-purchase-orders-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-purchase-orders-restore"></code></pre>
</div>
<form id="form-POSTapi-purchase-orders-restore" data-method="POST" data-path="api/purchase-orders/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-purchase-orders-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/purchase-orders/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-purchase-orders-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-purchase-orders-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-purchase-orders-restore" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-purchase-orders-restore" data-component="body" hidden>
<br>

</p>

</form>


## Fonction de suppression définitive multiple des bonds d&#039;achat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/purchase-orders/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[19,19]}'

```

```javascript
const url = new URL(
    "http://localhost/api/purchase-orders/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        19,
        19
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
    'http://localhost/api/purchase-orders/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                19,
                19,
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
<div id="execution-results-POSTapi-purchase-orders-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-purchase-orders-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-purchase-orders-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-purchase-orders-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-purchase-orders-delete"></code></pre>
</div>
<form id="form-POSTapi-purchase-orders-delete" data-method="POST" data-path="api/purchase-orders/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-purchase-orders-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/purchase-orders/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-purchase-orders-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-purchase-orders-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-purchase-orders-delete" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-purchase-orders-delete" data-component="body" hidden>
<br>

</p>

</form>




# Transports


## Récupère la liste paginée des transports.

<small class="badge badge-darkred">requires authentication</small>

Permet de filtrer par nom ou description via le paramètre `filter_value`.
La pagination est configurable via `pageItems` (page actuelle) et `nbreItems` (nombre d'éléments par page).

> Example request:

```bash
curl -X POST \
    "http://localhost/api/transportsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"filter_value":"omnis","nbreItems":5,"pageItems":9}'

```

```javascript
const url = new URL(
    "http://localhost/api/transportsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "filter_value": "omnis",
    "nbreItems": 5,
    "pageItems": 9
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
    'http://localhost/api/transportsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'filter_value' => 'omnis',
            'nbreItems' => 5,
            'pageItems' => 9,
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
<div id="execution-results-POSTapi-transportsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transportsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transportsall"></code></pre>
</div>
<div id="execution-error-POSTapi-transportsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transportsall"></code></pre>
</div>
<form id="form-POSTapi-transportsall" data-method="POST" data-path="api/transportsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transportsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transportsall</code></b>
</p>
<p>
<label id="auth-POSTapi-transportsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transportsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-transportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-transportsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-transportsall" data-component="body"  hidden>
<br>

</p>

</form>


## Crée un nouveau transport.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transports" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"itaque","remark":"pariatur","description":"aliquam","amount_month":63496.7706516,"amount_terms1":1078704.329665401,"amount_terms2":27,"amount_terms3":2376.4391,"amount":47631079.33}'

```

```javascript
const url = new URL(
    "http://localhost/api/transports"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "itaque",
    "remark": "pariatur",
    "description": "aliquam",
    "amount_month": 63496.7706516,
    "amount_terms1": 1078704.329665401,
    "amount_terms2": 27,
    "amount_terms3": 2376.4391,
    "amount": 47631079.33
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
    'http://localhost/api/transports',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'itaque',
            'remark' => 'pariatur',
            'description' => 'aliquam',
            'amount_month' => 63496.7706516,
            'amount_terms1' => 1078704.329665401,
            'amount_terms2' => 27.0,
            'amount_terms3' => 2376.4391,
            'amount' => 47631079.33,
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
<div id="execution-results-POSTapi-transports" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transports"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transports"></code></pre>
</div>
<div id="execution-error-POSTapi-transports" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transports"></code></pre>
</div>
<form id="form-POSTapi-transports" data-method="POST" data-path="api/transports" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transports', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transports</code></b>
</p>
<p>
<label id="auth-POSTapi-transports" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transports" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-transports" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>remark</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="remark" data-endpoint="POSTapi-transports" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-transports" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_month</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_month" data-endpoint="POSTapi-transports" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_terms1</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_terms1" data-endpoint="POSTapi-transports" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_terms2</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_terms2" data-endpoint="POSTapi-transports" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_terms3</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_terms3" data-endpoint="POSTapi-transports" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="amount" data-endpoint="POSTapi-transports" data-component="body" required  hidden>
<br>

</p>

</form>


## Affiche les détails d&#039;un transport.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/transports/iusto" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/transports/iusto"
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
    'http://localhost/api/transports/iusto',
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
<div id="execution-results-GETapi-transports--transport-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-transports--transport-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-transports--transport-"></code></pre>
</div>
<div id="execution-error-GETapi-transports--transport-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-transports--transport-"></code></pre>
</div>
<form id="form-GETapi-transports--transport-" data-method="GET" data-path="api/transports/{transport}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-transports--transport-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/transports/{transport}</code></b>
</p>
<p>
<label id="auth-GETapi-transports--transport-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-transports--transport-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>transport</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="transport" data-endpoint="GETapi-transports--transport-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour un transport existant.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/transports/quis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"repudiandae","remark":"autem","description":"consequatur","amount_month":810835.04981,"amount_terms1":3693603.14664978,"amount_terms2":97346.570189446,"amount_terms3":1.31130138,"amount":109}'

```

```javascript
const url = new URL(
    "http://localhost/api/transports/quis"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "repudiandae",
    "remark": "autem",
    "description": "consequatur",
    "amount_month": 810835.04981,
    "amount_terms1": 3693603.14664978,
    "amount_terms2": 97346.570189446,
    "amount_terms3": 1.31130138,
    "amount": 109
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
    'http://localhost/api/transports/quis',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'repudiandae',
            'remark' => 'autem',
            'description' => 'consequatur',
            'amount_month' => 810835.04981,
            'amount_terms1' => 3693603.14664978,
            'amount_terms2' => 97346.570189446,
            'amount_terms3' => 1.31130138,
            'amount' => 109.0,
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
<div id="execution-results-PUTapi-transports--transport-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-transports--transport-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-transports--transport-"></code></pre>
</div>
<div id="execution-error-PUTapi-transports--transport-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-transports--transport-"></code></pre>
</div>
<form id="form-PUTapi-transports--transport-" data-method="PUT" data-path="api/transports/{transport}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-transports--transport-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/transports/{transport}</code></b>
</p>
<p>
<label id="auth-PUTapi-transports--transport-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-transports--transport-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>transport</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="transport" data-endpoint="PUTapi-transports--transport-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-transports--transport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>remark</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="remark" data-endpoint="PUTapi-transports--transport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-transports--transport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_month</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_month" data-endpoint="PUTapi-transports--transport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_terms1</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_terms1" data-endpoint="PUTapi-transports--transport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_terms2</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_terms2" data-endpoint="PUTapi-transports--transport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_terms3</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_terms3" data-endpoint="PUTapi-transports--transport-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount" data-endpoint="PUTapi-transports--transport-" data-component="body"  hidden>
<br>

</p>

</form>


## Supprime temporairement un ou plusieurs transports (mise à la corbeille).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transports/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[17,16]}'

```

```javascript
const url = new URL(
    "http://localhost/api/transports/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        17,
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
    'http://localhost/api/transports/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                17,
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
<div id="execution-results-POSTapi-transports-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transports-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transports-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-transports-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transports-trash"></code></pre>
</div>
<form id="form-POSTapi-transports-trash" data-method="POST" data-path="api/transports/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transports-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transports/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-transports-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transports-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-transports-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-transports-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure un ou plusieurs transports supprimés.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transports/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[6,20]}'

```

```javascript
const url = new URL(
    "http://localhost/api/transports/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        6,
        20
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
    'http://localhost/api/transports/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                6,
                20,
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
<div id="execution-results-POSTapi-transports-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transports-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transports-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-transports-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transports-restore"></code></pre>
</div>
<form id="form-POSTapi-transports-restore" data-method="POST" data-path="api/transports/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transports-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transports/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-transports-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transports-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-transports-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-transports-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement un ou plusieurs transports.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/transports/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[17,6]}'

```

```javascript
const url = new URL(
    "http://localhost/api/transports/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        17,
        6
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
    'http://localhost/api/transports/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                17,
                6,
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
<div id="execution-results-POSTapi-transports-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-transports-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-transports-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-transports-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-transports-delete"></code></pre>
</div>
<form id="form-POSTapi-transports-delete" data-method="POST" data-path="api/transports/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-transports-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/transports/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-transports-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-transports-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-transports-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-transports-delete" data-component="body" hidden>
<br>

</p>

</form>




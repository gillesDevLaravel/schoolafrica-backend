# Gestion des reçus scannés

API pour gérer les reçus scannés des paiements pour les utilisateurs.

## Liste les reçus scannés avec pagination et filtres.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/scan-receiptsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":18,"nbreItems":3,"filter_value":"non","idAcademicYear":13,"idSchool":12,"idStudent":8,"image_scan":"delectus","created_at":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/scan-receiptsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 18,
    "nbreItems": 3,
    "filter_value": "non",
    "idAcademicYear": 13,
    "idSchool": 12,
    "idStudent": 8,
    "image_scan": "delectus",
    "created_at": {}
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
    'http://localhost/api/scan-receiptsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 18,
            'nbreItems' => 3,
            'filter_value' => 'non',
            'idAcademicYear' => 13,
            'idSchool' => 12,
            'idStudent' => 8,
            'image_scan' => 'delectus',
            'created_at' => [],
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
<div id="execution-results-POSTapi-scan-receiptsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-scan-receiptsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-scan-receiptsall"></code></pre>
</div>
<div id="execution-error-POSTapi-scan-receiptsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-scan-receiptsall"></code></pre>
</div>
<form id="form-POSTapi-scan-receiptsall" data-method="POST" data-path="api/scan-receiptsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-scan-receiptsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/scan-receiptsall</code></b>
</p>
<p>
<label id="auth-POSTapi-scan-receiptsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-scan-receiptsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-scan-receiptsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-scan-receiptsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-scan-receiptsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idAcademicYear</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAcademicYear" data-endpoint="POSTapi-scan-receiptsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-scan-receiptsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-scan-receiptsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>image_scan</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image_scan" data-endpoint="POSTapi-scan-receiptsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>created_at</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="created_at" data-endpoint="POSTapi-scan-receiptsall" data-component="body"  hidden>
<br>

</p>

</form>


## Crée un nouveau reçu scanné.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/scan-receipts" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idAcademicYear":17,"idSchool":11,"idStudent":17,"image_scan":"nesciunt"}'

```

```javascript
const url = new URL(
    "http://localhost/api/scan-receipts"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idAcademicYear": 17,
    "idSchool": 11,
    "idStudent": 17,
    "image_scan": "nesciunt"
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
    'http://localhost/api/scan-receipts',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idAcademicYear' => 17,
            'idSchool' => 11,
            'idStudent' => 17,
            'image_scan' => 'nesciunt',
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
<div id="execution-results-POSTapi-scan-receipts" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-scan-receipts"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-scan-receipts"></code></pre>
</div>
<div id="execution-error-POSTapi-scan-receipts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-scan-receipts"></code></pre>
</div>
<form id="form-POSTapi-scan-receipts" data-method="POST" data-path="api/scan-receipts" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-scan-receipts', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/scan-receipts</code></b>
</p>
<p>
<label id="auth-POSTapi-scan-receipts" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-scan-receipts" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idAcademicYear</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAcademicYear" data-endpoint="POSTapi-scan-receipts" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-scan-receipts" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-scan-receipts" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>image_scan</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="image_scan" data-endpoint="POSTapi-scan-receipts" data-component="body" required  hidden>
<br>

</p>

</form>


## Affiche les détails d&#039;un reçu scanné.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/scan-receipts/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/scan-receipts/et"
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
    'http://localhost/api/scan-receipts/et',
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
<div id="execution-results-GETapi-scan-receipts--scan_receipt-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-scan-receipts--scan_receipt-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-scan-receipts--scan_receipt-"></code></pre>
</div>
<div id="execution-error-GETapi-scan-receipts--scan_receipt-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-scan-receipts--scan_receipt-"></code></pre>
</div>
<form id="form-GETapi-scan-receipts--scan_receipt-" data-method="GET" data-path="api/scan-receipts/{scan_receipt}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-scan-receipts--scan_receipt-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/scan-receipts/{scan_receipt}</code></b>
</p>
<p>
<label id="auth-GETapi-scan-receipts--scan_receipt-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-scan-receipts--scan_receipt-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>scan_receipt</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="scan_receipt" data-endpoint="GETapi-scan-receipts--scan_receipt-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met à jour un reçu scanné existant.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/scan-receipts/dignissimos" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idAcademicYear":13,"idSchool":2,"idStudent":14,"image_scan":"facere"}'

```

```javascript
const url = new URL(
    "http://localhost/api/scan-receipts/dignissimos"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idAcademicYear": 13,
    "idSchool": 2,
    "idStudent": 14,
    "image_scan": "facere"
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
    'http://localhost/api/scan-receipts/dignissimos',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idAcademicYear' => 13,
            'idSchool' => 2,
            'idStudent' => 14,
            'image_scan' => 'facere',
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
<div id="execution-results-PUTapi-scan-receipts--scan_receipt-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-scan-receipts--scan_receipt-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-scan-receipts--scan_receipt-"></code></pre>
</div>
<div id="execution-error-PUTapi-scan-receipts--scan_receipt-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-scan-receipts--scan_receipt-"></code></pre>
</div>
<form id="form-PUTapi-scan-receipts--scan_receipt-" data-method="PUT" data-path="api/scan-receipts/{scan_receipt}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-scan-receipts--scan_receipt-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/scan-receipts/{scan_receipt}</code></b>
</p>
<p>
<label id="auth-PUTapi-scan-receipts--scan_receipt-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-scan-receipts--scan_receipt-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>scan_receipt</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="scan_receipt" data-endpoint="PUTapi-scan-receipts--scan_receipt-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idAcademicYear</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idAcademicYear" data-endpoint="PUTapi-scan-receipts--scan_receipt-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-scan-receipts--scan_receipt-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="PUTapi-scan-receipts--scan_receipt-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>image_scan</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image_scan" data-endpoint="PUTapi-scan-receipts--scan_receipt-" data-component="body"  hidden>
<br>

</p>

</form>


## Met un ou plusieurs reçus scannés à la corbeille.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/scan-receipts/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[2,1]}'

```

```javascript
const url = new URL(
    "http://localhost/api/scan-receipts/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        2,
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
    'http://localhost/api/scan-receipts/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                2,
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
<div id="execution-results-POSTapi-scan-receipts-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-scan-receipts-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-scan-receipts-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-scan-receipts-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-scan-receipts-trash"></code></pre>
</div>
<form id="form-POSTapi-scan-receipts-trash" data-method="POST" data-path="api/scan-receipts/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-scan-receipts-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/scan-receipts/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-scan-receipts-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-scan-receipts-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-scan-receipts-trash" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-scan-receipts-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure un ou plusieurs reçus scannés depuis la corbeille.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/scan-receipts/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[11,12]}'

```

```javascript
const url = new URL(
    "http://localhost/api/scan-receipts/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        11,
        12
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
    'http://localhost/api/scan-receipts/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                11,
                12,
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
<div id="execution-results-POSTapi-scan-receipts-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-scan-receipts-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-scan-receipts-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-scan-receipts-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-scan-receipts-restore"></code></pre>
</div>
<form id="form-POSTapi-scan-receipts-restore" data-method="POST" data-path="api/scan-receipts/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-scan-receipts-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/scan-receipts/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-scan-receipts-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-scan-receipts-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-scan-receipts-restore" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-scan-receipts-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement un ou plusieurs reçus scannés.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/scan-receipts/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[14,15]}'

```

```javascript
const url = new URL(
    "http://localhost/api/scan-receipts/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        14,
        15
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
    'http://localhost/api/scan-receipts/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                14,
                15,
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
<div id="execution-results-POSTapi-scan-receipts-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-scan-receipts-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-scan-receipts-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-scan-receipts-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-scan-receipts-delete"></code></pre>
</div>
<form id="form-POSTapi-scan-receipts-delete" data-method="POST" data-path="api/scan-receipts/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-scan-receipts-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/scan-receipts/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-scan-receipts-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-scan-receipts-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-scan-receipts-delete" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-scan-receipts-delete" data-component="body" hidden>
<br>

</p>

</form>




# Avertissements
Gestion des avertissements

## Lister les avertissements

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/warningsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":8,"trashed":false,"date":"2025-11-22","pageItems":20,"nbreItems":20,"filter_value":"excepturi"}'

```

```javascript
const url = new URL(
    "http://localhost/api/warningsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 8,
    "trashed": false,
    "date": "2025-11-22",
    "pageItems": 20,
    "nbreItems": 20,
    "filter_value": "excepturi"
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
    'http://localhost/api/warningsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 8,
            'trashed' => false,
            'date' => '2025-11-22',
            'pageItems' => 20,
            'nbreItems' => 20,
            'filter_value' => 'excepturi',
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
<div id="execution-results-POSTapi-warningsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-warningsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-warningsall"></code></pre>
</div>
<div id="execution-error-POSTapi-warningsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-warningsall"></code></pre>
</div>
<form id="form-POSTapi-warningsall" data-method="POST" data-path="api/warningsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-warningsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/warningsall</code></b>
</p>
<p>
<label id="auth-POSTapi-warningsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-warningsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-warningsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-warningsall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-warningsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-warningsall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-warningsall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-warningsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-warningsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-warningsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-warningsall" data-component="body"  hidden>
<br>

</p>

</form>


## Ajouter un ou plusieurs avertissements

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/warnings" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"warnings":[{"idUser":9,"reason":"dicta","date":"2025-11-22"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/warnings"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "warnings": [
        {
            "idUser": 9,
            "reason": "dicta",
            "date": "2025-11-22"
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
    'http://localhost/api/warnings',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'warnings' => [
                [
                    'idUser' => 9,
                    'reason' => 'dicta',
                    'date' => '2025-11-22',
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
<div id="execution-results-POSTapi-warnings" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-warnings"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-warnings"></code></pre>
</div>
<div id="execution-error-POSTapi-warnings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-warnings"></code></pre>
</div>
<form id="form-POSTapi-warnings" data-method="POST" data-path="api/warnings" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-warnings', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/warnings</code></b>
</p>
<p>
<label id="auth-POSTapi-warnings" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-warnings" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>warnings</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>warnings[].idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="warnings.0.idUser" data-endpoint="POSTapi-warnings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>warnings[].reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="warnings.0.reason" data-endpoint="POSTapi-warnings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>warnings[].date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="warnings.0.date" data-endpoint="POSTapi-warnings" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
</details>
</p>

</form>


## Afficher les détails d&#039;un avertissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/warnings/excepturi" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/warnings/excepturi"
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
    'http://localhost/api/warnings/excepturi',
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
<div id="execution-results-GETapi-warnings--warning-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-warnings--warning-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-warnings--warning-"></code></pre>
</div>
<div id="execution-error-GETapi-warnings--warning-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-warnings--warning-"></code></pre>
</div>
<form id="form-GETapi-warnings--warning-" data-method="GET" data-path="api/warnings/{warning}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-warnings--warning-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/warnings/{warning}</code></b>
</p>
<p>
<label id="auth-GETapi-warnings--warning-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-warnings--warning-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>warning</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="warning" data-endpoint="GETapi-warnings--warning-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier les détails d&#039;un avertissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/warnings/molestiae" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":3,"reason":"quia","date":"2025-11-22"}'

```

```javascript
const url = new URL(
    "http://localhost/api/warnings/molestiae"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 3,
    "reason": "quia",
    "date": "2025-11-22"
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
    'http://localhost/api/warnings/molestiae',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 3,
            'reason' => 'quia',
            'date' => '2025-11-22',
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
<div id="execution-results-PUTapi-warnings--warning-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-warnings--warning-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-warnings--warning-"></code></pre>
</div>
<div id="execution-error-PUTapi-warnings--warning-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-warnings--warning-"></code></pre>
</div>
<form id="form-PUTapi-warnings--warning-" data-method="PUT" data-path="api/warnings/{warning}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-warnings--warning-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/warnings/{warning}</code></b>
</p>
<p>
<label id="auth-PUTapi-warnings--warning-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-warnings--warning-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>warning</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="warning" data-endpoint="PUTapi-warnings--warning-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="PUTapi-warnings--warning-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-warnings--warning-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="PUTapi-warnings--warning-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>

</form>


## Mettre un ou plusieurs produits en corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/warnings/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idWarnings":[20,11]}'

```

```javascript
const url = new URL(
    "http://localhost/api/warnings/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idWarnings": [
        20,
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
    'http://localhost/api/warnings/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idWarnings' => [
                20,
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
<div id="execution-results-POSTapi-warnings-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-warnings-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-warnings-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-warnings-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-warnings-trash"></code></pre>
</div>
<form id="form-POSTapi-warnings-trash" data-method="POST" data-path="api/warnings/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-warnings-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/warnings/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-warnings-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-warnings-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idWarnings</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idWarnings.0" data-endpoint="POSTapi-warnings-trash" data-component="body" required  hidden>
<input type="number" name="idWarnings.1" data-endpoint="POSTapi-warnings-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaurer un ou plusieurs produits de la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/warnings/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idWarnings":[13,20]}'

```

```javascript
const url = new URL(
    "http://localhost/api/warnings/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idWarnings": [
        13,
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
    'http://localhost/api/warnings/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idWarnings' => [
                13,
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
<div id="execution-results-POSTapi-warnings-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-warnings-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-warnings-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-warnings-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-warnings-restore"></code></pre>
</div>
<form id="form-POSTapi-warnings-restore" data-method="POST" data-path="api/warnings/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-warnings-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/warnings/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-warnings-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-warnings-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idWarnings</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idWarnings.0" data-endpoint="POSTapi-warnings-restore" data-component="body" required  hidden>
<input type="number" name="idWarnings.1" data-endpoint="POSTapi-warnings-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprimmer un ou plusieurs avertissement(s)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/warnings/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idWarnings":[10,15]}'

```

```javascript
const url = new URL(
    "http://localhost/api/warnings/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idWarnings": [
        10,
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
    'http://localhost/api/warnings/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idWarnings' => [
                10,
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
<div id="execution-results-POSTapi-warnings-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-warnings-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-warnings-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-warnings-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-warnings-delete"></code></pre>
</div>
<form id="form-POSTapi-warnings-delete" data-method="POST" data-path="api/warnings/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-warnings-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/warnings/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-warnings-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-warnings-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idWarnings</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="idWarnings.0" data-endpoint="POSTapi-warnings-delete" data-component="body" required  hidden>
<input type="number" name="idWarnings.1" data-endpoint="POSTapi-warnings-delete" data-component="body" hidden>
<br>

</p>

</form>




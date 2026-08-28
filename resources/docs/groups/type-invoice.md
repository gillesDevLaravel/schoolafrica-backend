# Type Invoice


## Lister tous les types d&#039;invoices créés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/typeinvoicesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/typeinvoicesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/typeinvoicesall',
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
<div id="execution-results-POSTapi-typeinvoicesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-typeinvoicesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-typeinvoicesall"></code></pre>
</div>
<div id="execution-error-POSTapi-typeinvoicesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-typeinvoicesall"></code></pre>
</div>
<form id="form-POSTapi-typeinvoicesall" data-method="POST" data-path="api/typeinvoicesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-typeinvoicesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/typeinvoicesall</code></b>
</p>
<p>
<label id="auth-POSTapi-typeinvoicesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-typeinvoicesall" data-component="header"></label>
</p>
</form>


## Afficher les détails d&#039;un type d&#039;invoice

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/typeinvoices/8" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/typeinvoices/8"
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
    'http://localhost/api/typeinvoices/8',
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
<div id="execution-results-GETapi-typeinvoices--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-typeinvoices--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-typeinvoices--id-"></code></pre>
</div>
<div id="execution-error-GETapi-typeinvoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-typeinvoices--id-"></code></pre>
</div>
<form id="form-GETapi-typeinvoices--id-" data-method="GET" data-path="api/typeinvoices/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-typeinvoices--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/typeinvoices/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-typeinvoices--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-typeinvoices--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-typeinvoices--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un nouveau type d&#039;invoice

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/typeinvoices" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type_invoices":[{"name":"nam","code":"quia","category":"maiores","idSchool":7}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/typeinvoices"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type_invoices": [
        {
            "name": "nam",
            "code": "quia",
            "category": "maiores",
            "idSchool": 7
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
    'http://localhost/api/typeinvoices',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'type_invoices' => [
                [
                    'name' => 'nam',
                    'code' => 'quia',
                    'category' => 'maiores',
                    'idSchool' => 7,
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
<div id="execution-results-POSTapi-typeinvoices" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-typeinvoices"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-typeinvoices"></code></pre>
</div>
<div id="execution-error-POSTapi-typeinvoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-typeinvoices"></code></pre>
</div>
<form id="form-POSTapi-typeinvoices" data-method="POST" data-path="api/typeinvoices" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-typeinvoices', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/typeinvoices</code></b>
</p>
<p>
<label id="auth-POSTapi-typeinvoices" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-typeinvoices" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>type_invoices</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>type_invoices[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type_invoices.0.name" data-endpoint="POSTapi-typeinvoices" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type_invoices[].code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type_invoices.0.code" data-endpoint="POSTapi-typeinvoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type_invoices[].category</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type_invoices.0.category" data-endpoint="POSTapi-typeinvoices" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type_invoices[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="type_invoices.0.idSchool" data-endpoint="POSTapi-typeinvoices" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Mettre à jour le nom d&#039;un type d&#039;invoice

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/typeinvoices/12" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type_invoices":[{"name":"molestiae","code":"eveniet","category":"quidem","idSchool":1}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/typeinvoices/12"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type_invoices": [
        {
            "name": "molestiae",
            "code": "eveniet",
            "category": "quidem",
            "idSchool": 1
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
    'http://localhost/api/typeinvoices/12',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'type_invoices' => [
                [
                    'name' => 'molestiae',
                    'code' => 'eveniet',
                    'category' => 'quidem',
                    'idSchool' => 1,
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
<div id="execution-results-PUTapi-typeinvoices--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-typeinvoices--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-typeinvoices--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-typeinvoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-typeinvoices--id-"></code></pre>
</div>
<form id="form-PUTapi-typeinvoices--id-" data-method="PUT" data-path="api/typeinvoices/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-typeinvoices--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/typeinvoices/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-typeinvoices--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-typeinvoices--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="PUTapi-typeinvoices--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>type_invoices</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>type_invoices[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type_invoices.0.name" data-endpoint="PUTapi-typeinvoices--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type_invoices[].code</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type_invoices.0.code" data-endpoint="PUTapi-typeinvoices--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type_invoices[].category</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type_invoices.0.category" data-endpoint="PUTapi-typeinvoices--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type_invoices[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="type_invoices.0.idSchool" data-endpoint="PUTapi-typeinvoices--id-" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Supprimer un type d&#039;invoice (NB: Seulement si il n&#039;a pas de invoice associé)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/typeinvoices/2" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/typeinvoices/2"
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
    'http://localhost/api/typeinvoices/2',
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
<div id="execution-results-DELETEapi-typeinvoices--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-typeinvoices--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-typeinvoices--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-typeinvoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-typeinvoices--id-"></code></pre>
</div>
<form id="form-DELETEapi-typeinvoices--id-" data-method="DELETE" data-path="api/typeinvoices/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-typeinvoices--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/typeinvoices/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-typeinvoices--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-typeinvoices--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="DELETEapi-typeinvoices--id-" data-component="url" required  hidden>
<br>

</p>
</form>



